<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pickups')->insert([
            [
                'name' => 'Ngurah Rai Airport',
                'description' => 'Main pickup point for tourists arriving in Bali.',
                'latitude' => -8.7482,
                'longitude' => 115.1675,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Denpasar City Center',
                'description' => 'Central pickup area near hotels and restaurants.',
                'latitude' => -8.6563,
                'longitude' => 115.2221,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sanur Beach Terminal',
                'description' => 'Pickup location near the harbor for island trips.',
                'latitude' => -8.6935,
                'longitude' => 115.2622,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
