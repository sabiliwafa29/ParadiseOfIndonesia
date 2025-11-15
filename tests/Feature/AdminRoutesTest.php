<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRoutesTest extends TestCase
{
    /** @test */
    public function guest_is_redirected_from_admin_routes()
    {
        $adminRoutes = [
            '/admin/dashboard',
            '/admin/tours',
            '/admin/destinations',
            '/admin/travel-services',
            '/admin/bookings',
            '/admin/users',
            '/admin/gallery',
            '/admin/tour-activities',
            '/admin/tour-packages',
            '/admin/tour-sessions',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);
            // Guest should not receive a 200 OK for admin routes
            $this->assertNotEquals(200, $response->getStatusCode(), "Expected non-200 for guest on {$route}, got 200");
        }
    }
}
