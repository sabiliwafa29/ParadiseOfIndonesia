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
            // Gunakan service untuk handle notifikasi
            $notif = $this->midtransService->handleNotification($request);

            // MidtransService mengembalikan array (lihat versi kamu sebelumnya)
            $bookingId = (int) filter_var($orderId, FILTER_SANITIZE_NUMBER_INT);
            $orderId = $notif['order_id'];
            $transactionStatus = $notif['transaction_status'];

            $booking = Booking::find($orderId);

            if (!$booking) {
                return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
            }

            // Update status booking berdasarkan notifikasi
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    $booking->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                    ]);
                    break;

                case 'pending':
                    $booking->update([
                        'payment_status' => 'pending',
                    ]);
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $booking->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                    ]);
                    break;
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            Log::error('Midtrans Notification Error: '.$th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses notifikasi',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
