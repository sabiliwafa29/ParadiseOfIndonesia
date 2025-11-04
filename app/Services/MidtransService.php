<?php

namespace App\Services;

use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Membuat transaksi dan Snap Token dari Booking
     */
    public function createTransaction($booking)
    {
        $booking->load('user', 'tour');

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount' => (int) $booking->total_price,
            ],
            'item_details' => [
                [
                    'id'       => $booking->tour->id,
                    'price'    => (int) $booking->total_price,
                    'quantity' => 1,
                    'name'     => 'Tour: ' . $booking->tour->name . ' (' . $booking->guests . ' guests)',
                ],
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Guest',
                'email'      => $booking->user->email ?? 'noemail@example.com',
                'phone'      => $booking->user->phone ?? '08123456789',
            ],
            'enabled_payments' => [
                'qris', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'gopay', 'shopeepay',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            Log::info('Midtrans token generated', [
                'token' => $snapToken,
                'order_id' => $params['transaction_details']['order_id'],
            ]);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Menangani notifikasi dari Midtrans (webhook)
     */
    public function handleNotification($notification)
    {
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        return [
            'transaction_status' => $transaction,
            'payment_type' => $type,
            'order_id' => $orderId,
            'fraud_status' => $fraud,
        ];
    }

    public function testConnection()
{
    try {
        $params = [
            'transaction_details' => [
                'order_id' => 'TEST-' . time(),
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => 'Test',
                'email' => 'test@example.com',
            ],
        ];

        $token = \Midtrans\Snap::getSnapToken($params);

        return [
            'success' => true,
            'message' => 'Koneksi ke Midtrans BERHASIL ✅',
            'snap_token' => $token,
            'environment' => Config::$isProduction ? 'PRODUCTION' : 'SANDBOX',
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Gagal konek ke Midtrans ❌',
            'error' => $e->getMessage(),
            'environment' => Config::$isProduction ? 'PRODUCTION' : 'SANDBOX',
            'server_key' => substr(Config::$serverKey, 0, 10) . '...', // potong biar aman
        ];
    }
}

}
