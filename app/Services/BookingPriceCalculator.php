<?php

namespace App\Services;

use App\Helpers\LanguageHelper;
use Illuminate\Support\Facades\Log;

class BookingPriceCalculator
{
    protected float $guidePricePerGuest;
    protected float $transportPricePerGuest;

    public function __construct()
    {
        $this->guidePricePerGuest = (float) config('booking.addon_prices.guide', 50);
        $this->transportPricePerGuest = (float) config('booking.addon_prices.transport', 30);
    }

    public function calculateTourBooking(array $data, object $tour): array
    {
        $basePrice = $this->getPriceForTour($tour, $data['guests']);
        $addonCost = $this->calculateAddons($data['guests'], $data['guide'] ?? false, $data['transport'] ?? false);
        $currency = LanguageHelper::getCurrentCurrency();

        return [
            'base_price' => $basePrice,
            'addon_cost' => $addonCost,
            'total_price' => $basePrice + $addonCost,
            'currency' => $currency,
        ];
    }

    public function calculatePackageBooking(float $packagePrice, int $guests, bool $guide, bool $transport, ?string $specialLinkToken = null): array
    {
        $basePrice = $packagePrice * $guests;
        $addonCost = $this->calculateAddons($guests, $guide, $transport);
        $currency = LanguageHelper::getCurrentCurrency();

        if ($specialLinkToken) {
            $adjustedPrice = $this->applySpecialLinkPrice($specialLinkToken, $basePrice, $guests);
            if ($adjustedPrice !== null) {
                $basePrice = $adjustedPrice;
            }
        }

        return [
            'base_price' => $basePrice,
            'addon_cost' => $addonCost,
            'total_price' => $basePrice + $addonCost,
            'currency' => $currency,
        ];
    }

    protected function getPriceForTour(object $tour, int $guests): float
    {
        $currency = LanguageHelper::getCurrentCurrency();
        $price = match($currency) {
            'IDR' => $tour->price_idr ?? $tour->price ?? 0,
            'CNY' => $tour->price_cny ?? $tour->price ?? 0,
            'USD' => $tour->price_usd ?? $tour->price ?? 0,
            default => $tour->price_usd ?? $tour->price ?? 0,
        };
        return (float) $price * $guests;
    }

    protected function calculateAddons(int $guests, bool $guide, bool $transport): float
    {
        $guideCost = $guide ? $this->guidePricePerGuest * $guests : 0;
        $transportCost = $transport ? $this->transportPricePerGuest * $guests : 0;
        return $guideCost + $transportCost;
    }

    protected function applySpecialLinkPrice(?string $token, float $basePrice, int $guests): ?float
    {
        if (!$token) {
            return null;
        }

        $link = \App\Models\SpecialLink::where('token', $token)->first();
        if (!$link || !$link->isValid()) {
            return null;
        }

        $currency = LanguageHelper::getCurrentCurrency();
        $specialPrice = $link->priceForCurrency($currency);

        if ($specialPrice) {
            return (float) $specialPrice;
        }

        return null;
    }

    public function checkDuplicateBooking(string $type, int|object $itemId, string $date, int $guests, string $email, int $userId): ?object
    {
        $query = \App\Models\Booking::where('status', 'pending')
            ->where('payment_status', '!=', 'paid')
            ->where('created_at', '>=', now()->subMinutes(10));

        $query->where(function ($q) use ($type, $itemId, $date, $guests, $email, $userId) {
            if ($type === 'tour') {
                $q->where('tour_id', $itemId)
                    ->where('date', $date)
                    ->where('guests', $guests);
            } else {
                $q->where('package_id', $itemId)
                    ->where('date', $date)
                    ->where('guests', $guests);
            }

            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('email', $email);
            }
        });

        return $query->first();
    }
}