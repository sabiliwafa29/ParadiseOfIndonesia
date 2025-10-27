<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Destination;

class TourSeeder extends Seeder
{
    public function run()
    {
        $bali = Destination::where('slug', 'bali')->first();
        $raja = Destination::where('slug', 'raja-ampat')->first();
        $jogja = Destination::where('slug', 'yogyakarta')->first();

        $tours = [
            [
                'name' => 'Bali Beach Escape',
                'slug' => 'bali-beach-escape',
                'description' => 'Relax on Bali\'s best beaches with daily excursions and cultural experiences.',
                'price' => 499.00,
                'duration' => 5,
                'destination_id' => $bali->id,
                'image' => 'images/tour-bali.svg',
                'itinerary' => 'Day 1: Arrival\nDay 2: Beach\nDay 3: Temple',
                'includes' => 'Accommodation, Breakfast, Transfers',
                'excludes' => 'Flights, Personal expenses',
                'featured' => true,
            ],
            [
                'name' => 'Raja Ampat Diving Adventure',
                'slug' => 'raja-ampat-diving',
                'description' => 'Explore world-class diving sites with expert guides and comfortable liveaboard.',
                'price' => 1299.00,
                'duration' => 7,
                'destination_id' => $raja->id,
                'image' => 'images/tour-raja.svg',
                'itinerary' => 'Day 1: Arrival\nDay 2-6: Diving\nDay 7: Departure',
                'includes' => 'Liveaboard, Meals, Diving equipment',
                'excludes' => 'Flights, Dive insurance',
                'featured' => true,
            ],
            [
                'name' => 'Yogyakarta Culture & Temples',
                'slug' => 'yogyakarta-culture',
                'description' => 'Visit Borobudur and Prambanan and experience Javanese culture.',
                'price' => 299.00,
                'duration' => 3,
                'destination_id' => $jogja->id,
                'image' => 'images/tour-jogja.svg',
                'itinerary' => 'Day 1: Borobudur\nDay 2: Prambanan\nDay 3: City tour',
                'includes' => 'Accommodation, Guide, Entrance fees',
                'excludes' => 'Flights, Meals not specified',
                'featured' => true,
            ],
        ];

        foreach ($tours as $t) {
            Tour::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
