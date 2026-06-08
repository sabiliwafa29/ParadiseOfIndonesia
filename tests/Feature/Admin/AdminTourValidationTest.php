<?php

namespace Tests\Feature\Admin;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTourValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $destination;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);

        $this->destination = Destination::factory()->create();
    }

    /**
     * Test tour create page is accessible by admin
     */
    public function test_admin_can_access_tour_create_page()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.tours.create'));
        $response->assertStatus(200);
        $response->assertViewHas('destinations');
    }

    /**
     * Test tour creation with valid data
     */
    public function test_admin_can_create_tour_with_valid_data()
    {
        $data = [
            'name_id' => 'Petualangan Bromo',
            'name_en' => 'Bromo Adventure',
            'name_zh' => '布罗莫冒险',
            'slug' => 'bromo-adventure',
            'destination_id' => $this->destination->id,
            'price_usd' => 150.00,
            'duration' => 3,
            'description_id' => 'Petualangan menakjubkan',
            'description_en' => 'Amazing adventure',
            'description_zh' => '惊人的冒险',
            'featured' => 0,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.tours.store'), $data);
        
        $response->assertRedirect(route('admin.tours.index'));
        $this->assertDatabaseHas('tours', [
            'name_id' => 'Petualangan Bromo',
            'slug' => 'bromo-adventure',
            'destination_id' => $this->destination->id,
        ]);
    }

    /**
     * Test tour creation fails without required fields
     */
    public function test_admin_cannot_create_tour_without_required_fields()
    {
        $data = [
            'name_id' => 'Petualangan Bromo',
            'name_en' => 'Bromo Adventure',
            // Missing name_zh
            'slug' => 'bromo-adventure',
            'destination_id' => $this->destination->id,
            'price_usd' => 150.00,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.tours.store'), $data);
        
        $response->assertSessionHasErrors(['name_zh', 'duration', 'description_id', 'description_en', 'description_zh']);
    }

    /**
     * Test tour form preserves old values on validation failure
     */
    public function test_tour_form_preserves_old_values_on_error()
    {
        $data = [
            'name_id' => 'Petualangan Bromo',
            'name_en' => 'Bromo Adventure',
            'name_zh' => '布罗莫冒险',
            // Missing slug - will cause validation error
            'destination_id' => $this->destination->id,
            'price_usd' => 150.00,
            'duration' => 3,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.tours.store'), $data);
        
        $response->assertSessionHasErrors('slug');
        $response->assertSessionHas('_old_input.name_id', 'Petualangan Bromo');
        $response->assertSessionHas('_old_input.name_en', 'Bromo Adventure');
    }

    /**
     * Test tour edit page loads with existing data
     */
    public function test_admin_can_access_tour_edit_page()
    {
        $tour = Tour::factory()->create(['destination_id' => $this->destination->id]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.tours.edit', $tour));
        
        $response->assertStatus(200);
        $response->assertViewHas('tour', $tour);
        $response->assertViewHas('destinations');
    }

    /**
     * Test tour update with valid data
     */
    public function test_admin_can_update_tour_with_valid_data()
    {
        $tour = Tour::factory()->create([
            'name_id' => 'Old Bromo',
            'name_en' => 'Old Bromo Adventure',
            'destination_id' => $this->destination->id,
        ]);

        $data = [
            'name_id' => 'Updated Bromo',
            'name_en' => 'Updated Bromo Adventure',
            'name_zh' => $tour->name_zh,
            'slug' => $tour->slug,
            'destination_id' => $this->destination->id,
            'price_usd' => 200.00,
            'duration' => 4,
            'description_id' => $tour->description_id,
            'description_en' => $tour->description_en,
            'description_zh' => $tour->description_zh,
            'featured' => 0,
        ];

        $response = $this->actingAs($this->adminUser)->put(route('admin.tours.update', $tour), $data);
        
        $response->assertRedirect(route('admin.tours.index'));
        $this->assertDatabaseHas('tours', [
            'id' => $tour->id,
            'name_id' => 'Updated Bromo',
            'name_en' => 'Updated Bromo Adventure',
        ]);
    }

    /**
     * Test guest cannot access admin tour pages
     */
    public function test_guest_cannot_access_tour_admin_pages()
    {
        $response = $this->get(route('admin.tours.create'));
        $response->assertRedirect(route('login'));

        $tour = Tour::factory()->create(['destination_id' => $this->destination->id]);
        $response = $this->get(route('admin.tours.edit', $tour));
        $response->assertRedirect(route('login'));
    }
}
