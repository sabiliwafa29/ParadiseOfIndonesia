<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourActivity;
use App\Models\Tour;

class TourActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = Tour::all();

        if ($tours->isEmpty()) {
            $this->command->info('No tours found, skipping TourActivitySeeder.');
            return;
        }

        TourActivity::create([
            'tour_id' => $tours->random()->id,
            'name' => 'Snorkeling di Pulau Menjangan',
            'time' => '09:00 - 12:00',
            'location' => 'Pulau Menjangan, Bali',
            'photo' => 'images/activities/snorkeling.jpg'
        ]);

        TourActivity::create([
            'tour_id' => $tours->random()->id,
            'name' => 'Sunrise di Puncak Borobudur',
            'time' => '04:30 - 06:00',
            'location' => 'Candi Borobudur, Magelang',
            'photo' => 'images/activities/borobudur_sunrise.jpg'
        ]);

        TourActivity::create([
            'tour_id' => $tours->random()->id,
            'name' => 'Trekking ke Kawah Ijen',
            'time' => '01:00 - 07:00',
            'location' => 'Gunung Ijen, Banyuwangi',
            'photo' => 'images/activities/ijen_trekking.jpg'
        ]);
    }
}
