<?php

namespace App\Services;

use Illuminate\Support\Str;

class OrderIdService
{
    public static function generate(?string $prefix = null): string
    {
        $prefix = $prefix ?? config('booking.order_id.prefix', 'BOOK');
        $format = config('booking.order_id.format', 'timestamp');

        if ($format === 'uuid') {
            return $prefix . '-' . Str::uuid()->toString();
        }

        $timestamp = now()->format('YmdHis');
        $random = Str::random(6);

        return $prefix . '-' . $timestamp . '-' . strtoupper($random);
    }

    public static function extractBookingId(string $orderId): ?int
    {
        $parts = explode('-', $orderId);

        if (count($parts) >= 2 && is_numeric($parts[1])) {
            return (int) $parts[1];
        }

        return null;
    }
}