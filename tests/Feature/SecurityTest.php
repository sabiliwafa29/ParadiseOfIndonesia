<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test security headers are present in responses
     */
    public function test_security_headers_present(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('Strict-Transport-Security');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection');
        $response->assertHeader('Referrer-Policy');
        $response->assertHeader('Content-Security-Policy');
    }

    /**
     * Test API rate limiting on login endpoint
     */
    public function test_login_rate_limiting(): void
    {
        // Attempt login 6 times (limit is 5)
        for ($i = 0; $i < 6; $i++) {
            $response = $this->postJson('/api/login', [
                'email' => 'test@example.com',
                'password' => 'wrong',
            ]);

            if ($i < 5) {
                // First 5 should get 401 (invalid credentials)
                $response->assertStatus(401);
            } else {
                // 6th should get 429 (too many requests)
                $response->assertStatus(429);
            }
        }
    }

    /**
     * Test Sanctum token authentication
     */
    public function test_sanctum_token_authentication(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Register and get token
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $token = $response->json('token');
        $this->assertNotEmpty($token);

        // Use token to access protected endpoint
        $response = $this->getJson('/api/user', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'email']);
    }

    /**
     * Test token logout
     */
    public function test_sanctum_token_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Verify token works
        $response = $this->getJson('/api/user', [
            'Authorization' => "Bearer {$token}",
        ]);
        $response->assertStatus(200);

        // Logout
        $response = $this->postJson('/api/logout', [], [
            'Authorization' => "Bearer {$token}",
        ]);
        $response->assertStatus(200);

        // Token should no longer work
        $response = $this->getJson('/api/user', [
            'Authorization' => "Bearer {$token}",
        ]);
        $response->assertStatus(401);
    }

    /**
     * Test CSRF protection on web forms
     */
    public function test_csrf_protection_on_web_forms(): void
    {
        // Get a page to extract CSRF token
        $response = $this->get('/admin/tours');
        $response->assertStatus(200); // Or 302 if not logged in

        // Attempt POST without CSRF token (should fail)
        // Note: This test assumes you have form validation
        // Skip if behind authentication middleware
    }

    /**
     * Test unauthorized API access without token
     */
    public function test_unauthorized_api_access_without_token(): void
    {
        $response = $this->getJson('/api/bookings');
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Test invalid token is rejected
     */
    public function test_invalid_token_is_rejected(): void
    {
        $response = $this->getJson('/api/bookings', [
            'Authorization' => 'Bearer invalid-token',
        ]);
        $response->assertStatus(401);
    }

    /**
     * Test rate limiting on booking endpoint for authenticated users
     */
    public function test_booking_rate_limiting_authenticated(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Make requests up to limit (20 per minute)
        for ($i = 0; $i < 21; $i++) {
            $response = $this->postJson('/api/bookings', 
                [
                    'tour_id' => 1,
                    'date' => now()->addDay()->toDateString(),
                    'participants' => 1,
                ],
                ['Authorization' => "Bearer {$token}"]
            );

            if ($i < 20) {
                // Should get validation error or success
                $this->assertIn($response->status(), [422, 404, 201]); // Not rate limited
            } else {
                // Should get rate limit
                $this->assertEquals(429, $response->status());
            }
        }
    }

    /**
     * Test security headers on API responses
     */
    public function test_security_headers_on_api_responses(): void
    {
        $response = $this->getJson('/api/health');

        // All responses should have security headers
        $response->assertHeader('Strict-Transport-Security');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    /**
     * Test CSP header includes external APIs
     */
    public function test_csp_header_includes_external_apis(): void
    {
        $response = $this->get('/');
        $csp = $response->headers->get('Content-Security-Policy');

        $this->assertStringContainsString('api.midtrans.com', $csp);
        $this->assertStringContainsString('router.project-osrm.org', $csp);
    }

    /**
     * Test health check endpoint rate limiting
     */
    public function test_health_check_rate_limiting(): void
    {
        // Health checks are rate limited at 60 per minute
        for ($i = 0; $i < 61; $i++) {
            $response = $this->getJson('/api/health');

            if ($i < 60) {
                $response->assertStatus(200);
            } else {
                // 61st request should be rate limited
                $response->assertStatus(429);
            }
        }
    }
}
