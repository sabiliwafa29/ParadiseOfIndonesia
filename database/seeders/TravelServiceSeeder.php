<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TravelService;

class TravelServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TravelService::create([
            'name' => 'Jemputan Bandara Soekarno-Hatta',
            'description' => 'Layanan jemputan pribadi dari Bandara Soekarno-Hatta ke hotel Anda di area Jakarta.',
            'price' => 250000,
            'type' => 'airport',
            'image' => 'images/services/airport_pickup.jpg',
        ]);

        TravelService::create([
            'name' => 'Jemputan Stasiun Gambir',
            'description' => 'Layanan jemputan nyaman dari Stasiun Gambir ke tujuan Anda di Jakarta Pusat.',
            'price' => 150000,
            'type' => 'station',
            'image' => 'images/services/station_pickup.jpg',
        ]);

        TravelService::create([
            'name' => 'Antar ke Terminal Pulo Gebang',
            'description' => 'Layanan antar ke Terminal Bus Terpadu Pulo Gebang dari lokasi Anda.',
            'price' => 200000,
            'type' => 'terminal',
            'image' => 'images/services/terminal_dropoff.jpg',
        ]);
    }
}
