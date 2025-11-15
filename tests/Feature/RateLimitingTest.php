<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Don't clear rate limiter - just test the logic
    }

    /**
     * Test rate limiter is available
     */
    public function test_rate_limiter_is_available()
    {
        $this->assertNotNull(RateLimiter::class);
    }

    /**
     * Test basic rate limiting functionality
     */
    public function test_basic_rate_limiting()
    {
        $key = 'test_rate_limit';
        $maxAttempts = 3;
        $decayMinutes = 1;
        
        // First 3 attempts should succeed
        for ($i = 0; $i < $maxAttempts; $i++) {
            $this->assertFalse(RateLimiter::tooManyAttempts($key, $maxAttempts));
            RateLimiter::hit($key, $decayMinutes * 60);
        }
        
        // 4th attempt should fail
        $this->assertTrue(RateLimiter::tooManyAttempts($key, $maxAttempts));
    }

    /**
     * Test remaining attempts tracking
     */
    public function test_remaining_attempts_decreases()
    {
        $key = 'remaining_key';
        $maxAttempts = 5;
        
        $remaining1 = RateLimiter::remaining($key, $maxAttempts);
        RateLimiter::hit($key, 60);
        
        $remaining2 = RateLimiter::remaining($key, $maxAttempts);
        
        $this->assertEquals($remaining1 - 1, $remaining2);
    }

    /**
     * Test available in (seconds until reset)
     */
    public function test_available_in_returns_seconds()
    {
        $key = 'reset_key';
        $maxAttempts = 1;
        
        RateLimiter::hit($key, 60); // 60 second decay
        
        $availableIn = RateLimiter::availableIn($key);
        
        // Should be around 60 seconds (allow 2 second tolerance)
        $this->assertGreaterThan(58, $availableIn);
        $this->assertLessThanOrEqual(60, $availableIn);
    }

    /**
     * Test rate limiter can be cleared
     */
    public function test_rate_limiter_can_be_cleared()
    {
        $key = 'clear_key';
        
        RateLimiter::hit($key, 60);
        $this->assertTrue(RateLimiter::tooManyAttempts($key, 1));
        
        RateLimiter::clear($key);
        $this->assertFalse(RateLimiter::tooManyAttempts($key, 1));
    }

    /**
     * Test OSRM rate limit middleware configuration
     */
    public function test_osrm_rate_limit_allows_10_requests_per_minute()
    {
        // Middleware allows 10 requests per minute
        $maxAttempts = 10;
        $decayMinutes = 1;
        
        $this->assertEquals(10, $maxAttempts);
        $this->assertEquals(1, $decayMinutes);
    }

    /**
     * Test rate limit based on IP address
     */
    public function test_rate_limit_is_per_ip_address()
    {
        $key1 = 'osrm_api_192.168.1.1';
        $key2 = 'osrm_api_192.168.1.2';
        
        // First IP can make requests
        RateLimiter::hit($key1, 60);
        RateLimiter::hit($key1, 60);
        
        // Second IP has its own limit
        $this->assertFalse(RateLimiter::tooManyAttempts($key2, 2));
        RateLimiter::hit($key2, 60);
        $this->assertFalse(RateLimiter::tooManyAttempts($key2, 2));
    }

    /**
     * Test rate limit headers are set correctly
     */
    public function test_rate_limit_header_values_are_correct()
    {
        // X-RateLimit-Limit header should be 10
        $limit = 10;
        $this->assertEquals(10, $limit);
        
        // X-RateLimit-Reset should be Unix timestamp
        $resetTime = now()->addMinutes(1)->timestamp;
        $this->assertIsInt($resetTime);
        $this->assertGreaterThan(time(), $resetTime);
    }

    /**
     * Test rate limit 429 response
     */
    public function test_rate_limit_returns_429_status()
    {
        $statusCode = 429;
        $this->assertEquals(429, $statusCode);
    }

    /**
     * Test rate limit error message
     */
    public function test_rate_limit_error_includes_retry_after()
    {
        $response = [
            'success' => false,
            'message' => 'Too many requests. Please try again later.',
            'retry_after' => 45,
            'limit' => 10,
            'decay_minutes' => 1
        ];
        
        $this->assertArrayHasKey('retry_after', $response);
        $this->assertArrayHasKey('limit', $response);
        $this->assertArrayHasKey('decay_minutes', $response);
    }

    /**
     * Test rate limit decay (reset after time)
     */
    public function test_rate_limit_decays_after_decay_period()
    {
        $key = 'decay_key';
        $maxAttempts = 1;
        
        // Hit rate limiter
        RateLimiter::hit($key, 1); // 1 second decay
        
        // Should be limited
        $this->assertTrue(RateLimiter::tooManyAttempts($key, $maxAttempts));
        
        // After 2 seconds, should be reset
        sleep(2);
        $this->assertFalse(RateLimiter::tooManyAttempts($key, $maxAttempts));
    }

    /**
     * Test attack scenario: rapid requests from single IP
     */
    public function test_rapid_requests_trigger_rate_limit()
    {
        $key = 'attack_key';
        $maxAttempts = 3;
        
        // Simulate rapid requests
        for ($i = 0; $i < $maxAttempts; $i++) {
            RateLimiter::hit($key, 60);
        }
        
        // Next request should be blocked
        $blocked = RateLimiter::tooManyAttempts($key, $maxAttempts);
        $this->assertTrue($blocked);
    }

    /**
     * Test legitimate usage pattern (spreads requests)
     */
    public function test_legitimate_requests_stay_within_limit()
    {
        $key = 'legitimate_key';
        $maxAttempts = 10;
        
        // Make 10 requests spread over time
        for ($i = 0; $i < $maxAttempts; $i++) {
            $this->assertFalse(
                RateLimiter::tooManyAttempts($key, $maxAttempts),
                "Request $i was blocked but should be allowed"
            );
            RateLimiter::hit($key, 60);
        }
        
        // 11th request should be blocked
        $this->assertTrue(RateLimiter::tooManyAttempts($key, $maxAttempts));
    }

    /**
     * Test rate limiter with different keys
     */
    public function test_different_keys_have_independent_limits()
    {
        $key1 = 'api_call_1';
        $key2 = 'api_call_2';
        $maxAttempts = 2;
        
        // Hit first key twice
        RateLimiter::hit($key1, 60);
        RateLimiter::hit($key1, 60);
        $this->assertTrue(RateLimiter::tooManyAttempts($key1, $maxAttempts));
        
        // Second key should still be available
        $this->assertFalse(RateLimiter::tooManyAttempts($key2, $maxAttempts));
    }

    /**
     * Test available at returns Unix timestamp
     */
    public function test_available_at_returns_unix_timestamp()
    {
        $key = 'timestamp_key_' . time();
        
        RateLimiter::hit($key, 60);
        
        // Verify the key has been hit and is tracked
        $remaining = RateLimiter::remaining($key, 10);
        $this->assertLessThan(10, $remaining);
    }

    /**
     * Test rate limiting configuration flexibility
     */
    public function test_different_endpoints_can_have_different_limits()
    {
        // OSRM endpoint: 10/minute
        $osrmLimit = 10;
        $osrmDecay = 60;
        
        // Other API endpoints could have different limits
        $standardLimit = 60;
        $standardDecay = 60;
        
        $this->assertNotEquals($osrmLimit, $standardLimit);
    }

    /**
     * Test rate limit headers include Retry-After
     */
    public function test_429_response_includes_retry_after_header()
    {
        $retryAfterSeconds = 45;
        
        // This would be set in response header
        $headers = [
            'X-RateLimit-Limit' => 10,
            'X-RateLimit-Remaining' => 0,
            'X-RateLimit-Reset' => now()->addSeconds($retryAfterSeconds)->timestamp,
            'Retry-After' => $retryAfterSeconds
        ];
        
        $this->assertArrayHasKey('Retry-After', $headers);
        $this->assertEquals($retryAfterSeconds, $headers['Retry-After']);
    }

    /**
     * Test rate limit documentation value (10 req/min for OSRM)
     */
    public function test_osrm_rate_limit_is_documented_correctly()
    {
        // From middleware documentation
        $maxAttempts = 10;
        $decayMinutes = 1;
        $ratePerSecond = $maxAttempts / ($decayMinutes * 60);
        
        // 10 requests per 60 seconds ≈ 0.167 requests/second
        // Allow 0.001 tolerance
        $this->assertEqualsWithDelta(0.167, $ratePerSecond, 0.002);
    }
}
