<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourPackage;
use App\Models\Tour;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $tours = Tour::all();

        if ($tours->count() < 2) {
            $this->command->info('❌ Tidak ada cukup tours untuk membuat packages.');
            return;
        }

        // Contoh data multilanguage + itinerary/includes/excludes JSON
        $packageData = [
            'name_id' => 'PAKET MIX JAWA TIMUR & BALI',
            'name_en' => 'MIX EAST JAVA BALI PARADISE PACKAGE',
            'name_zh' => '东爪哇和巴厘岛混合天堂套餐',
            'description_id' => 'Tumpak Sewu Waterfall- Bromo Tour - Kawah Ijen Blue Fire Carter/Snorkeling Pulau Tabuhan - Dolpin Dance Lovina Beach - Tegalalang, keindahan alam Ubud - Kelingking Beach',
            'description_en' => 'Tumpak Sewu Waterfall - Bromo Tour - Kawah Ijen Blue Fire Carter/Snorkeling Tabuhan Island - Dolpin Dance Lovina Beach - Tegalalang, the natural beauty of Ubud - Kelingking Beach',
            'description_zh' => 'Tumpak Sewu Waterfall - Bromo Tour - Kawah Ijen Blue Fire Carter/Snorkeling Tabuhan Island - Dolpin Dance Lovina Beach - Tegalalang, the natural beauty of Ubud - Kelingking Beach',
            'price' => 15000000,
            'image' => 'images/packages/nusaPenida.jpg',
            'includes_guide' => true,
            'includes_transport' => true,

            // =========================
            // ➜ Itinerary (JSON)
            // =========================
            'itinerary' => json_encode([
                [
                    'day' => [
                        'id' => 'Hari 1 – Kedatangan & Tumpak Sewu',
                        'en' => 'Day 1 – Arrival & Tumpak Sewu',
                        'zh' => '第1天 – 抵达 & Tumpak Sewu',
                    ],
                    'activities' => [
                        [
                            'time' => '08:00',
                            'description_id' => 'Penjemputan di bandara / stasiun, menuju penginapan dekat Tumpak Sewu.',
                            'description_en' => 'Pick up at airport / station, transfer to accommodation near Tumpak Sewu.',
                            'description_zh' => '机场/车站接机，前往靠近Tumpak Sewu的住宿。',
                        ],
                        [
                            'time' => '10:30',
                            'description_id' => 'Trekking ke air terjun Tumpak Sewu dan menikmati pemandangan.',
                            'description_en' => 'Trekking to Tumpak Sewu waterfall and enjoy the scenery.',
                            'description_zh' => '徒步前往Tumpak Sewu瀑布，欣赏美景。',
                        ],
                    ],
                ],
                [
                    'day' => [
                        'id' => 'Hari 2 – Bromo Sunrise',
                        'en' => 'Day 2 – Bromo Sunrise',
                        'zh' => '第2天 – 布罗莫日出',
                    ],
                    'activities' => [
                        [
                            'time' => '03:00',
                            'description_id' => 'Berangkat dengan jeep menuju viewpoint Penanjakan untuk sunrise Bromo.',
                            'description_en' => 'Depart by jeep to Penanjakan viewpoint for Bromo sunrise.',
                            'description_zh' => '乘吉普车前往Penanjakan观景台观看布罗莫日出。',
                        ],
                        [
                            'time' => '06:30',
                            'description_id' => 'Tur kawah Bromo dan pasir berbisik.',
                            'description_en' => 'Explore Bromo crater and the whispering sands.',
                            'description_zh' => '游览布罗莫火山口和“耳语沙漠”。',
                        ],
                    ],
                ],
                [
                    'day' => [
                        'id' => 'Hari 3 – Kawah Ijen Blue Fire',
                        'en' => 'Day 3 – Kawah Ijen Blue Fire',
                        'zh' => '第3天 – Ijen蓝火',
                    ],
                    'activities' => [
                        [
                            'time' => '01:00',
                            'description_id' => 'Pendakian dini hari ke Kawah Ijen untuk melihat blue fire.',
                            'description_en' => 'Early morning hike to Kawah Ijen to see the blue fire.',
                            'description_zh' => '清晨徒步前往Ijen火山观看蓝火。',
                        ],
                        [
                            'time' => '07:00',
                            'description_id' => 'Menikmati pemandangan danau kawah, lalu kembali ke penginapan.',
                            'description_en' => 'Enjoy the crater lake view, then return to accommodation.',
                            'description_zh' => '欣赏火山湖景色，然后返回住宿地。',
                        ],
                    ],
                ],
                // Tambah day lain sesuai kebutuhan...
            ]),

            // =========================
            // ➜ Includes (JSON)
            // =========================
            'includes' => json_encode([
                [
                    'name_id' => 'Akomodasi selama tur (hotel / homestay)',
                    'name_en' => 'Accommodation during the tour (hotel / homestay)',
                    'name_zh' => '行程期间住宿（酒店/民宿）',
                ],
                [
                    'name_id' => 'Transportasi lokal selama itinerary',
                    'name_en' => 'Local transportation during the itinerary',
                    'name_zh' => '行程期间的当地交通',
                ],
                [
                    'name_id' => 'Pemandu wisata berbahasa Indonesia / Inggris',
                    'name_en' => 'Indonesian / English speaking tour guide',
                    'name_zh' => '会说印尼语/英语的导游',
                ],
                [
                    'name_id' => 'Tiket masuk objek wisata sesuai program',
                    'name_en' => 'Entrance tickets according to the program',
                    'name_zh' => '行程中景点门票',
                ],
            ]),

            // =========================
            // ➜ Excludes (JSON)
            // =========================
            'excludes' => json_encode([
                [
                    'name_id' => 'Tiket pesawat / kereta menuju titik kumpul',
                    'name_en' => 'Flight/train tickets to meeting point',
                    'name_zh' => '前往集合点的机票/火车票',
                ],
                [
                    'name_id' => 'Makan siang dan makan malam di luar yang disebutkan',
                    'name_en' => 'Lunch and dinner outside the mentioned ones',
                    'name_zh' => '行程外未提及的午餐和晚餐',
                ],
                [
                    'name_id' => 'Asuransi perjalanan pribadi',
                    'name_en' => 'Personal travel insurance',
                    'name_zh' => '个人旅游保险',
                ],
            ]),
        ];

        $package1 = TourPackage::create($packageData);

        // Get Tours
        $tourNamesEn = [
            'Tumpak Sewu',
            'Bromo Tour',
            'Kawah Ijen Blue Fire Carter',
            'Snorkeling Pulau Tabuhan',
            'Dolpin Dance Lovina Beach',
            'Tegalalang, the natural beauty of Ubud',
            'Kelingking Beach',
        ];

        // Ambil tour berdasarkan name_en (karena multilanguage)
        $selectedTours = Tour::whereIn('name_en', $tourNamesEn)->pluck('id');

        if ($selectedTours->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada tour yang cocok ditemukan!');
            return;
        }

        // Attach Tours to Package
        $package1->tours()->attach($selectedTours);

        $this->command->info("✅ Paket '{$package1->name_en}' berhasil dibuat dengan {$selectedTours->count()} tour.");
    }
}
