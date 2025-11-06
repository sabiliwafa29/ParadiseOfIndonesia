<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\MidtransService;
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

            // Ekstrak booking ID dari order_id (format: BOOK-123 -> 123)
            $bookingId = (int) str_replace('BOOK-', '', $orderId);

            // ✅ PERBAIKAN: Gunakan $bookingId untuk mencari booking
            $booking = Booking::find($bookingId);

            if (!$booking) {
                Log::warning("Booking not found for Order ID: {$orderId}, extracted ID: {$bookingId}");
                return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
            }


            // Update status booking berdasarkan notifikasi
            switch ($transactionStatus) {
                case 'capture':
                    // Untuk kartu kredit, cek fraud_status
                    if ($fraudStatus == 'accept') {
                        $booking->update([
                            'payment_status' => 'paid',
                            'status' => 'confirmed',
                        ]);
                        Log::info("Booking {$bookingId} confirmed (capture + accept)");
                    } else {
                        $booking->update([
                            'payment_status' => 'pending',
                        ]);
                        Log::info("Booking {$bookingId} pending (capture + challenge)");
                    }
                    break;

                case 'settlement':
                    $booking->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                    ]);
                    Log::info("Booking {$bookingId} confirmed (settlement)");
                    break;

                case 'pending':
                    $booking->update([
                        'payment_status' => 'pending',
                    ]);
                    Log::info("Booking {$bookingId} pending");
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $booking->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                    ]);
                    Log::info("Booking {$bookingId} cancelled ({$transactionStatus})");
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