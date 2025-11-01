<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($booking)
    {
        $booking->load('user'); // Eager load the user relationship

        $params = [
            'transaction_details' => [
                'order_id' => $booking->id,
                'gross_amount' => $booking->total_price,
            ],
            'item_details' => [
                [
                    'price'    => $booking->total_price,
                    'quantity' => 1,
                    'name'     => 'Tour: ' . $booking->tour->name . ' (' . $booking->guests . ' guests)',
                ]
            ],

            // 2. Detail Pelanggan (Siapa yang membeli)
            'customer_details' => [
                'first_name' => $booking->user->name, // Asumsi Anda punya relasi 'user'
                'email'      => $booking->user->email,
                'phone'      => $booking->user->phone, // Asumsi Anda punya 'phone' di model User
            ],

            // 3. Filter Metode Pembayaran (Metode apa yang ingin ditampilkan)
            'enabled_payments' => [
                'qris',
                'bca_va',
                'bni_va',
                'bri_va',
                'mandiri_va',
                'gopay',
                'shopeepay'
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            return null;
        }
    }

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
            'fraud_status' => $fraud
        ];
    }
}
