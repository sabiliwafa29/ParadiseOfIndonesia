<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

class DestinationSeeder extends Seeder
{
    public function run()
    {

        // DB::table('destinations')->truncate();

        $items = [
            [
                'name' => 'Paradise of Bali',
                'slug' => 'bali',
                'description' => 'Bali: the island of the gods, famous for beaches, temples and culture.',
                'location' => 'Bali, Indonesia',
                'image' => 'images/dest-bali.svg',
                'featured' => true,
            ],
            [
                'name' => 'Paradise of Papua',
                'slug' => 'papua',
                'description' => 'Papua: Keindahan pulau papua dari pov yang tidak pernah terekspos social media.',
                'location' => 'Papua, Indonesia',
                'image' => 'images/dest-raja.svg',
                'featured' => true,
            ],
            [
                'name' => 'Paradise of Central Java and Yogyakarta',
                'slug' => 'jawatengah-yogyakarta',
                'description' => 'Yogyakarta: cultural heart with temples like Borobudur and Prambanan.',
                'location' => 'Java, Indonesia',
                'image' => 'images/dest-jogja.svg',
                'featured' => true,
            ],
            [
                'name' => 'Paradise of West Java and Jakarta',
                'slug' => 'jawabarat-jakarta',
                'description' => 'Jawa Barat: wisata jawa barat dan jakarta.',
                'location' => 'Java, Indonesia',
                'image' => 'images/dest-jogja.svg',
                'featured' => true,
            ],
            [
                'name' => 'Paradise of Lombok and Komodo',
                'slug' => 'lombok-komodo',
                'description' => 'Lombok: Keindahan di lombok yang tiada tanding.',
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
