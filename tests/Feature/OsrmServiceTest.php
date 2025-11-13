<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Services\OsrmService;

class OsrmServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $osrmService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->osrmService = new OsrmService();
        Cache::flush(); // Clear cache before each test
    }

    /** @test */
    public function it_can_calculate_distance_using_osrm_api()
    {
        // Mock successful OSRM API response
        Http::fake([
            'router.project-osrm.org/*' => Http::response([
                'routes' => [
                    [
                        'distance' => 10000, // 10km in meters
                        'duration' => 900    // 15 minutes in seconds
                    ]
                ]
            ], 200)
        ]);

        $result = $this->osrmService->calculateDistance(-6.2, 106.816666, -6.3, 106.9);

        $this->assertEquals(10.0, $result['distance']);
        $this->assertEquals(15.0, $result['duration']);
        $this->assertEquals('osrm', $result['method']);
    }

    /** @test */
    public function it_falls_back_to_haversine_when_osrm_fails()
    {
        // Mock failed OSRM API response
        Http::fake([
            'router.project-osrm.org/*' => Http::response([], 500)
        ]);

        $result = $this->osrmService->calculateDistance(-6.2, 106.816666, -6.3, 106.9);

        $this->assertIsFloat($result['distance']);
        $this->assertNull($result['duration']);
        $this->assertEquals('haversine', $result['method']);
    }

    /** @test */
    public function it_caches_osrm_results()
    {
        // Mock OSRM API response
        Http::fake([
            'router.project-osrm.org/*' => Http::response([
                'routes' => [
                    [
                        'distance' => 5000,
                        'duration' => 300
                    ]
                ]
            ], 200)
        ]);

        $startLat = -6.2;
        $startLng = 106.816666;
        $endLat = -6.3;
        $endLng = 106.9;

        // First call should hit API
        $result1 = $this->osrmService->calculateDistance($startLat, $startLng, $endLat, $endLng);

        // Second call should hit cache (no HTTP request)
        $result2 = $this->osrmService->calculateDistance($startLat, $startLng, $endLat, $endLng);

        // Results should be identical
        $this->assertEquals($result1, $result2);

        // Should only make one HTTP request
        Http::assertSentCount(1);
    }

    /** @test */
    public function it_calculates_haversine_distance_correctly()
    {
        $distance = $this->osrmService->calculateHaversineDistance(-6.2, 106.816666, -6.3, 106.9);

        $this->assertIsFloat($distance);
        $this->assertGreaterThan(0, $distance);
        $this->assertLessThan(50, $distance); // Should be reasonable distance in km
    }

    /** @test */
    public function it_handles_osrm_api_timeout()
    {
        // Mock timeout
        Http::fake([
            'router.project-osrm.org/*' => function () {
                sleep(15); // Simulate timeout longer than configured 10 seconds
                return Http::response([]);
            }
        ]);

        $result = $this->osrmService->calculateDistance(-6.2, 106.816666, -6.3, 106.9);

        // Should fallback to Haversine
        $this->assertEquals('haversine', $result['method']);
        $this->assertNull($result['duration']);
    }

    /** @test */
    public function it_handles_invalid_osrm_response_structure()
    {
        // Mock invalid response structure
        Http::fake([
            'router.project-osrm.org/*' => Http::response([
                'invalid_structure' => true
            ], 200)
        ]);

        $result = $this->osrmService->calculateDistance(-6.2, 106.816666, -6.3, 106.9);

        // Should fallback to Haversine
        $this->assertEquals('haversine', $result['method']);
    }

    /** @test */
    public function it_handles_empty_routes_array()
    {
        // Mock response with empty routes
        Http::fake([
            'router.project-osrm.org/*' => Http::response([
                'routes' => []
            ], 200)
        ]);

        $result = $this->osrmService->calculateDistance(-6.2, 106.816666, -6.3, 106.9);

        // Should fallback to Haversine
        $this->assertEquals('haversine', $result['method']);
    }
}
