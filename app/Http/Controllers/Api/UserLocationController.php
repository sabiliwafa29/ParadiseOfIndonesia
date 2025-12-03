<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserLocationController extends Controller
{
    /**
     * Store user location from browser geolocation
     * Converts lat/lng to country code using reverse geocoding
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;

        // Get country code from coordinates
        $countryCode = $this->reverseGeocode($lat, $lng);

        if ($countryCode) {
            // Store in session
            session(['user_country' => $countryCode]);
            session(['user_location_method' => 'browser_gps']);
            session(['user_coordinates' => ['lat' => $lat, 'lng' => $lng]]);
            
            // Also cache it for this IP
            $ip = $request->ip();
            Cache::put('location_' . $ip, $countryCode, now()->addDays(7));
            
            $market = $countryCode === 'ID' ? 'domestic' : 'international';
            
            return response()->json([
                'success' => true,
                'country_code' => $countryCode,
                'market' => $market,
                'method' => 'browser_gps'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Could not determine country from coordinates'
        ], 422);
    }

    /**
     * Get current user location info
     */
    public function show(Request $request)
    {
        $countryCode = session('user_country');
        $method = session('user_location_method', 'unknown');
        
        if (!$countryCode) {
            // Fallback to IP detection
            $countryCode = \App\Services\LocationService::detectCountry();
            $method = 'ip_detection';
        }

        $market = $countryCode === 'ID' ? 'domestic' : 'international';

        return response()->json([
            'country_code' => $countryCode,
            'market' => $market,
            'method' => $method,
            'is_indonesia' => $countryCode === 'ID'
        ]);
    }

    /**
     * Clear location data (for testing)
     */
    public function clear(Request $request)
    {
        session()->forget(['user_country', 'user_location_method', 'user_coordinates']);
        
        $ip = $request->ip();
        Cache::forget('location_' . $ip);

        return response()->json([
            'success' => true,
            'message' => 'Location data cleared'
        ]);
    }

    /**
     * Reverse geocode coordinates to get country code
     */
    private function reverseGeocode($lat, $lng): ?string
    {
        // Quick check: Indonesia bounding box (rough)
        // Indonesia: lat -11 to 6, lng 95 to 141
        if ($lat >= -11 && $lat <= 6 && $lng >= 95 && $lng <= 141) {
            Log::info("GPS location within Indonesia bounds: {$lat}, {$lng}");
            return 'ID';
        }

        // Method 1: Using Nominatim (OpenStreetMap) - Free
        try {
            $response = Http::timeout(5)
                ->withHeaders(['User-Agent' => 'ParadiseOfIndonesia/1.0'])
                ->get("https://nominatim.openstreetmap.org/reverse", [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lng,
                    'zoom' => 3, // Country level
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $countryCode = $data['address']['country_code'] ?? null;
                if ($countryCode) {
                    Log::info("Nominatim reverse geocode: {$lat}, {$lng} => " . strtoupper($countryCode));
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            Log::warning("Nominatim reverse geocode failed: " . $e->getMessage());
        }

        // Method 2: Using BigDataCloud (Free tier)
        try {
            $response = Http::timeout(5)->get("https://api.bigdatacloud.net/data/reverse-geocode-client", [
                'latitude' => $lat,
                'longitude' => $lng,
                'localityLanguage' => 'en'
            ]);

            if ($response->successful()) {
                $countryCode = $response->json('countryCode');
                if ($countryCode) {
                    Log::info("BigDataCloud reverse geocode: {$lat}, {$lng} => {$countryCode}");
                    return strtoupper($countryCode);
                }
            }
        } catch (\Exception $e) {
            Log::warning("BigDataCloud reverse geocode failed: " . $e->getMessage());
        }

        return null;
    }
}
