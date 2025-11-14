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
                'name_id' => 'Jelajah Bromo',
                'name_en' => 'Explore Bromo',
                'name_zh' => '探索布罗莫',
                'slug' => 'explore-bromo',
                'description_id' => 'Mulai dari Stasiun Gubeng Surabaya & Bandara Juanda pukul 23:00.',
                'description_en' => 'Start from Surabaya Gubeng & Juanda airport at 11:00 PM.',
                'description_zh' => '晚上11点从泗水古本火车站和朱安达机场出发。',
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
                'name_id' => 'Petualangan Bromo',
                'name_en' => 'Adventure Bromo',
                'name_zh' => '布罗莫探险',
                'slug' => 'adventure-bromo',
                'description_id' => 'Mulai dari Stasiun Gubeng Surabaya & Bandara Juanda pukul 23:00.',
                'description_en' => 'Start from Surabaya Gubeng & Juanda airport at 11:00 PM.',
                'description_zh' => '晚上11点从泗水古本火车站和朱安达机场出发。',
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
                'name_id' => 'Tumpak Sewu',
                'name_en' => 'Tumpak Sewu',
                'name_zh' => '图姆帕克·塞武',
                'slug' => 'tumpak-sewu',
                'description_id' => 'Air Terjun Tumpak Sewu adalah destinasi wisata alam spektakuler di Jawa Timur yang sering menjadi tujuan favorit para petualang.',
                'description_en' => 'Tumpak Sewu Waterfall is a spectacular natural tourist destination in East Java, often a favorite for adventurers.',
                'description_zh' => 'Tumpak Sewu瀑布是东爪哇壮观的自然旅游胜地，经常成为探险者的最爱。',
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
                'name_id' => 'Tur Bromo',
                'name_en' => 'Bromo Tour',
                'name_zh' => '布罗莫之旅',
                'slug' => 'bromo-tour',
                'description_id' => 'Gunung Bromo menawarkan pengalaman wisata alam yang memukau dengan sunrise ikonik dari Penanjakan.',
                'description_en' => 'Mount Bromo offers a stunning natural tourism experience with its iconic sunrise from Penanjakan.',
                'description_zh' => '布罗莫火山以其标志性的日出为特色，带来令人惊叹的自然旅游体验。',
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
                'name_id' => 'Kawah Ijen Blue Fire Carter',
                'name_en' => 'Kawah Ijen Blue Fire Carter',
                'name_zh' => '伊真火山蓝火之旅',
                'slug' => 'kawah-ijen-blue-fire-carter',
                'description_id' => 'Kawah Ijen terkenal dengan fenomena api biru yang langka dan pemandangan kawah yang menakjubkan.',
                'description_en' => 'Kawah Ijen is famous for its rare blue fire phenomenon and stunning crater views.',
                'description_zh' => '伊真火山以其罕见的蓝色火焰现象和壮观的火山口景色而闻名。',
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
                'name_id' => 'Snorkeling Pulau Tabuhan',
                'name_en' => 'Snorkeling Pulau Tabuhan',
                'name_zh' => '塔布汉岛浮潜',
                'slug' => 'snorkeling-pulau-tabuhan',
                'description_id' => 'Pulau Tabuhan adalah destinasi snorkeling eksotis di Jawa Timur yang menawarkan keindahan bawah laut yang luar biasa.',
                'description_en' => 'Tabuhan Island is an exotic snorkeling destination in East Java offering extraordinary underwater beauty.',
                'description_zh' => '塔布汉岛是东爪哇一个充满异国情调的浮潜胜地，拥有非凡的水下美景。',
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
                'name_id' => 'Tarian Lumba-lumba Pantai Lovina',
                'name_en' => 'Dolpin Dance Lovina Beach',
                'name_zh' => '洛维纳海滩海豚舞',
                'slug' => 'dolpin-dance-lovina-beach',
                'description_id' => 'Pantai Lovina di Bali terkenal dengan atraksi lumba-lumba yang menakjubkan dan suasana pantai yang tenang.',
                'description_en' => 'Lovina Beach in Bali is famous for its amazing dolphin attractions and tranquil beach atmosphere.',
                'description_zh' => '巴厘岛洛维纳海滩以其令人惊叹的海豚表演和宁静的海滩氛围而闻名。',
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
                'name_id' => 'Tegallalang, Keindahan Alam Ubud',
                'name_en' => 'Tegallalang, the natural beauty of Ubud',
                'name_zh' => '德格拉朗，乌布的自然美景',
                'slug' => 'tegalalang-the-natural-beauty-of-ubud',
                'description_id' => 'Tegalalang adalah destinasi wisata ikonik di Ubud, Bali, yang terkenal dengan sawah teraseringnya yang indah.',
                'description_en' => 'Tegallalang is an iconic tourist destination in Ubud, Bali, famous for its beautiful terraced rice fields.',
                'description_zh' => '德格拉朗是巴厘岛乌布的标志性旅游胜地，以其美丽的梯田而闻名。',
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
                'name_id' => 'Pantai Kelingking',
                'name_en' => 'Kelingking Beach',
                'name_zh' => '克林金海滩',
                'slug' => 'kelingking-beach',
                'description_id' => 'Pantai Kelingking di Nusa Penida, Bali, adalah destinasi wisata yang terkenal dengan pemandangan tebing yang unik dan pasir putihnya.',
                'description_en' => 'Kelingking Beach in Nusa Penida, Bali, is a tourist destination famous for its unique cliff views and white sand.',
                'description_zh' => '巴厘岛努沙佩尼达的克林金海滩以其独特的悬崖景观和白色沙滩而闻名。',
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