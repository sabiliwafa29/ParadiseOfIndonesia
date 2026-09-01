<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PayPalService
{
    protected string $clientId;
    protected string $secret;
    protected bool $isProduction;
    protected string $baseUrl;
    protected ?string $lastError = null;
    protected ?string $lastDebugId = null;
    protected ?string $lastInfoLink = null;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->secret = config('services.paypal.secret');
        $this->isProduction = config('services.paypal.is_production', false);
        $this->baseUrl = $this->isProduction
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';

        Log::info('PayPalService initialized', [
            'client_id_set' => !empty($this->clientId),
            'is_production' => $this->isProduction,
        ]);
    }

    protected function getAccessToken(): ?string
    {
        try {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->secret)
                ->post($this->baseUrl . '/v1/oauth2/token', ['grant_type' => 'client_credentials']);

            if ($response->failed()) {
                Log::error('PayPal token request failed', ['status' => $response->status()]);
                return null;
            }

            $this->lastError = null;
            return $response->json('access_token');
        } catch (\Exception $e) {
            Log::error('PayPal token exception: ' . $e->getMessage());
            $this->lastError = $e->getMessage();
            return null;
        }
    }

    protected function parseErrorResponse($response): void
    {
        $body = null;
        try {
            $body = $response->json();
        } catch (\Exception $e) {
            $body = null;
        }

        if (is_array($body)) {
            $this->lastError = $body['error_description'] ?? $body['message'] ?? json_encode($body);
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
                Log::error('PayPal create order failed', ['status' => $response->status()]);
                $this->parseErrorResponse($response);
                return null;
            }

            $this->lastError = null;
            return $response->json();
        } catch (\Exception $e) {
            Log::error('PayPal create order exception: ' . $e->getMessage());
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
                Log::error('PayPal capture order failed', ['status' => $response->status()]);
                $this->parseErrorResponse($response);
                return null;
            }

            $this->lastError = null;
            return $response->json();
        } catch (\Exception $e) {
            Log::error('PayPal capture order exception: ' . $e->getMessage());
            $this->lastError = $e->getMessage();
            return null;
        }
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    public function getLastDebugId(): ?string
    {
        return $this->lastDebugId;
    }

    public function getLastInfoLink(): ?string
    {
        return $this->lastInfoLink;
    }
}