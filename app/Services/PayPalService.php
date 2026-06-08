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
    protected $lastError;
    protected $lastDebugId;
    protected $lastInfoLink;

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
                // Try to extract a friendly message from the response
                $body = null;
                try {
                    $body = $response->json();
                } catch (\Exception $e) {
                    $body = null;
                }

                if (is_array($body)) {
                    $this->lastError = $body['error_description'] ?? $body['message'] ?? json_encode($body);
                    $this->lastDebugId = $body['debug_id'] ?? null;
                    // Extract info link if provided
                    if (!empty($body['links']) && is_array($body['links'])) {
                        foreach ($body['links'] as $link) {
                            if (!empty($link['rel']) && strtolower($link['rel']) === 'information_link') {
                                $this->lastInfoLink = $link['href'] ?? null;
                                break;
                            }
                        }
                    }
                } else {
                    $this->lastError = $response->body();
                    $this->lastDebugId = null;
                    $this->lastInfoLink = null;
                }

                return null;
            }

            $this->lastError = null;
            return $response->json('access_token');
        } catch (\Exception $e) {
            Log::error('❌ [PAYPAL] Token exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $this->lastError = $e->getMessage();
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

                // Extract friendly error message
                try {
                    $body = $response->json();
                } catch (\Exception $e) {
                    $body = null;
                }

                if (is_array($body)) {
                    $this->lastError = $body['message'] ?? ($body['details'][0]['description'] ?? json_encode($body));
                    $this->lastDebugId = $body['debug_id'] ?? null;
                    if (!empty($body['links']) && is_array($body['links'])) {
                        foreach ($body['links'] as $link) {
                            if (!empty($link['rel']) && strtolower($link['rel']) === 'information_link') {
                                $this->lastInfoLink = $link['href'] ?? null;
                                break;
                            }
                        }
                    }
                } else {
                    $this->lastError = $response->body();
                    $this->lastDebugId = null;
                    $this->lastInfoLink = null;
                }

                return null;
            }

            $this->lastError = null;
            return $response->json();
        } catch (\Exception $e) {
            Log::error('❌ [PAYPAL] Create order exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $this->lastError = $e->getMessage();
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

                try {
                    $body = $response->json();
                } catch (\Exception $e) {
                    $body = null;
                }

                if (is_array($body)) {
                    $this->lastError = $body['message'] ?? ($body['details'][0]['description'] ?? json_encode($body));
                    $this->lastDebugId = $body['debug_id'] ?? null;
                    if (!empty($body['links']) && is_array($body['links'])) {
                        foreach ($body['links'] as $link) {
                            if (!empty($link['rel']) && strtolower($link['rel']) === 'information_link') {
                                $this->lastInfoLink = $link['href'] ?? null;
                                break;
                            }
                        }
                    }
                } else {
                    $this->lastError = $response->body();
                    $this->lastDebugId = null;
                    $this->lastInfoLink = null;
                }

                return null;
            }

            $this->lastError = null;
            return $response->json();
        } catch (\Exception $e) {
            Log::error('❌ [PAYPAL] Capture order exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $this->lastError = $e->getMessage();
            $this->lastDebugId = null;
            $this->lastInfoLink = null;
            return null;
        }
    }

    /**
     * Get last friendly error message for debugging (do not expose secrets)
     *
     * @return string|null
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Get PayPal debug id returned from PayPal responses (if any)
     *
     * @return string|null
     */
    public function getLastDebugId()
    {
        return $this->lastDebugId;
    }

    /**
     * Get PayPal information link from last response (if provided)
     *
     * @return string|null
     */
    public function getLastInfoLink()
    {
        return $this->lastInfoLink;
    }
}
