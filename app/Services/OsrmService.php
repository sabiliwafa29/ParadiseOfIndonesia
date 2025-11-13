<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OsrmService
{
    protected $baseUrl;
    protected $timeout;
    protected $profile;

    public function __construct()
    {
        $this->baseUrl = config('services.osrm.base_url', 'https://router.project-osrm.org');
        $this->timeout = config('services.osrm.timeout', 10);
        $this->profile = config('services.osrm.profile', 'driving');
    }

    /**
     * Calculate distance and duration between two coordinates using OSRM with caching
     *
     * @param float $startLat
     * @param float $startLng
     * @param float $endLat
     * @param float $endLng
     * @return array|null Returns ['distance' => float, 'duration' => float] or null on failure
     */
    public function calculateRoute(float $startLat, float $startLng, float $endLat, float $endLng): ?array
    {
        // Create cache key based on coordinates (rounded to 4 decimal places for grouping)
        $cacheKey = sprintf(
            'osrm_route_%.4f_%.4f_%.4f_%.4f',
            $startLat, $startLng, $endLat, $endLng
        );

        // Try to get from cache first
        $cachedResult = Cache::get($cacheKey);
        if ($cachedResult) {
            Log::info('OSRM cache hit', ['key' => $cacheKey]);
            return $cachedResult;
        }

        try {
            $url = "{$this->baseUrl}/route/v1/{$this->profile}/{$startLng},{$startLat};{$endLng},{$endLat}";

            $params = [
                'overview' => 'false', // We don't need the geometry
                'steps' => 'false',    // We don't need step-by-step instructions
                'annotations' => 'distance,duration', // Only get distance and duration
            ];

            $startTime = microtime(true);
            $response = Http::timeout($this->timeout)->get($url, $params);
            $responseTime = microtime(true) - $startTime;

            // Log response time for monitoring
            Log::info('OSRM API call completed', [
                'url' => $url,
                'response_time_ms' => round($responseTime * 1000, 2),
                'status' => $response->status()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['routes']) && count($data['routes']) > 0) {
                    $route = $data['routes'][0];
                    $result = [
                        'distance' => round($route['distance'] / 1000, 2), // Convert meters to km
                        'duration' => round($route['duration'] / 60, 2),  // Convert seconds to minutes
                    ];

                    // Cache the result for 24 hours
                    Cache::put($cacheKey, $result, now()->addHours(24));

                    Log::info('OSRM result cached', [
                        'key' => $cacheKey,
                        'distance' => $result['distance'],
                        'ttl_hours' => 24
                    ]);

                    return $result;
                }
            }

            // Log the error for debugging
            Log::warning('OSRM API call failed', [
                'url' => $url,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

        } catch (\Exception $e) {
            Log::error('OSRM API exception', [
                'error' => $e->getMessage(),
                'start' => [$startLat, $startLng],
                'end' => [$endLat, $endLng]
            ]);
        }

        return null; // Return null to indicate failure
    }

    /**
     * Calculate distance using Haversine formula as fallback
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Distance in kilometers
     */
    public function calculateHaversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km

        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) ** 2
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * sin($lonDiff / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return round($distance, 2);
    }

    /**
     * Calculate distance with OSRM, fallback to Haversine
     *
     * @param float $startLat
     * @param float $startLng
     * @param float $endLat
     * @param float $endLng
     * @return array Returns ['distance' => float, 'duration' => float|null, 'method' => string]
     */
    public function calculateDistance(float $startLat, float $startLng, float $endLat, float $endLng): array
    {
        // Try OSRM first
        $osrmResult = $this->calculateRoute($startLat, $startLng, $endLat, $endLng);

        if ($osrmResult) {
            return [
                'distance' => $osrmResult['distance'],
                'duration' => $osrmResult['duration'],
                'method' => 'osrm'
            ];
        }

        // Fallback to Haversine
        $haversineDistance = $this->calculateHaversineDistance($startLat, $startLng, $endLat, $endLng);

        Log::info('OSRM failed, using Haversine fallback', [
            'start' => [$startLat, $startLng],
            'end' => [$endLat, $endLng],
            'distance' => $haversineDistance
        ]);

        return [
            'distance' => $haversineDistance,
            'duration' => null,
            'method' => 'haversine'
        ];
    }
}
