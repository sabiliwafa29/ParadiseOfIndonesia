<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OsrmService
{
    protected string $baseUrl;
    protected int $timeout;
    protected string $profile;

    public function __construct()
    {
        $this->baseUrl = config('services.osrm.base_url', 'https://router.project-osrm.org');
        $this->timeout = config('services.osrm.timeout', 10);
        $this->profile = config('services.osrm.profile', 'driving');
    }

    public function calculateRoute(float $startLat, float $startLng, float $endLat, float $endLng): ?array
    {
        $cacheKey = sprintf(
            'osrm_route_%.4f_%.4f_%.4f_%.4f',
            $startLat, $startLng, $endLat, $endLng
        );

        $cachedResult = Cache::get($cacheKey);
        if ($cachedResult) {
            Log::info('OSRM cache hit', ['key' => $cacheKey]);
            return $cachedResult;
        }

        try {
            $url = "{$this->baseUrl}/route/v1/{$this->profile}/{$startLng},{$startLat};{$endLng},{$endLat}";
            $params = ['overview' => 'false', 'steps' => 'false', 'annotations' => 'distance,duration'];

            $startTime = microtime(true);
            $response = Http::timeout($this->timeout)->get($url, $params);
            $responseTime = microtime(true) - $startTime;

            Log::info('OSRM API call completed', [
                'url' => $url,
                'response_time_ms' => round($responseTime * 1000, 2),
                'status' => $response->status(),
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['routes']) && count($data['routes']) > 0) {
                    $route = $data['routes'][0];
                    $result = [
                        'distance' => round($route['distance'] / 1000, 2),
                        'duration' => round($route['duration'] / 60, 2),
                    ];

                    Cache::put($cacheKey, $result, now()->addHours(24));
                    Log::info('OSRM result cached', ['key' => $cacheKey, 'distance' => $result['distance']]);

                    return $result;
                }
            }

            Log::warning('OSRM API call failed', ['url' => $url, 'status' => $response->status()]);
        } catch (\Exception $e) {
            Log::error('OSRM API exception', [
                'error' => $e->getMessage(),
                'start' => [$startLat, $startLng],
                'end' => [$endLat, $endLng],
            ]);
        }

        return null;
    }

    public function calculateHaversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371;
        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) ** 2
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * sin($lonDiff / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    public function calculateDistance(float $startLat, float $startLng, float $endLat, float $endLng): array
    {
        $osrmResult = $this->calculateRoute($startLat, $startLng, $endLat, $endLng);

        if ($osrmResult) {
            return [
                'distance' => $osrmResult['distance'],
                'duration' => $osrmResult['duration'],
                'method' => 'osrm',
            ];
        }

        $haversineDistance = $this->calculateHaversineDistance($startLat, $startLng, $endLat, $endLng);

        Log::info('OSRM failed, using Haversine fallback', [
            'start' => [$startLat, $startLng],
            'end' => [$endLat, $endLng],
            'distance' => $haversineDistance,
        ]);

        return [
            'distance' => $haversineDistance,
            'duration' => null,
            'method' => 'haversine',
        ];
    }
}