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
            
            // ✅ CONVERTED TO MULTI-LANGUAGE
            'itinerary' => json_encode([
                [
                    'day' => [
                        'id' => 'HARI 1',
                        'en' => 'DAY 1',
                        'zh' => '第1天',
                    ],
                    'activities' => [
                        [
                            'time' => '23.00 - 24.00',
                            'description_id' => 'Penjemputan Peserta di Meeting Point (Stasiun Gubeng / Bandara Juanda)',
                            'description_en' => 'Pick up participants at Meeting Point (Gubeng Station / Juanda Airport)',
                            'description_zh' => '在集合点接参与者（古本火车站/朱安达机场）',
                        ],
                    ]
                ],
                [
                    'day' => [
                        'id' => 'HARI 2',
                        'en' => 'DAY 2',
                        'zh' => '第2天',
                    ],
                    'activities' => [
                        [
                            'time' => '00.00 - 03.00',
                            'description_id' => 'Perjalanan menuju titik transit atau base camp jeep Bromo.',
                            'description_en' => 'Journey to transit point or Bromo jeep base camp.',
                            'description_zh' => '前往中转点或布罗莫吉普车大本营。',
                        ],
                        [
                            'time' => '03.00 - 04.00',
                            'description_id' => 'Naik jeep untuk menuju view point Bukit Penanjakan.',
                            'description_en' => 'Take jeep to Penanjakan Hill viewpoint.',
                            'description_zh' => '乘吉普车前往佩南贾坎山观景点。',
                        ],
                        [
                            'time' => '04.00 - 06.00',
                            'description_id' => 'Menikmati Golden Sunrise Bromo dari Bukit Penanjakan.',
                            'description_en' => 'Enjoy Bromo Golden Sunrise from Penanjakan Hill.',
                            'description_zh' => '从佩南贾坎山欣赏布罗莫金色日出。',
                        ],
                        [
                            'time' => '06.00 - 07.00',
                            'description_id' => 'Turun dari Penanjakan dan menuju Lautan Pasir dan Pura Luhur Poten.',
                            'description_en' => 'Descend from Penanjakan and head to Sea of Sand and Pura Luhur Poten.',
                            'description_zh' => '从佩南贾坎下山，前往沙海和普拉卢胡尔波腾寺。',
                        ],
                        [
                            'time' => '07.00 - 08.30',
                            'description_id' => 'Mendaki ke Kawah Bromo dan melakukan eksplorasi di area sekitar.',
                            'description_en' => 'Climb to Bromo Crater and explore the surrounding area.',
                            'description_zh' => '攀登布罗莫火山口并探索周边地区。',
                        ],
                        [
                            'time' => '08.30 - 09.30',
                            'description_id' => 'Menuju spot wisata berikutnya yaitu Pasir Berbisik dan Bukit Teletubbies (Padang Savana) untuk berfoto.',
                            'description_en' => 'Head to next tourist spots: Whispering Sand and Teletubbies Hill (Savana Field) for photos.',
                            'description_zh' => '前往下一个旅游景点：沙语和天线宝宝山（萨瓦纳田）拍照。',
                        ],
                        [
                            'time' => '09.30 - 11.00',
                            'description_id' => 'Kembali ke base camp jeep.',
                            'description_en' => 'Return to jeep base camp.',
                            'description_zh' => '返回吉普车大本营。',
                        ],
                        [
                            'time' => '11.00 - 12.00',
                            'description_id' => 'Istirahat, makan siang, belanja di pusat oleh-oleh (opsional).',
                            'description_en' => 'Rest, lunch, shopping at souvenir center (optional).',
                            'description_zh' => '休息、午餐、在纪念品中心购物（可选）。',
                        ],
                        [
                            'time' => '12.00 - 15.00',
                            'description_id' => 'Perjalanan kembali ke Surabaya Drop Point.',
                            'description_en' => 'Return journey to Surabaya Drop Point.',
                            'description_zh' => '返回泗水下车点。',
                        ],
                        [
                            'time' => '15.00',
                            'description_id' => 'Selesai',
                            'description_en' => 'Finish',
                            'description_zh' => '结束',
                        ],
                    ]
                ]
            ]),
            
            // ✅ Also update includes/excludes to multi-language
            'includes' => json_encode([
                [
                    'name_id' => 'Tour Guide Profesional',
                    'name_en' => 'Professional Tour Guide',
                    'name_zh' => '专业导游',
                ],
                [
                    'name_id' => 'Transportasi Pribadi',
                    'name_en' => 'Private Transportation',
                    'name_zh' => '私人交通',
                ],
                [
                    'name_id' => 'Makan Pagi',
                    'name_en' => 'Breakfast',
                    'name_zh' => '早餐',
                ],
                [
                    'name_id' => 'Tiket Masuk Objek Wisata',
                    'name_en' => 'Tourist Attraction Entrance Tickets',
                    'name_zh' => '旅游景点门票',
                ],
            ]),
            
            'excludes' => json_encode([
                [
                    'name_id' => 'Penerbangan',
                    'name_en' => 'Flight',
                    'name_zh' => '航班',
                ],
                [
                    'name_id' => 'Hotel',
                    'name_en' => 'Hotel',
                    'name_zh' => '酒店',
                ],
                [
                    'name_id' => 'Asuransi Perjalanan',
                    'name_en' => 'Travel Insurance',
                    'name_zh' => '旅行保险',
                ],
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
                'name_id' => 'Keliling Kota Surabaya',
                'name_en' => 'Surabaya City Tour',
                'name_zh' => '泗水城市游',
                'slug' => 'surabaya-city-tour',
                'description_id' => 'Kota terbesar kedua di Indonesia, Kota Pahlawan di mana perjuangan dimulai dan berakhir, namun semangat kepahlawanannya tetap abadi. Nikmati perjalanan menyusuri situs-situs bersejarah masa lalu yang memukau di tengah pesatnya perkembangan dan budaya di  perkotaan.',
                'description_en' => 'The second largest city in Indonesia, the City of Heroes where the struggle began and ended, yet the spirit of heroism remains eternal. Enjoy a journey through stunning historical sites amidst rapid urban development and culture.',
                'description_zh' => '印度尼西亚第二大城市，英雄之城，斗争始于终结，但英雄主义精神永存。在快速的城市发展和文化中，享受穿越令人惊叹的历史遗迹的旅程。',
                'price_usd' => 20,
                'price_idr' => 350000, // 95 * 16700
                'price_cny' => 148, // 95 * 6.5
                'duration' => 1,    
                'destination_id' => $eastJava->id,
                'image' => 'images/surabaya_tour.jpg',
                'itinerary' => json_encode([
                    [
                        'day' => 'A HALF DAY',
                        'activities' => [
                            ['time' => 'RILEX', 'description' => 'Sesuaikan dengan waktu Anda'],
                        ]
                    ],
                ]),
                'includes' => json_encode([
                    'Parkir',
                    'Tol',
                    'Transportasi City Car/MPV/SUV',
                    'Tiket Masuk Objek Wisata'
                ]),
                'excludes' => json_encode([
                    'Sarapan',
                    'Makan Siang',
                    'Makan Malam',
                    'Shopping',
                    'Tipping',
                    'Hotel'
                ]),
                'featured' => true,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 16700,
                'exchange_rate_cny' => 6.5,
            ],
            // [
            //     'name_id' => 'Tumpak Sewu',
            //     'name_en' => 'Tumpak Sewu',
            //     'name_zh' => '图姆帕克·塞武',
            //     'slug' => 'tumpak-sewu',
            //     'description_id' => 'Air Terjun Tumpak Sewu adalah destinasi wisata alam spektakuler di Jawa Timur yang sering menjadi tujuan favorit para petualang.',
            //     'description_en' => 'Tumpak Sewu Waterfall is a spectacular natural tourist destination in East Java, often a favorite for adventurers.',
            //     'description_zh' => 'Tumpak Sewu瀑布是东爪哇壮观的自然旅游胜地，经常成为探险者的最爱。',
            //     'price_usd' => 75,
            //     'price_idr' => 1125000, // 75 * 16700
            //     'price_cny' => 487.5, // 75 * 6.5
            //     'duration' => 2,    
            //     'destination_id' => $eastJava->id,
            //     'image' => 'images/tumpakSewu.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '07:00 - 09:00', 'description' => 'Waktu terbaik untuk kunjungan dan fotografi'],
            //                 ['time' => '12:00', 'description' => 'Turun ke dasar air terjun untuk pengalaman lebih dekat']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Tour Guide Berpengalaman',
            //         'Transportasi',
            //         'Peralatan Keselamatan'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makanan dan Minuman',
            //         'Asuransi'
            //     ]),
            //     'featured' => true,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
            // [
            //     'name_id' => 'Tur Bromo',
            //     'name_en' => 'Bromo Tour',
            //     'name_zh' => '布罗莫之旅',
            //     'slug' => 'bromo-tour',
            //     'description_id' => 'Gunung Bromo menawarkan pengalaman wisata alam yang memukau dengan sunrise ikonik dari Penanjakan.',
            //     'description_en' => 'Mount Bromo offers a stunning natural tourism experience with its iconic sunrise from Penanjakan.',
            //     'description_zh' => '布罗莫火山以其标志性的日出为特色，带来令人惊叹的自然旅游体验。',
            //     'price_usd' => 85,
            //     'price_idr' => 1275000, // 85 * 16700
            //     'price_cny' => 552.5, // 85 * 6.5
            //     'duration' => 1,    
            //     'destination_id' => $eastJava->id,
            //     'image' => 'images/bromo-tour.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '03:00', 'description' => 'Jemput di hotel'],
            //                 ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
            //                 ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
            //                 ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Jemput Antar',
            //         'Tour Guide',
            //         'Sarapan Pagi',
            //         'Tiket Masuk'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makan Siang dan Malam',
            //         'Asuransi Perjalanan'
            //     ]),
            //     'featured' => false,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
            // [
            //     'name_id' => 'Kawah Ijen Blue Fire Carter',
            //     'name_en' => 'Kawah Ijen Blue Fire Carter',
            //     'name_zh' => '伊真火山蓝火之旅',
            //     'slug' => 'kawah-ijen-blue-fire-carter',
            //     'description_id' => 'Kawah Ijen terkenal dengan fenomena api biru yang langka dan pemandangan kawah yang menakjubkan.',
            //     'description_en' => 'Kawah Ijen is famous for its rare blue fire phenomenon and stunning crater views.',
            //     'description_zh' => '伊真火山以其罕见的蓝色火焰现象和壮观的火山口景色而闻名。',
            //     'price_usd' => 85,
            //     'price_idr' => 1275000, // 85 * 16700
            //     'price_cny' => 552.5, // 85 * 6.5
            //     'duration' => 1,    
            //     'destination_id' => $eastJava->id,
            //     'image' => 'images/kawahIjen.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '03:00', 'description' => 'Jemput di hotel'],
            //                 ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
            //                 ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
            //                 ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Jemput Antar',
            //         'Tour Guide',
            //         'Sarapan Pagi',
            //         'Tiket Masuk'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makan Siang dan Malam',
            //         'Asuransi Perjalanan'
            //     ]),
            //     'featured' => false,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
            // [
            //     'name_id' => 'Snorkeling Pulau Tabuhan',
            //     'name_en' => 'Snorkeling Pulau Tabuhan',
            //     'name_zh' => '塔布汉岛浮潜',
            //     'slug' => 'snorkeling-pulau-tabuhan',
            //     'description_id' => 'Pulau Tabuhan adalah destinasi snorkeling eksotis di Jawa Timur yang menawarkan keindahan bawah laut yang luar biasa.',
            //     'description_en' => 'Tabuhan Island is an exotic snorkeling destination in East Java offering extraordinary underwater beauty.',
            //     'description_zh' => '塔布汉岛是东爪哇一个充满异国情调的浮潜胜地，拥有非凡的水下美景。',
            //     'price_usd' => 85,
            //     'price_idr' => 1275000, // 85 * 16700
            //     'price_cny' => 552.5, // 85 * 6.5
            //     'duration' => 1,    
            //     'destination_id' => $eastJava->id,
            //     'image' => 'images/snorkelingTabuhan.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '03:00', 'description' => 'Jemput di hotel'],
            //                 ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
            //                 ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
            //                 ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Jemput Antar',
            //         'Tour Guide',
            //         'Sarapan Pagi',
            //         'Tiket Masuk'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makan Siang dan Malam',
            //         'Asuransi Perjalanan'
            //     ]),
            //     'featured' => false,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
            // [
            //     'name_id' => 'Tarian Lumba-lumba Pantai Lovina',
            //     'name_en' => 'Dolpin Dance Lovina Beach',
            //     'name_zh' => '洛维纳海滩海豚舞',
            //     'slug' => 'dolpin-dance-lovina-beach',
            //     'description_id' => 'Pantai Lovina di Bali terkenal dengan atraksi lumba-lumba yang menakjubkan dan suasana pantai yang tenang.',
            //     'description_en' => 'Lovina Beach in Bali is famous for its amazing dolphin attractions and tranquil beach atmosphere.',
            //     'description_zh' => '巴厘岛洛维纳海滩以其令人惊叹的海豚表演和宁静的海滩氛围而闻名。',
            //     'price_usd' => 85,
            //     'price_idr' => 1275000, // 85 * 16700
            //     'price_cny' => 552.5, // 85 * 6.5
            //     'duration' => 1,    
            //     'destination_id' => $bali->id,
            //     'image' => 'images/lovinaBeach.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '03:00', 'description' => 'Jemput di hotel'],
            //                 ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
            //                 ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
            //                 ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Jemput Antar',
            //         'Tour Guide',
            //         'Sarapan Pagi',
            //         'Tiket Masuk'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makan Siang dan Malam',
            //         'Asuransi Perjalanan'
            //     ]),
            //     'featured' => false,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
            // [
            //     'name_id' => 'Tegallalang, Keindahan Alam Ubud',
            //     'name_en' => 'Tegallalang, the natural beauty of Ubud',
            //     'name_zh' => '德格拉朗，乌布的自然美景',
            //     'slug' => 'tegalalang-the-natural-beauty-of-ubud',
            //     'description_id' => 'Tegalalang adalah destinasi wisata ikonik di Ubud, Bali, yang terkenal dengan sawah teraseringnya yang indah.',
            //     'description_en' => 'Tegallalang is an iconic tourist destination in Ubud, Bali, famous for its beautiful terraced rice fields.',
            //     'description_zh' => '德格拉朗是巴厘岛乌布的标志性旅游胜地，以其美丽的梯田而闻名。',
            //     'price_usd' => 85,
            //     'price_idr' => 1275000, // 85 * 16700
            //     'price_cny' => 552.5, // 85 * 6.5
            //     'duration' => 1,    
            //     'destination_id' => $bali->id,
            //     'image' => 'images/tegallalangBali.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '03:00', 'description' => 'Jemput di hotel'],
            //                 ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
            //                 ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
            //                 ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Jemput Antar',
            //         'Tour Guide',
            //         'Sarapan Pagi',
            //         'Tiket Masuk'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makan Siang dan Malam',
            //         'Asuransi Perjalanan'
            //     ]),
            //     'featured' => false,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
            // [
            //     'name_id' => 'Pantai Kelingking',
            //     'name_en' => 'Kelingking Beach',
            //     'name_zh' => '克林金海滩',
            //     'slug' => 'kelingking-beach',
            //     'description_id' => 'Pantai Kelingking di Nusa Penida, Bali, adalah destinasi wisata yang terkenal dengan pemandangan tebing yang unik dan pasir putihnya.',
            //     'description_en' => 'Kelingking Beach in Nusa Penida, Bali, is a tourist destination famous for its unique cliff views and white sand.',
            //     'description_zh' => '巴厘岛努沙佩尼达的克林金海滩以其独特的悬崖景观和白色沙滩而闻名。',
            //     'price_usd' => 85,
            //     'price_idr' => 1275000, // 85 * 16700
            //     'price_cny' => 552.5, // 85 * 6.5
            //     'duration' => 1,    
            //     'destination_id' => $bali->id,
            //     'image' => 'images/kelingkingBeach.jpg',
            //     'itinerary' => json_encode([
            //         [
            //             'day' => 'DAY 1',
            //             'activities' => [
            //                 ['time' => '03:00', 'description' => 'Jemput di hotel'],
            //                 ['time' => '04:00 - 06:00', 'description' => 'Perjalanan ke Penanjakan'],
            //                 ['time' => '06:00 - 07:00', 'description' => 'Melihat sunrise dari Penanjakan'],
            //                 ['time' => '08:00 - 12:00', 'description' => 'Trekking di kawah dan padang savana']
            //             ]
            //         ]
            //     ]),
            //     'includes' => json_encode([
            //         'Jemput Antar',
            //         'Tour Guide',
            //         'Sarapan Pagi',
            //         'Tiket Masuk'
            //     ]),
            //     'excludes' => json_encode([
            //         'Makan Siang dan Malam',
            //         'Asuransi Perjalanan'
            //     ]),
            //     'featured' => false,
            //     'status' => 'active',
            //     'target_market' => 'both',
            //     'exchange_rate_idr' => 16700,
            //     'exchange_rate_cny' => 6.5,
            // ],
        ];

        foreach ($tours as $tour) {
            Tour::firstOrCreate(['slug' => $tour['slug']], $tour);
        }

        $this->command->info('✅ Tours seeded successfully!');
    }
}