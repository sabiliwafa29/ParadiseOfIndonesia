<?php

namespace App\Services;

use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production', false);

        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        Log::info('Midtrans configured', [
            'server_key_set' => !empty($serverKey),
            'is_production' => $isProduction,
        ]);
    }

    public function createTransaction($booking): ?string
    {
        $params = $this->buildTransactionParams($booking);

        try {
            Log::info('Midtrans createTransaction called', ['booking_id' => $booking->id]);

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Log::info('Midtrans token generated successfully', [
                'token_length' => strlen($snapToken),
                'order_id' => $booking->order_id,
            ]);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans error: ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'order_id' => $booking->order_id,
            ]);

            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                \Sentry\captureException($e);
            }

            return null;
        }
    }

    protected function buildTransactionParams($booking): array
    {
        $booking->load('user', 'tour', 'package');

        $itemId = $booking->id;
        $itemName = 'Booking';

        if (isset($booking->tour)) {
            $itemId = $booking->tour->id;
            $itemName = 'Tour: ' . $booking->tour->name . ' (' . $booking->guests . ' guests)';
        } elseif (isset($booking->package)) {
            $itemId = $booking->package->id;
            $itemName = 'Package: ' . $booking->package->name . ' (' . $booking->guests . ' guests)';
        } elseif (isset($booking->travelService)) {
            $itemId = $booking->travelService->id;
            $itemName = 'Travel Service: ' . $booking->travelService->name;
        }

        $orderId = $booking->order_id ?? ('BOOK-' . $booking->id);

        return [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'item_details' => [
                [
                    'id' => $itemId,
                    'price' => (int) $booking->total_price,
                    'quantity' => 1,
                    'name' => $itemName,
                ],
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? $booking->full_name ?? 'Guest',
                'email' => $booking->user->email ?? $booking->email ?? 'noemail@example.com',
                'phone' => $booking->user->phone ?? $booking->contact_handle ?? '08123456789',
            ],
            'enabled_payments' => ['qris', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'gopay', 'shopeepay'],
        ];
    }

    public function handleNotification($notification): array
    {
        try {
            $notif = new \Midtrans\Notification();

            $result = [
                'transaction_status' => $notif->transaction_status,
                'payment_type' => $notif->payment_type,
                'order_id' => $notif->order_id,
                'fraud_status' => $notif->fraud_status,
            ];

            Log::info('Midtrans notification parsed', $result);
            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to parse Midtrans notification: ' . $e->getMessage());
            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                \Sentry\captureException($e);
            }
            throw $e;
        }
    }

    public function testConnection(): array
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
                'message' => 'Midtrans connection successful',
                'snap_token' => $token,
                'environment' => Config::$isProduction ? 'PRODUCTION' : 'SANDBOX',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to connect to Midtrans',
                'error' => $e->getMessage(),
                'environment' => Config::$isProduction ? 'PRODUCTION' : 'SANDBOX',
            ];
        }
    }
}