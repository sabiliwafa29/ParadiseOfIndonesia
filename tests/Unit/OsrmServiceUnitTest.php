<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\OsrmService;

class OsrmServiceUnitTest extends TestCase
{
    /** @test */
    public function haversine_distance_is_zero_for_same_point()
    {
        $service = new OsrmService();
        $distance = $service->calculateHaversineDistance(0.0, 0.0, 0.0, 0.0);
        $this->assertEquals(0.0, $distance);
    }

    /** @test */
    public function calculate_route_uses_osrm_and_caches_result()
    {
        // Fake OSRM response
        $fakeBody = [
            'routes' => [
                [
                    'distance' => 12345, // meters
                    'duration' => 3600,  // seconds
                ],
            ],
        ];

        Http::fake([
            '*' => Http::response($fakeBody, 200),
        ]);

        // Spy on Cache facade
        Cache::shouldReceive('get')->andReturn(null);
        Cache::shouldReceive('put')->once();

        $service = new OsrmService();
        $result = $service->calculateRoute(-8.65, 115.22, -8.50, 115.30);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('distance', $result);
        $this->assertArrayHasKey('duration', $result);
        $this->assertEquals(round(12345 / 1000, 2), $result['distance']);
        $this->assertEquals(round(3600 / 60, 2), $result['duration']);
    }
}
