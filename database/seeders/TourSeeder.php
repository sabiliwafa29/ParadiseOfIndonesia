<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Destination;

class TourSeeder extends Seeder
{
    public function run()
    {
        // Get destination
        $eastJava = Destination::where('slug', 'east-java')->firstOrFail();

        $tours = [
            [
                'name' => 'Explore Bromo Midnigt',
                'slug' => 'explore-bromo-midnigt',
                'description' => 'Start from Surabaya Gubeng & Juanda airport at 11:00 PM',
                'price_usd' => 90,
                'price_idr' => 1350000, // 90 * 15000
                'price_cny' => 585, // 90 * 6.5
                'exchange_rate_idr' => 15000,
                'exchange_rate_cny' => 6.5,
                'duration' => 2,    
                'destination_id' => $eastJava->id,
                'image' => 'images/tour-bali.svg',
                'itinerary' => json_encode([
                    [
                        'day' => 'DAY 1',
                        'activities' => [
                            ['time' => '23:00', 'description' => 'Penjemputan di Surabaya Gubeng & Juanda airport'],
                            ['time' => '06:00', 'description' => 'Tiba di penanjakan Bromo untuk melihat sunrise']
                        ]
                    ],
                    [
                        'day' => 'DAY 2',
                        'activities' => [
                            ['time' => '08:00', 'description' => 'Kembali ke hotel untuk istirahat'],
                            ['time' => '14:00', 'description' => 'Kembali ke Surabaya']
                        ]
                    ]
                ]),
                'includes' => json_encode([
                    'Tour Guide Profesional',
                    'Transportasi Pribadi',
                    'Makan Pagi',
                    'Tiket Masuk Objek Wisata'
                ]),
                'excludes' => json_encode([
                    'Penerbangan',
                    'Hotel',
                    'Asuransi Perjalanan'
                ]),
                'featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Adventure Bromo',
                'slug' => 'adventure-bromo',
                'description' => 'Start from Surabaya Gubeng & Juanda airport at 11:00 PM',
                'price' => 95,  // ✅ Perubahan dari 950.000 menjadi 95
                'duration' => 2,    
                'destination_id' => $eastJava->id,
                'image' => 'images/tour-bali.svg',
                'itinerary' => json_encode([]),
                'includes' => json_encode([]),
                'excludes' => json_encode([]),
                'featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Tumpak Sewu',
                'slug' => 'tumpak-sewu',
                'description' => 'Air Terjun Tumpak Sewu adalah destinasi wisata alam spektakuler di Jawa Timur yang sering dijuluki "Niagara Falls-nya Indonesia"',
                'price' => 75,  // ✅ Harga yang reasonable
                'duration' => 2,    
                'destination_id' => $eastJava->id,
                'image' => 'images/tour-tumpak-sewu.svg',
                'itinerary' => json_encode([
                    [
                        'day' => 'DAY 1',
                        'activities' => [
                            ['time' => '07:00 - 09:00', 'description' => 'Waktu terbaik untuk kunjungan dan fotografi'],
                            ['time' => '12:00', 'description' => 'Turun ke dasar air terjun untuk pengalaman lebih dekat']
                        ]
                    ]
                ]),
                'includes' => json_encode([
                    'Tour Guide Berpengalaman',
                    'Transportasi',
                    'Peralatan Keselamatan'
                ]),
                'excludes' => json_encode([
                    'Makanan dan Minuman',
                    'Asuransi'
                ]),
                'featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Bromo Tour',
                'slug' => 'bromo-tour',
                'description' => 'Gunung Bromo menawarkan pengalaman wisata alam yang memukau dengan sunrise ikonik dari Penanjakan',
                'price' => 85,
                'duration' => 1,    
                'destination_id' => $eastJava->id,
                'image' => 'images/tour-bromo.svg',
                'itinerary' => json_encode([
                    [
                        'day' => 'DAY 1',
                        'activities' => [
                            ['time' => '03:00', 'description' => 'Jemput di hotel'],
                            ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
                            ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
                            ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
                        ]
                    ]
                ]),
                'includes' => json_encode([
                    'Jemput Antar',
                    'Tour Guide',
                    'Sarapan Pagi',
                    'Tiket Masuk'
                ]),
                'excludes' => json_encode([
                    'Makan Siang dan Malam',
                    'Asuransi Perjalanan'
                ]),
                'featured' => true,
                'status' => 'active',
            ],
        ];

        foreach ($tours as $tour) {
            Tour::firstOrCreate(['slug' => $tour['slug']], $tour);
        }
    }
}