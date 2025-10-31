<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\Destination;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = Destination::all();

        if ($destinations->isEmpty()) {
            $this->command->info('No destinations found, skipping GallerySeeder.');
            return;
        }

        Gallery::create([
            'destination_id' => $destinations->random()->id,
            'name' => 'Danau Toba',
            'path' => 'images/Danau-Toba.png'
        ]);

        Gallery::create([
            'destination_id' => $destinations->random()->id,
            'name' => 'Ranu Kumbolo',
            'path' => 'images/ranu-kumbolo.jpg'
        ]);

        Gallery::create([
            'destination_id' => $destinations->random()->id,
            'name' => 'Gunung Raung',
            'path' => 'images/raung.jpg'
        ]);
    }
}
