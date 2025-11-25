<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PayPalService
{
    protected $clientId;
    protected $secret;
    protected $isProduction;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->secret = config('services.paypal.secret');
        $this->isProduction = config('services.paypal.is_production', false);
        $this->baseUrl = $this->isProduction ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';

        Log::info('🔧 [PAYPAL] PayPalService initialized', [
            'client_id_set' => !empty($this->clientId),
            'is_production' => $this->isProduction,
            'base_url' => $this->baseUrl,
        ]);
    }

    protected function getAccessToken()
    {
        try {
            $response = Http::asForm()->withBasicAuth($this->clientId, $this->secret)
                ->post($this->baseUrl . '/v1/oauth2/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->failed()) {
                Log::error('❌ [PAYPAL] Token request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return null;
            }

            return $response->json('access_token');
        } catch (\Exception $e) {
            Log::error('❌ [PAYPAL] Token exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return null;
        }
    }

    public function createOrder($booking, string $currencyCode)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        $amount = number_format((float) $booking->total_price, 2, '.', '');

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $booking->order_id ?? ('BOOK-' . $booking->id),
                    'amount' => [
                        'currency_code' => $currencyCode,
                        'value' => (string) $amount,
                    ],
                ],
            ],
            'application_context' => [
                'brand_name' => config('app.name'),
                'landing_page' => 'NO_PREFERENCE',
                'user_action' => 'PAY_NOW',
                'return_url' => route('bookings.payment', $booking),
                'cancel_url' => route('bookings.payment', $booking),
            ],
        ];

        try {
            $response = Http::withToken($token)
                ->post($this->baseUrl . '/v2/checkout/orders', $payload);

            if ($response->failed()) {
                Log::error('❌ [PAYPAL] Create order failed', ['status' => $response->status(), 'body' => $response->body(), 'booking_id' => $booking->id]);
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('❌ [PAYPAL] Create order exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return null;
        }
    }

    public function captureOrder(string $orderId)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        try {
            $response = Http::withToken($token)
                ->post($this->baseUrl . '/v2/checkout/orders/' . $orderId . '/capture');

            if ($response->failed()) {
                Log::error('❌ [PAYPAL] Capture order failed', ['status' => $response->status(), 'body' => $response->body(), 'order_id' => $orderId]);
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('❌ [PAYPAL] Capture order exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return null;
        }
    }
}
