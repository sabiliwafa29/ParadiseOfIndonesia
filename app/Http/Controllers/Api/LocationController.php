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
     * Search locations (hybrid: database + Nominatim)
     * 
     * @param Request $request
     * @param string $type 'pickup' or 'destination'
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, $type = 'pickup')
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // 1. Search in database first
        if ($type === 'pickup') {
            $dbResults = Pickup::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();
        } else {
            $dbResults = PickoffDestination::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();
        }

        // Format database results
        foreach ($dbResults as $location) {
            $results[] = [
                'id' => $location->id,
                'name' => $location->name,
                'display_name' => $location->name . ($location->description ? ' - ' . $location->description : ''),
                'lat' => (string) $location->latitude,
                'lon' => (string) $location->longitude,
                'source' => 'database',
                'type' => $type,
            ];
        }

        // 2. If less than 5 results, search Nominatim
        if (count($results) < 5) {
            try {
                $nominatimResults = $this->searchNominatim($query);
                
                foreach ($nominatimResults as $place) {
                    // Skip if already in results (by name similarity)
                    $exists = false;
                    foreach ($results as $existing) {
                        if (strtolower($existing['name']) === strtolower($place['display_name'])) {
                            $exists = true;
                            break;
                        }
                    }
                    
                    if (!$exists) {
                        $results[] = [
                            'id' => null, // Will be created if selected
                            'name' => $place['display_name'],
                            'display_name' => $place['display_name'],
                            'lat' => $place['lat'],
                            'lon' => $place['lon'],
                            'source' => 'nominatim',
                            'type' => $type,
                        ];
                    }
                    
                    if (count($results) >= 5) break;
                }
            } catch (\Exception $e) {
                Log::error('Nominatim search error: ' . $e->getMessage());
                // Continue with database results only
            }
        }

        return response()->json([
            'results' => array_slice($results, 0, 5),
            'query' => $query,
        ]);
    }

    /**
     * Search location using Nominatim API
     */
    private function searchNominatim(string $query): array
    {
        try {
            $response = Http::timeout(5)->get('https://nominatim.openstreetmap.org/search', [
                'format' => 'json',
                'q' => $query,
                'countrycodes' => 'id',
                'limit' => 5,
                'addressdetails' => 1,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Nominatim API error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Create or get location from database
     * Used when user selects a Nominatim location
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
