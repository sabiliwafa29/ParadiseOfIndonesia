<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelService;

class TravelServiceSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel travel_services.
     */
    public function run(): void
    {
        // Kosongkan data lama
        TravelService::truncate();

        $services = [
            [
                'name' => 'Toyota Hiace Premio',
                'description' => 'Unit premium dengan kapasitas 12 penumpang, nyaman untuk perjalanan antar kota.',
                'price' => 1200000,
                'type' => 'minibus',
                'image' => 'images/services/hiace_premio.jpg',
            ],
            [
                'name' => 'Isuzu Elf Long',
                'description' => 'Kapasitas besar hingga 16 penumpang, cocok untuk rombongan wisata.',
                'price' => 1500000,
                'type' => 'minibus',
                'image' => 'images/services/elf_long.jpg',
            ],
            [
                'name' => 'Toyota Avanza',
                'description' => 'Mobil keluarga dengan kapasitas 6 penumpang, cocok untuk city tour.',
                'price' => 700000,
                'type' => 'mpv',
                'image' => 'images/services/avanza.png',
            ],
            [
                'name' => 'Suzuki APV Arena',
                'description' => 'Pilihan ekonomis untuk perjalanan dalam kota dengan kapasitas 7 orang.',
                'price' => 650000,
                'type' => 'mpv',
                'image' => 'images/services/apv_arena.png',
            ],
            [
                'name' => 'Daihatsu Luxio',
                'description' => 'Kabin luas dan nyaman untuk perjalanan keluarga kecil.',
                'price' => 750000,
                'type' => 'mpv',
                'image' => 'images/services/luxio.jpg',
            ],
        ];

        foreach ($services as $service) {
            TravelService::create($service);
        }
    }
}
