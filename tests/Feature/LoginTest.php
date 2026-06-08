<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
                ->assertSee('Welcome Back')
                ->assertSee('Sign in to your account');
    }

    public function test_admin_can_login(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/tours');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/')
                ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post('/logout')
             ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_remember_me_functionality(): void
    {
        $user = User::factory()->create([
            'email' => 'remember@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'remember@test.com',
            'password' => 'password123',
            'remember' => 'on',
        ]);

        $response->assertRedirect('/dashboard');
        // Check if remember token is set
        $this->assertNotNull($user->fresh()->remember_token);
    }
}
