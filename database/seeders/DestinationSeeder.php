<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'name' => 'Bali',
                'slug' => 'bali',
                'description' => 'Bali: the island of the gods, famous for beaches, temples and culture.',
                'location' => 'Bali, Indonesia',
                'image' => 'images/dest-bali.svg',
                'featured' => true,
            ],
            [
                'name' => 'Raja Ampat',
                'slug' => 'raja-ampat',
                'description' => 'Raja Ampat: pristine marine biodiversity and world-class diving.',
                'location' => 'West Papua, Indonesia',
                'image' => 'images/dest-raja.svg',
                'featured' => true,
            ],
            [
                'name' => 'Yogyakarta',
                'slug' => 'yogyakarta',
                'description' => 'Yogyakarta: cultural heart with temples like Borobudur and Prambanan.',
                'location' => 'Java, Indonesia',
                'image' => 'images/dest-jogja.svg',
                'featured' => true,
            ],
        ];

        foreach ($items as $i) {
            Destination::updateOrCreate(['slug' => $i['slug']], $i);
        }
    }
}
