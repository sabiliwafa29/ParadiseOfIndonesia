<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TravelServiceBooking;
use App\Services\MidtransService;
use App\Services\OrderIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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
            $paymentType = $notif['payment_type'] ?? null;
            $transactionId = $notif['transaction_id'] ?? null;

            Log::info("Processing notification - Order ID: {$orderId}, Status: {$transactionStatus}, Payment Type: {$paymentType}");

            // Cari booking berdasarkan order_id (support untuk Booking dan TravelServiceBooking)
            $booking = null;
            
            // Prioritas 1: Cari berdasarkan order_id langsung (untuk package bookings yang pakai OrderIdService)
            $booking = Booking::where('order_id', $orderId)->first();
            
            if (!$booking) {
                // Prioritas 2: Cari di TravelServiceBooking
                $booking = TravelServiceBooking::where('order_id', $orderId)->first();
            }
            
            // Prioritas 3: Fallback untuk format lama BOOK-{id}
            if (!$booking && str_starts_with($orderId, 'BOOK-')) {
                $bookingId = (int) str_replace('BOOK-', '', $orderId);
                $booking = Booking::find($bookingId);
            }
            
            // Prioritas 4: Cari berdasarkan payment_id
            if (!$booking) {
                $booking = Booking::where('payment_id', $orderId)->first();
                if (!$booking) {
                    $booking = TravelServiceBooking::where('order_id', $orderId)->first();
                }
            }

            if (!$booking) {
                Log::warning("Booking not found for Order ID: {$orderId}");
                // Return 200 agar Midtrans tidak retry, tapi tandai sebagai not found
                return response()->json([
                    'success' => true, 
                    'message' => 'Notification received but booking not found',
                    'order_id' => $orderId
                ], 200);
            }


            // Update status booking berdasarkan notifikasi
            $bookingId = $booking->id;
            $bookingType = $booking instanceof TravelServiceBooking ? 'TravelServiceBooking' : 'Booking';
            
            switch ($transactionStatus) {
                case 'capture':
                    // Untuk kartu kredit, cek fraud_status
                    if ($fraudStatus == 'accept') {
                        $updateData = [
                            'payment_status' => 'paid',
                            'status' => 'confirmed',
                            'payment_id' => $transactionId ?? $orderId,
                        ];
                        if (Schema::hasColumn('bookings', 'payment_method')) {
                            $updateData['payment_method'] = $paymentType;
                        }
                        $booking->update($updateData);
                        Log::info("{$bookingType} {$bookingId} confirmed (capture + accept)");
                    } else {
                        $updateData = [
                            'payment_status' => 'pending',
                            'payment_id' => $transactionId ?? $orderId,
                        ];
                        if (Schema::hasColumn('bookings', 'payment_method')) {
                            $updateData['payment_method'] = $paymentType;
                        }
                        $booking->update($updateData);
                        Log::info("{$bookingType} {$bookingId} pending (capture + challenge)");
                    }
                    break;

                case 'settlement':
                    $updateData = [
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'payment_id' => $transactionId ?? $orderId,
                    ];
                    if (Schema::hasColumn('bookings', 'payment_method')) {
                        $updateData['payment_method'] = $paymentType;
                    }
                    $booking->update($updateData);
                    Log::info("{$bookingType} {$bookingId} confirmed (settlement)");
                    break;

                case 'pending':
                    $updateData = [
                        'payment_status' => 'pending',
                        'payment_id' => $transactionId ?? $orderId,
                    ];
                    if (Schema::hasColumn('bookings', 'payment_method')) {
                        $updateData['payment_method'] = $paymentType;
                    }
                    $booking->update($updateData);
                    Log::info("{$bookingType} {$bookingId} pending");
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $updateData = [
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                        'payment_id' => $transactionId ?? $orderId,
                    ];
                    if (Schema::hasColumn('bookings', 'payment_method')) {
                        $updateData['payment_method'] = $paymentType;
                    }
                    $booking->update($updateData);
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