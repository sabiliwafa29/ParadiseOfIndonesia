<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Models\PickoffDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Search locations (hybrid: database + Photon) with geolocation support
     *
     * @param Request $request
     * @param string $type 'pickup' or 'destination'
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, $type = 'pickup')
    {
        $query = $request->input('q', '');
        $userLat = $request->input('lat'); // User's current latitude
        $userLng = $request->input('lng'); // User's current longitude

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // 1. Search in database first
        if ($type === 'pickup') {
            $dbResults = Pickup::where('name', 'ILIKE', "%{$query}%")
                ->orWhere('description', 'ILIKE', "%{$query}%")
                ->limit(10)
                ->get();
        } else {
            $dbResults = PickoffDestination::where('name', 'ILIKE', "%{$query}%")
                ->orWhere('description', 'ILIKE', "%{$query}%")
                ->limit(10)
                ->get();
        }

        // Format database results with distance calculation if user location provided
        foreach ($dbResults as $location) {
            $result = [
                'id' => $location->id,
                'name' => $location->name,
                'display_name' => $location->name . ($location->description ? ' - ' . $location->description : ''),
                'lat' => (string) $location->latitude,
                'lon' => (string) $location->longitude,
                'source' => 'database',
                'type' => $type,
            ];

            // Calculate distance from user if coordinates provided
            if ($userLat && $userLng) {
                $distance = $this->calculateDistance(
                    (float)$userLat,
                    (float)$userLng,
                    (float)$location->latitude,
                    (float)$location->longitude
                );
                $result['distance'] = round($distance, 1);
                $result['distance_text'] = $distance < 1 ?
                    round($distance * 1000) . 'm' :
                    round($distance, 1) . 'km';
            }

            $results[] = $result;
        }

        // 2. If less than 5 results, search Photon (faster than Nominatim)
        if (count($results) < 5) {
            try {
                $photonResults = $this->searchPhoton($query);

                foreach ($photonResults as $place) {
                    // Skip if already in results (by name similarity)
                    $exists = false;
                    foreach ($results as $existing) {
                        if (strtolower($existing['name']) === strtolower($place['display_name'])) {
                            $exists = true;
                            break;
                        }
                    }

                    if (!$exists) {
                        $result = [
                            'id' => null, // Will be created if selected
                            'name' => $place['display_name'],
                            'display_name' => $place['display_name'],
                            'lat' => $place['lat'],
                            'lon' => $place['lon'],
                            'source' => 'photon',
                            'type' => $type,
                        ];

                        // Calculate distance from user if coordinates provided
                        if ($userLat && $userLng) {
                            $distance = $this->calculateDistance(
                                (float)$userLat,
                                (float)$userLng,
                                (float)$place['lat'],
                                (float)$place['lon']
                            );
                            $result['distance'] = round($distance, 1);
                            $result['distance_text'] = $distance < 1 ?
                                round($distance * 1000) . 'm' :
                                round($distance, 1) . 'km';
                        }

                        $results[] = $result;
                    }

                    if (count($results) >= 10) break;
                }
            } catch (\Exception $e) {
                Log::error('Photon search error: ' . $e->getMessage());
                // Continue with database results only
            }
        }

        // 3. Sort by distance if user location provided
        if ($userLat && $userLng) {
            usort($results, function($a, $b) {
                $distA = $a['distance'] ?? PHP_FLOAT_MAX;
                $distB = $b['distance'] ?? PHP_FLOAT_MAX;
                return $distA <=> $distB;
            });
        }

        return response()->json([
            'results' => array_slice($results, 0, 10),
            'query' => $query,
            'user_location' => $userLat && $userLng ? ['lat' => $userLat, 'lng' => $userLng] : null,
        ]);
    }

    /**
     * Search location using Photon API (faster and better for autocomplete)
     */
    private function searchPhoton(string $query): array
    {
        try {
            $response = Http::timeout(5)->get('https://photon.komoot.io/api/', [
                'q' => $query,
                'limit' => 5,
                'lang' => 'id', // Indonesian language
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $results = [];

                if (isset($data['features'])) {
                    foreach ($data['features'] as $feature) {
                        $properties = $feature['properties'];
                        $geometry = $feature['geometry'];

                        // Build display name from properties
                        $nameParts = [];
                        if (isset($properties['name'])) {
                            $nameParts[] = $properties['name'];
                        }
                        if (isset($properties['street'])) {
                            $nameParts[] = $properties['street'];
                        }
                        if (isset($properties['city'])) {
                            $nameParts[] = $properties['city'];
                        }
                        if (isset($properties['state'])) {
                            $nameParts[] = $properties['state'];
                        }
                        if (isset($properties['country'])) {
                            $nameParts[] = $properties['country'];
                        }

                        $displayName = implode(', ', array_filter($nameParts));

                        if (empty($displayName) && isset($properties['osm_key'])) {
                            $displayName = $properties['osm_value'] . ' (' . $properties['osm_key'] . ')';
                        }

                        $results[] = [
                            'display_name' => $displayName,
                            'lat' => (string) $geometry['coordinates'][1],
                            'lon' => (string) $geometry['coordinates'][0],
                            'type' => $properties['osm_key'] ?? 'unknown',
                            'importance' => $properties['importance'] ?? 0,
                        ];
                    }
                }

                return $results;
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Photon API error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
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
     * Create or get location from database
     * Used when user selects a Photon location
     */
    public function createOrGet(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'type' => 'required|in:pickup,destination',
        ]);

        $name = $request->input('name');
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $type = $request->input('type');

        // Check if location already exists (by coordinates, within 0.001 degree ~100m)
        if ($type === 'pickup') {
            $location = Pickup::whereBetween('latitude', [$lat - 0.001, $lat + 0.001])
                ->whereBetween('longitude', [$lon - 0.001, $lon + 0.001])
                ->first();

            if (!$location) {
                $location = Pickup::create([
                    'name' => $name,
                    'description' => 'Auto-created from search',
                    'latitude' => $lat,
                    'longitude' => $lon,
                ]);
            }
        } else {
            $location = PickoffDestination::whereBetween('latitude', [$lat - 0.001, $lat + 0.001])
                ->whereBetween('longitude', [$lon - 0.001, $lon + 0.001])
                ->first();

            if (!$location) {
                $location = PickoffDestination::create([
                    'name' => $name,
                    'description' => 'Auto-created from search',
                    'latitude' => $lat,
                    'longitude' => $lon,
                ]);
            }
        }

        return response()->json([
            'id' => $location->id,
            'name' => $location->name,
            'lat' => (string) $location->latitude,
            'lon' => (string) $location->longitude,
        ]);
    }
}
