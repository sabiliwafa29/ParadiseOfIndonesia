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
        Cache::put($cacheKey, $country, now()->addDays(config('services.geolocation.cache_ttl_days', 7)));
        
        return $country;
    }

    /**
     * Check if IP is within rate limit for geolocation API calls
     */
    private static function checkRateLimit(string $ip): bool
    {
        $rateLimitKey = 'geolocation_rate_limit_' . $ip;
        $calls = Cache::get($rateLimitKey, 0);
        $maxCalls = config('services.geolocation.rate_limit_per_minute', 10);

        if ($calls >= $maxCalls) {
            return false;
        }

        // Increment counter
        Cache::put($rateLimitKey, $calls + 1, now()->addMinute());
        return true;
    }

    /**
     * Record successful API call for monitoring
     */
    private static function recordApiCall(string $ip, string $service): void
    {
        $statsKey = 'geolocation_stats_' . date('Y-m-d');
        $stats = Cache::get($statsKey, [
            'total_calls' => 0,
            'services' => [],
            'ips' => []
        ]);

        $stats['total_calls']++;
        $stats['services'][$service] = ($stats['services'][$service] ?? 0) + 1;
        $stats['ips'][$ip] = ($stats['ips'][$ip] ?? 0) + 1;

        Cache::put($statsKey, $stats, now()->addDay());
    }

    /**
     * Get geolocation statistics (for monitoring)
     */
    public static function getStats(): array
    {
        $statsKey = 'geolocation_stats_' . date('Y-m-d');
        return Cache::get($statsKey, [
            'total_calls' => 0,
            'services' => [],
            'ips' => []
        ]);
    }

    /**
     * Detect country from IP using multiple APIs with rate limiting
     */
    private static function detectCountryFromIp(string $ip): string
    {
        // Check rate limit before making API calls
        if (!self::checkRateLimit($ip)) {
            \Log::warning("LocationService: Rate limit exceeded for IP {$ip}, using fallback");
            return config('services.geolocation.fallback_country', 'ID');
        }

        // Method 1: Using ipapi.co (Free, no API key needed)
        try {
            $response = Http::timeout(config('services.geolocation.timeout_seconds', 3))
                ->get("https://ipapi.co/{$ip}/json/");
            if ($response->successful()) {
                $countryCode = $response->json('country_code');
                if ($countryCode) {
                    self::recordApiCall($ip, 'ipapi');
                    \Log::debug("LocationService: ipapi.co detected country: {$countryCode}");
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("ipapi.co failed: " . $e->getMessage());
        }

        // Method 2: Using ip-api.com (Free tier, limited calls)
        try {
            $response = Http::timeout(config('services.geolocation.timeout_seconds', 3))
                ->get("http://ip-api.com/json/{$ip}?fields=countryCode,status");
            if ($response->successful() && $response->json('status') === 'success') {
                $countryCode = $response->json('countryCode');
                if ($countryCode) {
                    self::recordApiCall($ip, 'ipapi');
                    \Log::debug("LocationService: ip-api.com detected country: {$countryCode}");
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("ip-api.com failed: " . $e->getMessage());
        }

        // Method 3: Using geoip-db.com (Alternative)
        try {
            $response = Http::timeout(config('services.geolocation.timeout_seconds', 3))
                ->get("https://geoip-db.com/json/{$ip}");
            if ($response->successful()) {
                $countryCode = $response->json('country_code');
                if ($countryCode) {
                    self::recordApiCall($ip, 'geoipdb');
                    \Log::debug("LocationService: geoip-db.com detected country: {$countryCode}");
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            \Log::warning("geoip-db.com failed: " . $e->getMessage());
        }

        // Fallback to configured default country
        $fallback = config('services.geolocation.fallback_country', 'ID');
        \Log::warning("LocationService: All IP detection methods failed, defaulting to {$fallback}");
        return $fallback;
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
            'CN', 'HK' => 'CNY',  // China and Hong Kong use CNY
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

    /**
     * Clear location cache for specific IP
     */
    public static function clearLocationCache(string $ip = null): void
    {
        if ($ip) {
            Cache::forget('location_' . $ip);
        } else {
            // Clear all location caches (keys starting with 'location_')
            $cacheKeys = Cache::store('redis')->getRedis()->keys('location_*');
            if ($cacheKeys) {
                Cache::store('redis')->deleteMultiple($cacheKeys);
            }
        }
    }
}