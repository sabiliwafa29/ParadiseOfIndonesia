<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PickoffDestination;
use App\Models\Pickup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    protected array $locationModels = [
        'pickup' => Pickup::class,
        'destination' => PickoffDestination::class,
    ];

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $userLat = $request->input('lat');
        $userLng = $request->input('lng');
        $type = $request->input('type', 'pickup');

        if (strlen($query) < 2) {
            return $this->emptyResponse();
        }

        $results = $this->searchDatabase($query, $type);

        if (count($results) < 5) {
            $results = $this->mergePhotonResults($query, $type, $userLat, $userLng, $results);
        }

        $results = $this->sortByDistance($results, $userLat, $userLng);

        return response()->json([
            'results' => array_slice($results, 0, 10),
            'query' => $query,
            'user_location' => $userLat && $userLng ? ['lat' => $userLat, 'lng' => $userLng] : null,
        ]);
    }

    protected function searchDatabase(string $query, string $type): array
    {
        $model = $this->locationModels[$type] ?? Pickup::class;

        $dbResults = $model::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return $dbResults->map(fn($location) => $this->formatDatabaseResult($location, $type))->toArray();
    }

    protected function formatDatabaseResult($location, string $type): array
    {
        return [
            'id' => $location->id,
            'name' => $location->name,
            'display_name' => $location->name . ($location->description ? ' - ' . $location->description : ''),
            'lat' => (string) $location->latitude,
            'lon' => (string) $location->longitude,
            'source' => 'database',
            'type' => $type,
        ];
    }

    protected function mergePhotonResults(string $query, string $type, ?float $userLat, ?float $userLng, array $existingResults): array
    {
        try {
            $photonResults = $this->searchPhoton($query);

            foreach ($photonResults as $place) {
                if ($this->resultExists($place['display_name'], $existingResults)) {
                    continue;
                }

                $result = [
                    'id' => null,
                    'name' => $place['display_name'],
                    'display_name' => $place['display_name'],
                    'lat' => $place['lat'],
                    'lon' => $place['lon'],
                    'source' => 'photon',
                    'type' => $type,
                ];

                if ($userLat && $userLng) {
                    $distance = $this->calculateDistance($userLat, $userLng, $place['lat'], $place['lon']);
                    $result['distance'] = round($distance, 1);
                    $result['distance_text'] = $distance < 1
                        ? round($distance * 1000) . 'm'
                        : round($distance, 1) . 'km';
                }

                $existingResults[] = $result;

                if (count($existingResults) >= 10) {
                    break;
                }
            }
        } catch (\Exception $e) {
            Log::error('Photon search error: ' . $e->getMessage());
        }

        return $existingResults;
    }

    protected function resultExists(string $displayName, array $results): bool
    {
        foreach ($results as $existing) {
            if (strtolower($existing['name']) === strtolower($displayName)) {
                return true;
            }
        }

        return false;
    }

    protected function sortByDistance(array $results, ?float $userLat, ?float $userLng): array
    {
        if (!$userLat || !$userLng) {
            return $results;
        }

        usort($results, fn($a, $b) => ($a['distance'] ?? PHP_FLOAT_MAX) <=> ($b['distance'] ?? PHP_FLOAT_MAX));

        return $results;
    }

    protected function emptyResponse(): JsonResponse
    {
        return response()->json(['results' => []]);
    }

    protected function searchPhoton(string $query): array
    {
        $response = Http::timeout(5)->get('https://photon.komoot.io/api/', [
            'q' => $query,
            'limit' => 5,
            'lang' => 'id',
        ]);

        if (!$response->successful()) {
            return [];
        }

        return $this->parsePhotonResponse($response->json());
    }

    protected function parsePhotonResponse(array $data): array
    {
        if (!isset($data['features'])) {
            return [];
        }

        return array_map(fn($feature) => $this->formatPhotonFeature($feature), $data['features']);
    }

    protected function formatPhotonFeature(array $feature): array
    {
        $properties = $feature['properties'];
        $geometry = $feature['geometry'];

        $nameParts = array_filter([
            $properties['name'] ?? null,
            $properties['street'] ?? null,
            $properties['city'] ?? null,
            $properties['state'] ?? null,
            $properties['country'] ?? null,
        ]);

        $displayName = implode(', ', $nameParts);

        if (empty($displayName) && isset($properties['osm_key'])) {
            $displayName = $properties['osm_value'] . ' (' . $properties['osm_key'] . ')';
        }

        return [
            'display_name' => $displayName,
            'lat' => (string) $geometry['coordinates'][1],
            'lon' => (string) $geometry['coordinates'][0],
            'type' => $properties['osm_key'] ?? 'unknown',
            'importance' => $properties['importance'] ?? 0,
        ];
    }

    protected function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
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

    public function createOrGet(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'type' => 'required|in:pickup,destination',
        ]);

        return response()->json($this->createOrRetrieveLocation($validated));
    }

    protected function createOrRetrieveLocation(array $data): array
    {
        $name = $data['name'];
        $lat = $data['lat'];
        $lon = $data['lon'];
        $type = $data['type'];

        $Model = $this->locationModels[$type] ?? Pickup::class;

        $location = $Model::whereBetween('latitude', [$lat - 0.001, $lat + 0.001])
            ->whereBetween('longitude', [$lon - 0.001, $lon + 0.001])
            ->first();

        if (!$location) {
            $location = $Model::create([
                'name' => $name,
                'description' => 'Auto-created from search',
                'latitude' => $lat,
                'longitude' => $lon,
            ]);
        }

        return [
            'id' => $location->id,
            'name' => $location->name,
            'lat' => (string) $location->latitude,
            'lon' => (string) $location->longitude,
        ];
    }
}