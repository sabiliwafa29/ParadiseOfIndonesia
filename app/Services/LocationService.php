<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationService
{
    public static function detectCountry(): string
    {
        $sessionCountry = session('user_country');
        if ($sessionCountry) {
            Log::debug("LocationService: Using session country: {$sessionCountry}");
            return $sessionCountry;
        }

        $ip = self::getClientIp();
        $cacheKey = 'location_' . $ip;
        $cached = Cache::get($cacheKey);

        if ($cached) {
            Log::debug("LocationService: Using cached country for IP {$ip}: {$cached}");
            return $cached;
        }

        if (self::isPrivateIp($ip)) {
            Log::debug("LocationService: Private IP detected, defaulting to ID");
            return 'ID';
        }

        $country = self::detectCountryFromIp($ip);
        Cache::put($cacheKey, $country, now()->addDays(config('services.geolocation.cache_ttl_days', 7)));

        return $country;
    }

    public static function getUserMarket(): string
    {
        $country = self::detectCountry();

        return match($country) {
            'ID' => 'domestic',
            default => 'international',
        };
    }

    public static function getUserCurrency(): string
    {
        $country = self::detectCountry();

        return match($country) {
            'ID' => 'IDR',
            'CN', 'HK' => 'CNY',
            default => 'USD',
        };
    }

    public static function getMarketLabel(string $market): string
    {
        return match($market) {
            'domestic' => 'Indonesia Only',
            'international' => 'International Only',
            'both' => 'All Markets',
            default => 'All Markets',
        };
    }

    public static function isIndonesia(): bool
    {
        return self::detectCountry() === 'ID';
    }

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

    public static function getClientIp(): string
    {
        $ip = request()->ip();

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

    public static function isPrivateIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    protected static function checkRateLimit(string $ip): bool
    {
        $rateLimitKey = 'geolocation_rate_limit_' . $ip;
        $calls = Cache::get($rateLimitKey, 0);
        $maxCalls = config('services.geolocation.rate_limit_per_minute', 10);

        if ($calls >= $maxCalls) {
            return false;
        }

        Cache::put($rateLimitKey, $calls + 1, now()->addMinute());
        return true;
    }

    protected static function recordApiCall(string $ip, string $service): void
    {
        $statsKey = 'geolocation_stats_' . date('Y-m-d');
        $stats = Cache::get($statsKey, ['total_calls' => 0, 'services' => [], 'ips' => []]);

        $stats['total_calls']++;
        $stats['services'][$service] = ($stats['services'][$service] ?? 0) + 1;
        $stats['ips'][$ip] = ($stats['ips'][$ip] ?? 0) + 1;

        Cache::put($statsKey, $stats, now()->addDay());
    }

    public static function getStats(): array
    {
        $statsKey = 'geolocation_stats_' . date('Y-m-d');
        return Cache::get($statsKey, ['total_calls' => 0, 'services' => [], 'ips' => []]);
    }

    protected static function detectCountryFromIp(string $ip): string
    {
        if (!self::checkRateLimit($ip)) {
            Log::warning("LocationService: Rate limit exceeded for IP {$ip}, using fallback");
            return config('services.geolocation.fallback_country', 'ID');
        }

        $apis = [
            ['url' => "https://ipapi.co/{$ip}/json/", 'key' => 'country_code', 'service' => 'ipapi'],
            ['url' => "http://ip-api.com/json/{$ip}?fields=countryCode,status", 'key' => 'countryCode', 'service' => 'ip-api.com', 'statusKey' => 'status', 'statusValue' => 'success'],
            ['url' => "https://geoip-db.com/json/{$ip}", 'key' => 'country_code', 'service' => 'geoipdb'],
        ];

        foreach ($apis as $api) {
            try {
                $response = Http::timeout(config('services.geolocation.timeout_seconds', 3))->get($api['url']);

                if ($response->successful()) {
                    $countryCode = $response->json($api['key']);

                    if (!empty($api['statusKey']) && $response->json($api['statusKey']) !== $api['statusValue']) {
                        continue;
                    }

                    if ($countryCode) {
                        self::recordApiCall($ip, $api['service']);
                        Log::debug("LocationService: {$api['service']} detected country: {$countryCode}");
                        return strtoupper($countryCode);
                    }
                }
            } catch (\Exception $e) {
                Log::warning("LocationService: {$api['service']} failed: " . $e->getMessage());
            }
        }

        $fallback = config('services.geolocation.fallback_country', 'ID');
        Log::warning("LocationService: All IP detection methods failed, defaulting to {$fallback}");
        return $fallback;
    }

    public static function clearCache(): void
    {
        Cache::flush();
    }

    public static function clearLocationCache(string $ip = null): void
    {
        if ($ip) {
            Cache::forget('location_' . $ip);
        } else {
            $cacheKeys = Cache::store('redis')->getRedis()->keys('location_*');
            if ($cacheKeys) {
                Cache::store('redis')->deleteMultiple($cacheKeys);
            }
        }
    }
}