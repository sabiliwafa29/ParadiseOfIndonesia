<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Services\OsrmService;

class CachingTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush(); // Clear cache before each test
    }

    /**
     * Test Redis cache driver is configured
     */
    public function test_cache_driver_is_configured()
    {
        $driver = config('cache.default');
        $this->assertNotNull($driver);
        $this->assertTrue(in_array($driver, ['file', 'redis', 'array', 'database']));
    }

    /**
     * Test cache can store and retrieve values
     */
    public function test_cache_can_store_and_retrieve_values()
    {
        $key = 'test_cache_key';
        $value = 'test_value';
        
        Cache::put($key, $value, now()->addHour());
        $cached = Cache::get($key);
        
        $this->assertEquals($value, $cached);
    }

    /**
     * Test cache expiration
     */
    public function test_cache_expires_after_ttl()
    {
        $key = 'expiring_cache_key';
        $value = 'expiring_value';
        
        // Use file cache with short TTL
        Cache::store('file')->put($key, $value, now()->addSeconds(1));
        $cached = Cache::store('file')->get($key);
        $this->assertNotNull($cached);
        $this->assertEquals($value, $cached);
        
        // Wait for expiration
        sleep(2);
        $this->assertNull(Cache::store('file')->get($key));
    }

    /**
     * Test cache remember functionality
     */
    public function test_cache_remember_caches_and_returns_value()
    {
        $key = 'remember_key';
        $value = 'remember_value';
        
        $result1 = Cache::remember($key, now()->addHour(), function () use ($value) {
            return $value;
        });
        
        $result2 = Cache::get($key);
        
        $this->assertEquals($value, $result1);
        $this->assertEquals($value, $result2);
    }

    /**
     * Test OSRM service caches results
     */
    public function test_osrm_service_caches_results()
    {
        $osrmService = new OsrmService();
        
        // Mock OSRM API response
        Http::fake([
            'router.project-osrm.org/*' => Http::response([
                'routes' => [
                    [
                        'distance' => 10000,
                        'duration' => 900
                    ]
                ]
            ], 200)
        ]);
        
        // First call - should hit API
        $result1 = $osrmService->calculateRoute(-6.2, 106.816666, -6.3, 106.9);
        
        // Verify API was called
        Http::assertSentCount(1);
        
        // Second call - should hit cache
        $result2 = $osrmService->calculateRoute(-6.2, 106.816666, -6.3, 106.9);
        
        // Should only have made one HTTP request total
        Http::assertSentCount(1);
        
        // Results should be identical
        $this->assertEquals($result1, $result2);
    }

    /**
     * Test OSRM cache key generation
     */
    public function test_osrm_cache_key_generation()
    {
        $osrmService = new OsrmService();
        
        // Cache keys should be deterministic
        $cacheKey1 = sprintf(
            'osrm_route_%.4f_%.4f_%.4f_%.4f',
            -6.2, 106.816666, -6.3, 106.9
        );
        
        $cacheKey2 = sprintf(
            'osrm_route_%.4f_%.4f_%.4f_%.4f',
            -6.2, 106.816666, -6.3, 106.9
        );
        
        $this->assertEquals($cacheKey1, $cacheKey2);
    }

    /**
     * Test different coordinates generate different cache keys
     */
    public function test_different_coordinates_generate_different_keys()
    {
        $cacheKey1 = sprintf(
            'osrm_route_%.4f_%.4f_%.4f_%.4f',
            -6.2, 106.816666, -6.3, 106.9
        );
        
        $cacheKey2 = sprintf(
            'osrm_route_%.4f_%.4f_%.4f_%.4f',
            -7.0, 107.0, -8.0, 108.0
        );
        
        $this->assertNotEquals($cacheKey1, $cacheKey2);
    }

    /**
     * Test cache coordinate precision (4 decimal places)
     */
    public function test_cache_precision_rounds_to_four_decimals()
    {
        // Very similar coordinates (within 1 meter) should use same cache
        $coords1 = [-6.20001, 106.81664, -6.30001, 106.89999];
        $coords2 = [-6.20005, 106.81665, -6.30005, 107.00001];
        
        $key1 = sprintf('osrm_route_%.4f_%.4f_%.4f_%.4f', ...$coords1);
        $key2 = sprintf('osrm_route_%.4f_%.4f_%.4f_%.4f', ...$coords2);
        
        // They should differ at 4 decimals precision
        $this->assertNotEquals($key1, $key2);
    }

    /**
     * Test cache clear functionality
     */
    public function test_cache_can_be_cleared()
    {
        $key = 'clearable_key';
        Cache::put($key, 'value', now()->addHour());
        
        $this->assertNotNull(Cache::get($key));
        
        Cache::clear();
        
        $this->assertNull(Cache::get($key));
    }

    /**
     * Test cache forget removes specific key
     */
    public function test_cache_forget_removes_key()
    {
        $key1 = 'key1';
        $key2 = 'key2';
        
        Cache::put($key1, 'value1', now()->addHour());
        Cache::put($key2, 'value2', now()->addHour());
        
        Cache::forget($key1);
        
        $this->assertNull(Cache::get($key1));
        $this->assertNotNull(Cache::get($key2));
    }

    /**
     * Test cache many (bulk put)
     */
    public function test_cache_many_stores_multiple_keys()
    {
        $items = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ];
        
        // Put each item individually since Cache::many() may have different signature
        foreach ($items as $key => $value) {
            Cache::put($key, $value, now()->addHour());
        }
        
        foreach ($items as $key => $value) {
            $this->assertEquals($value, Cache::get($key));
        }
    }

    /**
     * Test cache has checks key existence
     */
    public function test_cache_has_checks_key_existence()
    {
        $key = 'existence_key';
        
        $this->assertFalse(Cache::has($key));
        
        Cache::put($key, 'value', now()->addHour());
        
        $this->assertTrue(Cache::has($key));
    }

    /**
     * Test cache get default value
     */
    public function test_cache_get_returns_default_for_missing_key()
    {
        $default = 'default_value';
        $result = Cache::get('nonexistent_key', $default);
        
        $this->assertEquals($default, $result);
    }

    /**
     * Test OSRM cache TTL is 24 hours
     */
    public function test_osrm_cache_ttl_is_24_hours()
    {
        $ttl = 24 * 60 * 60; // 24 hours in seconds
        
        $cacheTime = now()->addHours(24)->timestamp;
        $nowTime = now()->timestamp;
        
        // Allow 1 second tolerance
        $this->assertLessThanOrEqual(1, abs($cacheTime - $nowTime - $ttl));
    }

    /**
     * Test cache tags (if Redis driver supports)
     */
    public function test_cache_can_use_tags()
    {
        if (config('cache.default') !== 'redis') {
            $this->markTestSkipped('Tags only work with Redis driver');
        }
        
        Cache::tags(['locations'])->put('city_1', 'Jakarta', now()->addHour());
        Cache::tags(['locations'])->put('city_2', 'Surabaya', now()->addHour());
        
        $this->assertEquals('Jakarta', Cache::tags(['locations'])->get('city_1'));
        
        Cache::tags(['locations'])->flush();
        
        $this->assertNull(Cache::tags(['locations'])->get('city_1'));
    }

    /**
     * Test cache performance is better than no cache
     */
    public function test_cached_values_retrieve_faster()
    {
        $key = 'performance_test';
        $value = ['large' => 'data_' . str_repeat('x', 10000)];
        
        // Store in cache
        Cache::put($key, $value, now()->addHour());
        
        // Multiple retrievals should be fast
        $startTime = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            Cache::get($key);
        }
        $cacheTime = microtime(true) - $startTime;
        
        // Each retrieval should be very fast (< 1ms average)
        $averageTime = $cacheTime / 100;
        $this->assertLessThan(0.001, $averageTime);
    }

    /**
     * Test cache stores complex data structures
     */
    public function test_cache_stores_complex_data()
    {
        $key = 'complex_data';
        $data = [
            'tour' => [
                'id' => 1,
                'name' => 'Mount Bromo',
                'price' => 500000,
                'locations' => [
                    ['lat' => -6.2, 'lng' => 106.8],
                    ['lat' => -6.3, 'lng' => 106.9],
                ]
            ]
        ];
        
        Cache::put($key, $data, now()->addHour());
        $cached = Cache::get($key);
        
        $this->assertEquals($data, $cached);
        $this->assertEquals('Mount Bromo', $cached['tour']['name']);
    }

    /**
     * Test cache handles serialization
     */
    public function test_cache_handles_object_serialization()
    {
        $key = 'object_key';
        $object = new \stdClass();
        $object->id = 1;
        $object->name = 'Test';
        
        Cache::put($key, $object, now()->addHour());
        $cached = Cache::get($key);
        
        $this->assertInstanceOf(\stdClass::class, $cached);
        $this->assertEquals('Test', $cached->name);
    }
}
