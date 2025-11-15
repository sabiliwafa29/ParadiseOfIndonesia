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
        // Load relationships based on booking type
        if (method_exists($booking, 'tour')) {
            $booking->load('user', 'tour');
        } else {
            $booking->load('user', 'travelService');
        }

        // Gunakan order_id dari booking jika sudah ada, atau generate baru
        $orderId = $booking->order_id ?? ('BOOK-' . $booking->id);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'item_details' => [
                [
                    'id'       => $booking->tour->id ?? $booking->travelService->id ?? $booking->id,
                    'price'    => (int) $booking->total_price,
                    'quantity' => 1,
                    'name'     => isset($booking->tour) 
                        ? 'Tour: ' . $booking->tour->name . ' (' . $booking->guests . ' guests)'
                        : 'Travel Service: ' . ($booking->travelService->name ?? 'Service'),
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

        // Add Sentry breadcrumbs/context if available
        if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
            try {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($booking, $orderId): void {
                    $scope->setContext('midtrans_transaction', [
                        'order_id' => $orderId,
                        'booking_id' => $booking->id ?? null,
                        'amount' => (int) $booking->total_price,
                    ]);

                    $scope->addBreadcrumb(new \Sentry\Breadcrumb([
                        'message' => 'Midtrans createTransaction invoked',
                        'category' => 'payment',
                        'data' => ['order_id' => $orderId],
                        'level' => \Sentry\Severity::info(),
                    ]));
                });
            } catch (\Throwable $e) {
                // ignore Sentry configuration errors
            }
        }

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            Log::info('Midtrans token generated', [
                'token' => $snapToken,
                'order_id' => $orderId,
                'booking_id' => $booking->id,
            ]);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans error: ' . $e->getMessage());
            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                try {
                    \Sentry\captureException($e);
                } catch (\Throwable $sentryEx) {
                    Log::error('Failed to send Midtrans exception to Sentry: ' . $sentryEx->getMessage());
                }
            }
            return null;
        }
    }

    /**
     * Menangani notifikasi dari Midtrans (webhook)
     */
    public function handleNotification($notification)
    {
        try {
            $notif = new \Midtrans\Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;

            // Breadcrumb + context for Sentry
            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                try {
                    \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($orderId, $transaction, $type, $fraud): void {
                        $scope->setContext('midtrans_notification', [
                            'order_id' => $orderId,
                            'transaction_status' => $transaction,
                            'payment_type' => $type,
                            'fraud_status' => $fraud,
                        ]);

                        $scope->addBreadcrumb(new \Sentry\Breadcrumb([
                            'message' => 'Midtrans notification received',
                            'category' => 'payment',
                            'data' => ['order_id' => $orderId, 'status' => $transaction],
                            'level' => \Sentry\Severity::info(),
                        ]));
                    });
                } catch (\Throwable $e) {
                    // ignore Sentry scope errors
                }
            }

            Log::info('Midtrans notification parsed', [
                'order_id' => $orderId,
                'transaction_status' => $transaction,
                'payment_type' => $type,
                'fraud_status' => $fraud,
            ]);

            return [
                'transaction_status' => $transaction,
                'payment_type' => $type,
                'order_id' => $orderId,
                'fraud_status' => $fraud,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to parse Midtrans notification: ' . $e->getMessage());
            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                try {
                    \Sentry\captureException($e);
                } catch (\Throwable $sentryEx) {
                    Log::error('Failed to send Midtrans notification exception to Sentry: ' . $sentryEx->getMessage());
                }
            }
            throw $e;
        }
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