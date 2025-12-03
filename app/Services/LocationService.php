<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LocationService
{
    /**
     * Detect country code from user
     * Priority: 1. Session (from browser GPS), 2. Cache, 3. IP detection
     */
    public static function detectCountry(): string
    {
        // Priority 1: Check session first (set by browser geolocation)
        $sessionCountry = session('user_country');
        if ($sessionCountry) {
            \Log::debug("LocationService: Using session country: {$sessionCountry}");
            return $sessionCountry;
        }

        $ip = self::getClientIp();
        
        // Priority 2: Check cache
        $cacheKey = 'location_' . $ip;
        $cached = Cache::get($cacheKey);
        if ($cached) {
            \Log::debug("LocationService: Using cached country for IP {$ip}: {$cached}");
            return $cached;
        }

        // Skip detection for localhost/private IPs - default to Indonesia
        if (self::isPrivateIp($ip)) {
            \Log::debug("LocationService: Private IP detected, defaulting to ID");
            return 'ID'; // Default to Indonesia for local testing
        }

        // Priority 3: IP-based detection
        $country = self::detectCountryFromIp($ip);
        
        // Cache the result
        Cache::put($cacheKey, $country, now()->addDays(7));
        
        return $country;
    }

    /**
     * Detect country from IP using multiple APIs
     */
    private static function detectCountryFromIp(string $ip): string
    {
        // Method 1: Using ipapi.co (Free, no API key needed)
        try {
            $response = Http::timeout(3)->get("https://ipapi.co/{$ip}/json/");
            if ($response->successful()) {
                $countryCode = $response->json('country_code');
                if ($countryCode) {
                    \Log::debug("LocationService: ipapi.co detected country: {$countryCode}");
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("ipapi.co failed: " . $e->getMessage());
        }

        // Method 2: Using ip-api.com (Free tier, limited calls)
        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=countryCode,status");
            if ($response->successful() && $response->json('status') === 'success') {
                $countryCode = $response->json('countryCode');
                if ($countryCode) {
                    \Log::debug("LocationService: ip-api.com detected country: {$countryCode}");
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
                    \Log::debug("LocationService: geoip-db.com detected country: {$countryCode}");
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("geoip-db.com failed: " . $e->getMessage());
        }

        // Fallback to Indonesia (safer for local business)
        \Log::warning("LocationService: All IP detection methods failed, defaulting to ID");
        return 'ID';
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