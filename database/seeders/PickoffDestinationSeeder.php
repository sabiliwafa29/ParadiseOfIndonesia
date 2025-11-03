<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickoffDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pickoff_destinations')->insert([
            [
                'name' => 'Ubud Palace',
                'description' => 'Cultural center of Bali, surrounded by temples and art markets.',
                'latitude' => -8.5069,
                'longitude' => 115.2625,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tanah Lot Temple',
                'description' => 'Iconic offshore temple and popular sunset spot.',
                'latitude' => -8.6219,
                'longitude' => 115.0866,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Uluwatu Cliff',
                'description' => 'Temple on the cliff with breathtaking ocean views and Kecak dance performances.',
                'latitude' => -8.8287,
                'longitude' => 115.0840,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
