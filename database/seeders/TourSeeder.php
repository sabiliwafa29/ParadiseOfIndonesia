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
        $bali = Destination::where('slug', 'bali')->firstOrFail();


        $tours = [
            [
                'name' => 'Explore Bromo',
                'slug' => 'explore-bromo',
                'description' => 'Start from Surabaya Gubeng & Juanda airport at 11:00 PM',
                'price_usd' => 95,
                'price_idr' => 950000, 
                'price_cny' => 715, 
                'duration' => 2,    
                'destination_id' => $eastJava->id,
                'image' => 'images/bromo-midnight.jpg',
                'itinerary' => json_encode([
                    [
                        'day' => 'DAY 1',
                        'activities' => [
                            ['time' => '23.00 - 24.00', 'description' => 'Penjemputan Peserta di Meeting poin ( stasiun Gubeng / Bandara Juanda ) '],
                        ]
                    ],
                    [
                        'day' => 'DAY 2',
                        'activities' => [
                            ['time' => '00.00 - 03.00', 'description' => 'Perjalanan menuju titik transit atau base camp jeep Bromo.'],
                            ['time' => '03.00 - 04.00', 'description' => 'Naik jeep untuk menuju view point Bukit Penanjakan.'],
                            ['time' => '04.00 - 06.00', 'description' => 'Menikmati Golden Sunrise Bromo dari Bukit Penanjakan. '],
                            ['time' => '06.00 - 07.00', 'description' => 'Turun dari Penanjakan dan menuju Lautan Pasir dan Pura Luhur Poten. '],
                            ['time' => '07.00 - 08.30', 'description' => 'Mendaki ke Kawah Bromo dan melakukan eksplorasi di area sekitar. '],
                            ['time' => '08.30 - 09.30', 'description' => 'Menuju spot wisata berikutnya yaitu Pasir Berbisik dan Bukit Teletubbies (Padang Savana) untuk berfoto. '],
                            ['time' => '09.30 - 11.00', 'description' => 'Kembali ke base camp jeep. '],
                            ['time' => '11.00 – 12.00', 'description' => 'Istirahat Break Fas/ luncht, belanja  pusat Oleh-oleh  ( optional )'],
                            ['time' => '11.00 - 15.00', 'description' => 'Perjalanan kembali  ke Surabaya Drop point'],
                            ['time' => '15.00', 'description' => 'Finish'],
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
                'target_market' => 'international',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Adventure Bromo',
                'slug' => 'adventure-bromo',
                'description' => 'Start from Surabaya Gubeng & Juanda airport at 11:00 PM',
                'price_usd' => 95,
                'price_idr' => 950, // 95 * 16700
                'price_cny' => 715, // 95 * 6.5
                'duration' => 2,    
                'destination_id' => $eastJava->id,
                'image' => 'images/bromo-adventure.jpg',
                'itinerary' => json_encode([
                    [
                        'day' => 'DAY 1',
                        'activities' => [
                            ['time' => '23.00 - 24.00', 'description' => 'Penjemputan Peserta di Meeting poin ( stasiun Gubeng / Bandara Juanda ) '],
                        ]
                    ],
                    [
                        'day' => 'DAY 2',
                        'activities' => [
                            ['time' => '00.00 - 03.00', 'description' => 'Perjalanan menuju titik transit atau base camp jeep Bromo.'],
                            ['time' => '03.00 - 04.00', 'description' => 'Naik jeep untuk menuju view point Bukit Penanjakan.'],
                            ['time' => '04.00 - 06.00', 'description' => 'Menikmati Golden Sunrise Bromo dari Bukit Penanjakan. '],
                            ['time' => '06.00 - 07.00', 'description' => 'Turun dari Penanjakan dan menuju Lautan Pasir dan Pura Luhur Poten. '],
                            ['time' => '07.00 - 08.30', 'description' => 'Mendaki ke Kawah Bromo dan melakukan eksplorasi di area sekitar. '],
                            ['time' => '08.30 - 09.30', 'description' => 'Menuju spot wisata berikutnya yaitu Pasir Berbisik dan Bukit Teletubbies (Padang Savana) untuk berfoto. '],
                            ['time' => '09.30 - 11.00', 'description' => 'Kembali ke base camp jeep. '],
                            ['time' => '11.00 – 12.00', 'description' => 'Istirahat Break Fas/ luncht, belanja  pusat Oleh-oleh  ( optional )'],
                            ['time' => '11.00 - 15.00', 'description' => 'Perjalanan kembali  ke Surabaya Drop point'],
                            ['time' => '15.00', 'description' => 'Finish'],
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
                'target_market' => 'domestic',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Tumpak Sewu',
                'slug' => 'tumpak-sewu',
                'description' => 'Air Terjun Tumpak Sewu adalah destinasi wisata alam spektakuler di Jawa Timur yang sering dijuluki "Niagara Falls-nya Indonesia"',
                'price_usd' => 75,
                'price_idr' => 1125000, // 75 * 16700
                'price_cny' => 487.5, // 75 * 6.5
                'duration' => 2,    
                'destination_id' => $eastJava->id,
                'image' => 'images/tumpakSewu.jpg',
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
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Bromo Tour',
                'slug' => 'bromo-tour',
                'description' => 'Gunung Bromo menawarkan pengalaman wisata alam yang memukau dengan sunrise ikonik dari Penanjakan',
                'price_usd' => 85,
                'price_idr' => 1275000, // 85 * 16700
                'price_cny' => 552.5, // 85 * 6.5
                'duration' => 1,    
                'destination_id' => $eastJava->id,
                'image' => 'images/bromo-tour.jpg',
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
                'featured' => false,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Kawah Ijen Blue Fire Carter',
                'slug' => 'kawah-ijen-blue-fire-carter',
                'description' => 'Kawah Ijen terkenal dengan fenomena api biru yang langka dan pemandangan kawah yang menakjubkan di Jawa Timur',
                'price_usd' => 85,
                'price_idr' => 1275000, // 85 * 16700
                'price_cny' => 552.5, // 85 * 6.5
                'duration' => 1,    
                'destination_id' => $eastJava->id,
                'image' => 'images/kawahIjen.jpg',
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
                'featured' => false,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Snorkeling Pulau Tabuhan',
                'slug' => 'snorkeling-pulau-tabuhan',
                'description' => 'Pulau Tabuhan adalah destinasi snorkeling eksotis di Jawa Timur yang menawarkan keindahan terumbu karang dan kehidupan laut yang beragam',
                'price_usd' => 85,
                'price_idr' => 1275000, // 85 * 16700
                'price_cny' => 552.5, // 85 * 6.5
                'duration' => 1,    
                'destination_id' => $eastJava->id,
                'image' => 'images/snorkelingTabuhan.jpg',
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
                'featured' => false,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Dolpin Dance Lovina Beach',
                'slug' => 'dolpin-dance-lovina-beach',
                'description' => 'Lovina Beach di Bali terkenal dengan atraksi lumba-lumba yang menakjubkan dan suasana pantai yang tenang',
                'price_usd' => 85,
                'price_idr' => 1275000, // 85 * 16700
                'price_cny' => 552.5, // 85 * 6.5
                'duration' => 1,    
                'destination_id' => $bali->id,
                'image' => 'images/lovinaBeach.jpg',
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
                'featured' => false,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Tegallalang, the natural beauty of Ubud',
                'slug' => 'tegalalang-the-natural-beauty-of-ubud',
                'description' => 'Tegalalang adalah destinasi wisata ikonik di Ubud, Bali, yang terkenal dengan sawah teraseringnya yang hijau dan pemandangan alam yang menakjubkan',
                'price_usd' => 85,
                'price_idr' => 1275000, // 85 * 16700
                'price_cny' => 552.5, // 85 * 6.5
                'duration' => 1,    
                'destination_id' => $bali->id,
                'image' => 'images/tegallalangBali.jpg',
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
                'featured' => false,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            [
                'name' => 'Kelingking Beach',
                'slug' => 'kelingking-beach',
                'description' => 'Kelingking Beach di Nusa Penida, Bali, adalah destinasi wisata yang terkenal dengan pemandangan tebing ikonik berbentuk T-Rex dan pantai pasir putih yang menakjubkan',
                'price_usd' => 85,
                'price_idr' => 1275000, // 85 * 16700
                'price_cny' => 552.5, // 85 * 6.5
                'duration' => 1,    
                'destination_id' => $bali->id,
                'image' => 'images/kelingkingBeach.jpg',
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
                'featured' => false,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::firstOrCreate(['slug' => $tour['slug']], $tour);
        }

        $this->command->info('✅ Tours seeded successfully!');
    }
}