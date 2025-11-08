<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TravelServiceBooking;
use App\Services\MidtransService;
use App\Services\OrderIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Generate Snap Token untuk 1 booking
     */
    public function getSnapToken(Booking $booking)
    {
        try {
            // Pastikan relasi user dan tour sudah diload
            $booking->load('user', 'tour');

            $snapToken = $this->midtransService->createTransaction($booking);

            if (!$snapToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat Snap Token, periksa konfigurasi Midtrans',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'client_key' => config('services.midtrans.client_key'),
            ]);
        } catch (\Throwable $th) {
            Log::error('Midtrans Error: '.$th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat transaksi',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Terima notifikasi dari Midtrans (Webhook)
     */
    public function handleNotification(Request $request)
    {
        try {
            // Log semua data yang masuk untuk debugging
            Log::info('Midtrans Notification Received:', $request->all());

            // Gunakan service untuk handle notifikasi
            $notif = $this->midtransService->handleNotification($request);

            // ✅ PERBAIKAN: Ambil order_id dulu, baru ekstrak booking_id
            $orderId = $notif['order_id'];
            $transactionStatus = $notif['transaction_status'];
            $fraudStatus = $notif['fraud_status'] ?? 'accept';

            Log::info("Processing notification - Order ID: {$orderId}, Status: {$transactionStatus}");

            // Cari booking berdasarkan order_id (support untuk Booking dan TravelServiceBooking)
            $booking = null;
            
            // Coba cari di Booking table (format: BOOK-{id})
            if (str_starts_with($orderId, 'BOOK-')) {
                $bookingId = (int) str_replace('BOOK-', '', $orderId);
                $booking = Booking::find($bookingId);
            }
            
            // Coba cari di TravelServiceBooking table (format: TSB-{timestamp}-{random})
            if (!$booking && str_starts_with($orderId, 'TSB-')) {
                $booking = TravelServiceBooking::where('order_id', $orderId)->first();
            }
            
            // Fallback: cari berdasarkan order_id di kedua table
            if (!$booking) {
                $booking = Booking::where('payment_id', $orderId)->first();
                if (!$booking) {
                    $booking = TravelServiceBooking::where('order_id', $orderId)->first();
                }
            }

            if (!$booking) {
                Log::warning("Booking not found for Order ID: {$orderId}");
                return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
            }


            // Update status booking berdasarkan notifikasi
            $bookingId = $booking->id;
            $bookingType = $booking instanceof TravelServiceBooking ? 'TravelServiceBooking' : 'Booking';
            
            switch ($transactionStatus) {
                case 'capture':
                    // Untuk kartu kredit, cek fraud_status
                    if ($fraudStatus == 'accept') {
                        $booking->update([
                            'payment_status' => 'paid',
                            'status' => 'confirmed',
                            'payment_id' => $orderId,
                        ]);
                        Log::info("{$bookingType} {$bookingId} confirmed (capture + accept)");
                    } else {
                        $booking->update([
                            'payment_status' => 'pending',
                            'payment_id' => $orderId,
                        ]);
                        Log::info("{$bookingType} {$bookingId} pending (capture + challenge)");
                    }
                    break;

                case 'settlement':
                    $booking->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'payment_id' => $orderId,
                    ]);
                    Log::info("{$bookingType} {$bookingId} confirmed (settlement)");
                    break;

                case 'pending':
                    $booking->update([
                        'payment_status' => 'pending',
                        'payment_id' => $orderId,
                    ]);
                    Log::info("{$bookingType} {$bookingId} pending");
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $booking->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                        'payment_id' => $orderId,
                    ]);
                    Log::info("{$bookingType} {$bookingId} cancelled ({$transactionStatus})");
                    break;

                default:
                    Log::warning("Unknown transaction status: {$transactionStatus}");
            }

            return response()->json(['success' => true, 'message' => 'Notification processed']);
        } catch (\Throwable $th) {
            Log::error('Midtrans Notification Error: '.$th->getMessage());
            Log::error('Stack trace: '.$th->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses notifikasi',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}