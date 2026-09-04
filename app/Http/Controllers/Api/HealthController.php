<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\OsrmService;
use App\Services\MidtransService;

class HealthController extends Controller
{
    protected $osrmService;
    protected $midtransService;

    public function __construct(OsrmService $osrmService, MidtransService $midtransService)
    {
        $this->osrmService = $osrmService;
        $this->midtransService = $midtransService;
    }

    /**
     * Basic health check endpoint
     */
    public function check()
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toISOString(),
            'service' => 'PNB Travel API',
            'version' => config('app.version', '1.0.0')
        ]);
    }

    /**
     * Detailed health check with system status
     */
    public function detailed()
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'osrm' => $this->checkOsrmService(),
            'midtrans' => $this->checkMidtransService(),
        ];

        $overallStatus = $this->determineOverallStatus($checks);

        $response = [
            'status' => $overallStatus,
            'timestamp' => now()->toISOString(),
            'service' => 'PNB Travel API',
            'version' => config('app.version', '1.0.0'),
            'checks' => $checks,
            'response_time_ms' => round((microtime(true) - LARAVEL_START) * 1000, 2)
        ];

        $statusCode = $overallStatus === 'healthy' ? 200 : 503;

        return response()->json($response, $statusCode);
    }

    /**
     * OSRM service specific health check
     */
    public function osrm()
    {
        $startTime = microtime(true);

        try {
            // Test with known coordinates (Jakarta to Bandung approximate)
            $result = $this->osrmService->calculateDistance(
                -6.2088, 106.8456,  // Jakarta
                -6.9175, 107.6191   // Bandung
            );

            $responseTime = round((microtime(true) - $startTime) * 1000, 2);

            return response()->json([
                'status' => 'healthy',
                'service' => 'OSRM Distance Calculation',
                'response_time_ms' => $responseTime,
                'test_result' => $result,
                'timestamp' => now()->toISOString()
            ]);

        } catch (\Exception $e) {
            Log::error('OSRM health check failed', [
                'error' => $e->getMessage(),
                'response_time_ms' => round((microtime(true) - $startTime) * 1000, 2)
            ]);

            return response()->json([
                'status' => 'unhealthy',
                'service' => 'OSRM Distance Calculation',
                'error' => $e->getMessage(),
                'response_time_ms' => round((microtime(true) - $startTime) * 1000, 2),
                'timestamp' => now()->toISOString()
            ], 503);
        }
    }

    private function checkDatabase(): array
    {
        try {
            DB::select('SELECT 1');
            return [
                'status' => 'healthy',
                'message' => 'Database connection successful'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ];
        }
    }

    private function checkCache(): array
    {
        try {
            $testKey = 'health_check_' . time();
            Cache::put($testKey, 'test_value', 10);
            $value = Cache::get($testKey);
            Cache::forget($testKey);

            if ($value === 'test_value') {
                return [
                    'status' => 'healthy',
                    'message' => 'Cache is working properly'
                ];
            } else {
                return [
                    'status' => 'unhealthy',
                    'message' => 'Cache read/write test failed'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Cache connection failed: ' . $e->getMessage()
            ];
        }
    }

    private function checkOsrmService(): array
    {
        try {
            // Quick test with simple coordinates
            $result = $this->osrmService->calculateDistance(0, 0, 0.01, 0.01);

            if ($result && isset($result['distance'])) {
                return [
                    'status' => 'healthy',
                    'message' => 'OSRM service is responding',
                    'method_used' => $result['method']
                ];
            } else {
                return [
                    'status' => 'unhealthy',
                    'message' => 'OSRM service returned invalid response'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'OSRM service error: ' . $e->getMessage()
            ];
        }
    }

    private function checkMidtransService(): array
    {
        try {
            $result = $this->midtransService->testConnection();

            if ($result['success']) {
                return [
                    'status' => 'healthy',
                    'message' => $result['message'],
                    'environment' => $result['environment']
                ];
            } else {
                return [
                    'status' => 'unhealthy',
                    'message' => $result['message'],
                    'environment' => $result['environment']
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'message' => 'Midtrans service error: ' . $e->getMessage()
            ];
        }
    }

    private function determineOverallStatus(array $checks): string
    {
        foreach ($checks as $check) {
            if ($check['status'] === 'unhealthy') {
                return 'unhealthy';
            }
        }
        return 'healthy';
    }
}
