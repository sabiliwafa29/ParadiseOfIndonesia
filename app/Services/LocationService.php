<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LocationService
{
    /**
     * Detect country code from user IP
     * Using multiple free APIs as fallback
     */
    public static function detectCountry(): string
    {
        $ip = self::getClientIp();
        
        // Check cache first
        $cacheKey = 'location_' . $ip;
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        // Skip detection for localhost/private IPs
        if (self::isPrivateIp($ip)) {
            return 'ID'; // Default to Indonesia for local testing
        }

        // Method 1: Using ipapi.co (Free, no API key needed)
        try {
            $response = Http::timeout(3)->get("https://ipapi.co/{$ip}/json/");
            if ($response->successful()) {
                $countryCode = $response->json('country_code');
                if ($countryCode) {
                    Cache::put($cacheKey, $countryCode, now()->addDays(7));
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("ipapi.co failed: " . $e->getMessage());
        }

        // Method 2: Using ip-api.com (Free tier, limited calls)
        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=countryCode");
            if ($response->successful() && $response->json('status') === 'success') {
                $countryCode = $response->json('countryCode');
                if ($countryCode) {
                    Cache::put($cacheKey, $countryCode, now()->addDays(7));
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("ip-api.com failed: " . $e->getMessage());
        }

        // Method 3: Using geoip-db.com (Alternative)
        try {
            $response = Http::timeout(3)->get("https://geoip-db.com/json/{$ip}");
            if ($response->successful()) {
                $countryCode = $response->json('country_code');
                if ($countryCode) {
                    Cache::put($cacheKey, $countryCode, now()->addDays(7));
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("geoip-db.com failed: " . $e->getMessage());
        }

        // Fallback
        return 'US';
    }

    /**
     * Get client IP address
     */
    public static function getClientIp(): string
    {
        $ip = request()->ip();
        
        // Handle proxy headers
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }

        return trim($ip);
    }

    /**
     * Check if IP is private/local
     */
    public static function isPrivateIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    /**
     * Check if user is from Indonesia
     */
    public static function isIndonesia(): bool
    {
        return self::detectCountry() === 'ID';
    }

    /**
     * Get user market type
     */
    public static function getUserMarket(): string
    {
        $country = self::detectCountry();
        
        return match($country) {
            'ID' => 'domestic',
            default => 'international',
        };
    }

    /**
     * Get market label
     */
    public static function getMarketLabel(string $market): string
    {
        return match($market) {
            'domestic' => 'Indonesia Only',
            'international' => 'International Only',
            'both' => 'All Markets',
            default => 'All Markets',
        };
    }

    /**
     * Get user currency based on location
     */
    public static function getUserCurrency(): string
    {
        $country = self::detectCountry();
        
        return match($country) {
            'ID' => 'IDR',
            'CN' => 'CNY',
            default => 'USD',
        };
    }

    /**
     * Get country name from code
     */
    public static function getCountryName(string $code): string
    {
        $countries = [
            'ID' => 'Indonesia',
            'CN' => 'China',
            'US' => 'United States',
            'SG' => 'Singapore',
            'MY' => 'Malaysia',
            'TH' => 'Thailand',
            'VN' => 'Vietnam',
            'PH' => 'Philippines',
            'JP' => 'Japan',
            'KR' => 'South Korea',
            'AU' => 'Australia',
            'NZ' => 'New Zealand',
            'GB' => 'United Kingdom',
            'DE' => 'Germany',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'CA' => 'Canada',
            'BR' => 'Brazil',
            'IN' => 'India',
        ];

        return $countries[$code] ?? 'Unknown';
    }

    /**
     * Clear location cache (for testing)
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }
}