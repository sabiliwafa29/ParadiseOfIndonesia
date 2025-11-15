<?php

namespace Tests\Feature\Admin;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDestinationValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user for testing
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);
    }

    /**
     * Test destination create page shows and is accessible by admin
     */
    public function test_admin_can_access_destination_create_page()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.destinations.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.destinations.create');
    }

    /**
     * Test destination create with valid data
     */
    public function test_admin_can_create_destination_with_valid_data()
    {
        $data = [
            'name_id' => 'Bromo',
            'name_en' => 'Mount Bromo',
            'name_zh' => '布罗莫火山',
            'slug' => 'mount-bromo',
            'description_id' => 'Gunung yang spektakuler',
            'description_en' => 'A spectacular mountain',
            'description_zh' => '壮观的山',
            'location' => 'East Java, Indonesia',
            'featured' => 0,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.destinations.store'), $data);
        
        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseHas('destinations', [
            'name_id' => 'Bromo',
            'name_en' => 'Mount Bromo',
            'slug' => 'mount-bromo',
        ]);
    }

    /**
     * Test destination create fails with missing required field
     */
    public function test_admin_cannot_create_destination_without_required_fields()
    {
        $data = [
            'name_id' => 'Bromo',
            // Missing name_en
            'name_zh' => '布罗莫火山',
            'slug' => 'mount-bromo',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.destinations.store'), $data);
        
        $response->assertSessionHasErrors('name_en');
    }

    /**
     * Test destination form preserves old values on validation failure
     */
    public function test_destination_form_preserves_old_values_on_error()
    {
        $data = [
            'name_id' => 'Bromo Test',
            'name_en' => 'Mount Bromo Test',
            'name_zh' => '布罗莫火山',
            // Missing slug - will cause validation error
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.destinations.store'), $data);
        
        $response->assertSessionHasErrors('slug');
        // Verify old() helper still has the posted values
        $response->assertSessionHas('_old_input', [
            'name_id' => 'Bromo Test',
            'name_en' => 'Mount Bromo Test',
            'name_zh' => '布罗莫火山',
        ]);
    }

    /**
     * Test destination edit page loads with existing data
     */
    public function test_admin_can_access_destination_edit_page()
    {
        $destination = Destination::factory()->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.destinations.edit', $destination));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.destinations.edit');
        $response->assertViewHas('destination', $destination);
    }

    /**
     * Test destination update with valid data
     */
    public function test_admin_can_update_destination_with_valid_data()
    {
        $destination = Destination::factory()->create([
            'name_id' => 'Old Bromo',
            'name_en' => 'Old Mount Bromo',
        ]);

        $data = [
            'name_id' => 'Updated Bromo',
            'name_en' => 'Updated Mount Bromo',
            'name_zh' => $destination->name_zh,
            'slug' => $destination->slug,
            'description_id' => 'Updated description',
            'description_en' => 'Updated English description',
            'description_zh' => $destination->description_zh,
            'location' => $destination->location,
            'featured' => 0,
        ];

        $response = $this->actingAs($this->adminUser)->put(route('admin.destinations.update', $destination), $data);
        
        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseHas('destinations', [
            'id' => $destination->id,
            'name_id' => 'Updated Bromo',
            'name_en' => 'Updated Mount Bromo',
        ]);
    }

    /**
     * Test destination update fails with invalid data
     */
    public function test_admin_cannot_update_destination_with_invalid_data()
    {
        $destination = Destination::factory()->create();

        $data = [
            'name_id' => 'Valid Name',
            'name_en' => '',  // Empty - invalid
            'name_zh' => 'Valid Chinese',
            'slug' => 'valid-slug',
        ];

        $response = $this->actingAs($this->adminUser)->put(route('admin.destinations.update', $destination), $data);
        
        $response->assertSessionHasErrors('name_en');
    }

    /**
     * Test guest cannot access admin destination pages
     */
    public function test_guest_cannot_access_destination_admin_pages()
    {
        $response = $this->get(route('admin.destinations.create'));
        $response->assertRedirect(route('login'));

        $destination = Destination::factory()->create();
        $response = $this->get(route('admin.destinations.edit', $destination));
        $response->assertRedirect(route('login'));
    }
}
