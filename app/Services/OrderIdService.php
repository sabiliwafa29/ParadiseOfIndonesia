<?php

namespace App\Services;

use Illuminate\Support\Str;

class OrderIdService
{
    /**
     * Generate unique order ID untuk Midtrans
     * Format: BOOK-{timestamp}-{random} atau BOOK-{uuid}
     */
    public static function generate(string $prefix = null): string
    {
        $prefix = $prefix ?? config('booking.order_id.prefix', 'BOOK');
        $format = config('booking.order_id.format', 'timestamp');

        if ($format === 'uuid') {
            return $prefix . '-' . Str::uuid()->toString();
        }

        // Default: timestamp-based dengan random suffix untuk uniqueness
        $timestamp = now()->format('YmdHis');
        $random = Str::random(6);
        
        return $prefix . '-' . $timestamp . '-' . strtoupper($random);
    }

    /**
     * Extract booking ID dari order ID
     * Format: BOOK-123 -> 123
     */
    public static function extractBookingId(string $orderId): ?int
    {
        $parts = explode('-', $orderId);
        
        // Jika format BOOK-{id}, ambil ID
        if (count($parts) >= 2 && is_numeric($parts[1])) {
            return (int) $parts[1];
        }

        // Jika format BOOK-{timestamp}-{random}, coba cari ID di database
        // Atau return null jika tidak bisa diekstrak
        return null;
    }
}

