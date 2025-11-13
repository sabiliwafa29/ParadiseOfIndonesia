<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OsrmService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DistanceController extends Controller
{
    protected $osrmService;

    public function __construct(OsrmService $osrmService)
    {
        $this->osrmService = $osrmService;
    }

    /**
     * Calculate distance between two coordinates using OSRM
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'start_lat' => 'required|numeric|between:-90,90',
            'start_lng' => 'required|numeric|between:-180,180',
            'end_lat' => 'required|numeric|between:-90,90',
            'end_lng' => 'required|numeric|between:-180,180',
        ]);

        try {
            $result = $this->osrmService->calculateDistance(
                (float) $request->start_lat,
                (float) $request->start_lng,
                (float) $request->end_lat,
                (float) $request->end_lng
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'distance' => $result['distance'],
                    'duration' => $result['duration'],
                    'method' => $result['method'],
                    'unit' => 'km'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate distance',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
