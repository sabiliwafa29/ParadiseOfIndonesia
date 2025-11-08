<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pickup;

class PickupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pickups = [
            // Bali
            [
                'name' => 'Ngurah Rai International Airport (DPS)',
                'description' => 'Main international airport in Bali, Denpasar',
                'latitude' => -8.7482,
                'longitude' => 115.1675,
            ],
            [
                'name' => 'Denpasar City Center',
                'description' => 'Central area of Denpasar, near hotels and restaurants',
                'latitude' => -8.6563,
                'longitude' => 115.2221,
            ],
            [
                'name' => 'Sanur Beach Terminal',
                'description' => 'Harbor terminal for island trips and water activities',
                'latitude' => -8.6935,
                'longitude' => 115.2622,
            ],
            [
                'name' => 'Kuta Beach Area',
                'description' => 'Popular tourist area with hotels, restaurants, and shopping',
                'latitude' => -8.7224,
                'longitude' => 115.1687,
            ],
            [
                'name' => 'Seminyak Beach',
                'description' => 'Upscale beach area with luxury resorts and restaurants',
                'latitude' => -8.6874,
                'longitude' => 115.1700,
            ],
            [
                'name' => 'Ubud Center',
                'description' => 'Cultural heart of Bali, surrounded by rice terraces and temples',
                'latitude' => -8.5069,
                'longitude' => 115.2625,
            ],

            // Jakarta
            [
                'name' => 'Soekarno-Hatta International Airport (CGK)',
                'description' => 'Main international airport in Jakarta, Tangerang',
                'latitude' => -6.1256,
                'longitude' => 106.6558,
            ],
            [
                'name' => 'Halim Perdanakusuma Airport (HLP)',
                'description' => 'Secondary airport in Jakarta',
                'latitude' => -6.2666,
                'longitude' => 106.8906,
            ],
            [
                'name' => 'Jakarta Central Business District',
                'description' => 'CBD area with offices, hotels, and shopping malls',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ],
            [
                'name' => 'Monas (National Monument)',
                'description' => 'Iconic landmark and central point of Jakarta',
                'latitude' => -6.1751,
                'longitude' => 106.8650,
            ],
            [
                'name' => 'Kemang Area',
                'description' => 'Expat area with restaurants, cafes, and nightlife',
                'latitude' => -6.2608,
                'longitude' => 106.8006,
            ],

            // Yogyakarta
            [
                'name' => 'Yogyakarta International Airport (YIA)',
                'description' => 'New international airport in Yogyakarta, Kulon Progo',
                'latitude' => -7.9072,
                'longitude' => 110.0546,
            ],
            [
                'name' => 'Adisutjipto Airport (JOG)',
                'description' => 'Domestic airport in Yogyakarta',
                'latitude' => -7.7882,
                'longitude' => 110.4318,
            ],
            [
                'name' => 'Malioboro Street',
                'description' => 'Famous shopping street and cultural center',
                'latitude' => -7.7956,
                'longitude' => 110.3694,
            ],
            [
                'name' => 'Yogyakarta City Center',
                'description' => 'Central area with hotels, restaurants, and cultural sites',
                'latitude' => -7.7956,
                'longitude' => 110.3694,
            ],

            // Bandung
            [
                'name' => 'Husein Sastranegara Airport (BDO)',
                'description' => 'Main airport in Bandung',
                'latitude' => -6.9006,
                'longitude' => 107.5762,
            ],
            [
                'name' => 'Bandung City Center',
                'description' => 'Central area with shopping malls and restaurants',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
            ],
            [
                'name' => 'Dago Area',
                'description' => 'Popular area with cafes, restaurants, and shopping',
                'latitude' => -6.8708,
                'longitude' => 107.6181,
            ],

            // Surabaya
            [
                'name' => 'Juanda International Airport (SUB)',
                'description' => 'Main international airport in Surabaya',
                'latitude' => -7.3797,
                'longitude' => 112.7869,
            ],
            [
                'name' => 'Surabaya City Center',
                'description' => 'Central business district of Surabaya',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
            ],

            // Medan
            [
                'name' => 'Kualanamu International Airport (KNO)',
                'description' => 'Main international airport in Medan',
                'latitude' => 3.6425,
                'longitude' => 98.8853,
            ],
            [
                'name' => 'Medan City Center',
                'description' => 'Central area of Medan with hotels and shopping',
                'latitude' => 3.5952,
                'longitude' => 98.6722,
            ],

            // Makassar
            [
                'name' => 'Sultan Hasanuddin International Airport (UPG)',
                'description' => 'Main international airport in Makassar',
                'latitude' => -5.0617,
                'longitude' => 119.5542,
            ],
            [
                'name' => 'Makassar City Center',
                'description' => 'Central area of Makassar',
                'latitude' => -5.1477,
                'longitude' => 119.4327,
            ],

            // Lombok
            [
                'name' => 'Lombok International Airport (LOP)',
                'description' => 'Main airport in Lombok',
                'latitude' => -8.7573,
                'longitude' => 116.2767,
            ],
            [
                'name' => 'Mataram City Center',
                'description' => 'Capital city of West Nusa Tenggara',
                'latitude' => -8.5833,
                'longitude' => 116.1167,
            ],
            [
                'name' => 'Senggigi Beach',
                'description' => 'Popular beach area with resorts and restaurants',
                'latitude' => -8.4833,
                'longitude' => 116.0500,
            ],

            // Batam
            [
                'name' => 'Hang Nadim International Airport (BTH)',
                'description' => 'Main airport in Batam',
                'latitude' => 1.1211,
                'longitude' => 104.1189,
            ],
            [
                'name' => 'Batam Center Ferry Terminal',
                'description' => 'Main ferry terminal connecting to Singapore and Malaysia',
                'latitude' => 1.1311,
                'longitude' => 104.0281,
            ],
        ];

        foreach ($pickups as $pickup) {
            Pickup::updateOrCreate(
                ['name' => $pickup['name']],
                $pickup
            );
        }
    }
}
