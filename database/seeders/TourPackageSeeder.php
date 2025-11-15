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
            'description_id' => '6 HARI 5 MALAM | Tumpak Sewu Waterfall- Bromo Tour - Kawah Ijen Blue Fire Carter/Snorkeling Pulau Tabuhan - Dolpin Dance Lovina Beach - Tegalalang, keindahan alam Ubud - Kelingking Beach',
            'description_en' => '6 DAYS 5 NIGHTS | Tumpak Sewu Waterfall - Bromo Tour - Kawah Ijen Blue Fire Carter/Snorkeling Tabuhan Island - Dolpin Dance Lovina Beach - Tegalalang, the natural beauty of Ubud - Kelingking Beach',
            'description_zh' => '6 天 5 晚 | Tumpak Sewu Waterfall - Bromo Tour - Kawah Ijen Blue Fire Carter/Snorkeling Tabuhan Island - Dolpin Dance Lovina Beach - Tegalalang, the natural beauty of Ubud - Kelingking Beach',
            'price' => 15000000,
            'image' => 'images/packages/nusaPenida.jpg',
            'includes_guide' => true,
            'includes_transport' => true,

            // Itinerary dalam format JSON multilanguage, diisi dari detail program yang kamu berikan
            'itinerary' => json_encode([
                [
                    'day' => [
                        'id' => 'DAY 1 – Kedatangan di Surabaya',
                        'en' => 'DAY 1 – Arrival in Surabaya',
                        'zh' => '第1天 - 抵达泗水',
                    ],
                    'activities' => [
                        [
                            'time' => 'Sore',
                            'description_id' => 'Penjemputan kedatangan di Bandara Juanda sesuai jadwal kedatangan pesawat (biasanya sekitar jam 18.00).',
                            'description_en' => 'Pick up at Juanda Airport according to flight arrival schedule (usually around 6 PM).',
                            'description_zh' => '根据航班抵达时间在朱安达机场接机（通常在下午6点左右）。',
                        ],
                        [
                            'time' => 'Malam',
                            'description_id' => 'Pengantaran ke hotel transit di Surabaya untuk beristirahat sebelum perjalanan esok hari.',
                            'description_en' => 'Transfer to transit hotel in Surabaya to rest before the trip on the next day.',
                            'description_zh' => '送往泗水的过渡酒店，在第二天的旅行前休息。',
                        ],
                    ],
                ],
                [
                    'day' => [
                        'id' => 'DAY 2 – Tumpak Sewu Waterfall',
                        'en' => 'DAY 2 – Tumpak Sewu Waterfall',
                        'zh' => '第2天 - Tumpak Sewu 瀑布',
                    ],
                    'activities' => [
                        [
                            'time' => '03.30 – 05.00',
                            'description_id' => 'Penjemputan peserta di hotel transit Kota Surabaya, kemudian perjalanan menuju area masuk Tumpak Sewu di Pronojiwo, Lumajang.',
                            'description_en' => 'Pick up at transit hotel in Surabaya, then drive to the entrance area of Tumpak Sewu in Pronojiwo, Lumajang.',
                            'description_zh' => '在泗水的过渡酒店接机，然后驱车前往 Lumajang Pronojiwo 的 Tumpak Sewu 入口区域。',
                        ],
                        [
                            'time' => '08.00 – 08.30',
                            'description_id' => 'Tiba di rest area Tumpak Sewu, briefing dengan pemandu lokal sebelum trekking.',
                            'description_en' => 'Arrive at Tumpak Sewu rest area, short briefing with local guide before trekking.',
                            'description_zh' => '抵达 Tumpak Sewu 休息区，与当地导游进行简短的徒步旅行简报。',
                        ],
                        [
                            'time' => '08.30 – 12.00',
                            'description_id' => 'Mulai eksplorasi Tumpak Sewu: trekking ke spot panorama, turun ke dasar air terjun, mengunjungi Tebing Nirwana, Telaga Biru, dan Goa Tetes.',
                            'description_en' => 'Start exploring Tumpak Sewu: trek to panorama viewpoint, descend to the base of the falls, visit Tebing Nirwana, Telaga Biru, and Goa Tetes.',
                            'description_zh' => '开始探索 Tumpak Sewu：徒步前往全景观景点，下降到瀑布底部，参观 Tebing Nirwana、Telaga Biru 和 Goa Tetes。',
                        ],
                        [
                            'time' => '12.00 – 13.00',
                            'description_id' => 'Kembali ke rest area untuk bersih diri dan makan siang (opsional).',
                            'description_en' => 'Return to rest area to clean up and have lunch (optional).',
                            'description_zh' => '返回休息区清理并享用午餐（可选）。',
                        ],
                        [
                            'time' => '13.00 – 17.00',
                            'description_id' => 'Persiapan dan perjalanan kembali / menuju hotel untuk beristirahat.',
                            'description_en' => 'Prepare and drive back / to the hotel to rest.',
                            'description_zh' => '准备并驱车返回/前往酒店休息。',
                        ],
                    ],
                    'note' => [
                        'id' => 'Trekking menuju air terjun memiliki tingkat kesulitan sedang dengan tangga bambu dan aliran sungai. Jalur biasanya ditutup sekitar pukul 15.00 WIB, jadi pastikan kembali sebelum waktu tersebut. Disarankan menggunakan pemandu lokal, membawa pakaian ganti, alas kaki trekking, dan jas hujan jika cuaca tidak menentu.',
                        'en' => 'The trek to the waterfall is of medium difficulty with bamboo stairs and river crossings. The trail usually closes around 3 PM, so make sure to return before that. A local guide is highly recommended; bring a change of clothes, trekking shoes, and a raincoat if the weather is unstable.',
                        'zh' => '前往瀑布的徒步旅行难度中等，有竹楼梯和过河。小径通常在下午3点左右关闭，因此请确保在此之前返回。强烈建议使用当地导游；如果天气不稳定，请携带换洗衣物、徒步鞋和雨衣。',
                    ],
                ],
                [
                    'day' => [
                        'id' => 'DAY 3 – Bromo Sunrise',
                        'en' => 'DAY 3 – Bromo Sunrise',
                        'zh' => '第3天 - 布罗莫日出',
                    ],
                    'activities' => [
                        [
                            'time' => '00.00 – 01.00',
                            'description_id' => 'Penjemputan peserta di hotel untuk perjalanan dini hari menuju area Bromo.',
                            'description_en' => 'Pick up from hotel for early morning transfer to Bromo area.',
                            'description_zh' => '从酒店接机，清晨前往布罗莫地区。',
                        ],
                        [
                            'time' => '01.00 – 03.00',
                            'description_id' => 'Perjalanan menuju titik transit atau base camp jeep Bromo.',
                            'description_en' => 'Drive to Bromo jeep base camp / transit point.',
                            'description_zh' => '驱车前往布罗莫吉普车基地/中转点。',
                        ],
                        [
                            'time' => '03.00 – 04.00',
                            'description_id' => 'Naik jeep menuju viewpoint Bukit Penanjakan.',
                            'description_en' => 'Jeep ride to Penanjakan viewpoint for sunrise.',
                            'description_zh' => '乘坐吉普车前往 Penanjakan 观景点观看日出。',
                        ],
                        [
                            'time' => '04.00 – 06.00',
                            'description_id' => 'Menikmati Golden Sunrise Bromo dari Bukit Penanjakan.',
                            'description_en' => 'Enjoy the Golden Sunrise of Bromo from Penanjakan viewpoint.',
                            'description_zh' => '在 Penanjakan 观景点欣赏布罗莫的金色日出。',
                        ],
                        [
                            'time' => '06.00 – 08.30',
                            'description_id' => 'Turun menuju Lautan Pasir, Pura Luhur Poten, dan mendaki ke Kawah Bromo untuk eksplorasi.',
                            'description_en' => 'Descend to the Sea of Sand, visit Pura Luhur Poten, and hike up to Bromo crater for exploration.',
                            'description_zh' => '下降到沙海，参观 Pura Luhur Poten，然后徒步前往布罗莫火山口进行探索。',
                        ],
                        [
                            'time' => '08.30 – 11.00',
                            'description_id' => 'Menuju spot wisata berikutnya seperti Pasir Berbisik dan Bukit Teletubbies (Padang Savana) untuk berfoto.',
                            'description_en' => 'Visit next spots such as Whispering Sands and Teletubbies Hill (Savannah) for photos.',
                            'description_zh' => '参观下一个景点，如耳语沙丘和天线宝宝山（草原）拍照。',
                        ],
                        [
                            'time' => '11.00 – 15.00',
                            'description_id' => 'Perjalanan kembali ke hotel di Banyuwangi, check-in dan istirahat.',
                            'description_en' => 'Drive back to hotel in Banyuwangi, check-in and rest.',
                            'description_zh' => '驱车返回巴纽旺宜的酒店，办理入住并休息。',
                        ],
                        [
                            'time' => '22.00',
                            'description_id' => 'Persiapan perjalanan ke Kawah Ijen pada malam hari.',
                            'description_en' => 'Preparation for the night trip to Kawah Ijen.',
                            'description_zh' => '准备夜间前往 Kawah Ijen。',
                        ],
                    ],
                ],
                [
                    'day' => [
                        'id' => 'DAY 4 – Kawah Ijen Blue Fire & Perjalanan ke Bali',
                        'en' => 'DAY 4 – Kawah Ijen Blue Fire & Transfer to Bali',
                        'zh' => '第4天 - Kawah Ijen 蓝火 & 转移到巴厘岛',
                    ],
                    'activities' => [
                        [
                            'time' => '22.00 – 23.00',
                            'description_id' => 'Penjemputan peserta di hotel dan perjalanan menuju Pos Paltuding.',
                            'description_en' => 'Pick up from hotel and drive to Paltuding Post.',
                            'description_zh' => '从酒店接机，驱车前往 Paltuding 岗位。',
                        ],
                        [
                            'time' => '23.00 – 02.00',
                            'description_id' => 'Perjalanan ke Pos Paltuding dan persiapan pendakian, pemakaian alat, briefing, dan pembekalan dari pemandu.',
                            'description_en' => 'Drive to Paltuding and prepare for the hike: equipment fitting, briefing, and safety instructions from the guide.',
                            'description_zh' => '驱车前往 Paltuding 并准备徒步旅行：装备佩戴、简报和导游的安全说明。',
                        ],
                        [
                            'time' => '02.30 – 03.30',
                            'description_id' => 'Mulai pendakian menuju Kawah Ijen sejauh ±2 km dengan jalur menanjak berpasir dan berbatu (estimasi 1–1,5 jam).',
                            'description_en' => 'Start the hike to Kawah Ijen (±2 km) on an uphill sandy and rocky trail (estimated 1–1.5 hours).',
                            'description_zh' => '开始徒步前往 Kawah Ijen（±2 公里），沿着上坡的沙质和岩石小径（估计1-1.5小时）。',
                        ],
                        [
                            'time' => '03.30 – 06.00',
                            'description_id' => 'Menyaksikan fenomena Blue Fire (jika kondisi memungkinkan) dan menikmati sunrise di Kawah Ijen.',
                            'description_en' => 'Witness the Blue Fire phenomenon (if conditions allow) and enjoy the sunrise over Kawah Ijen.',
                            'description_zh' => '观看蓝火现象（如果条件允许）并欣赏 Kawah Ijen 的日出。',
                        ],
                        [
                            'time' => '06.00 – 07.00',
                            'description_id' => 'Kembali turun ke Pos Paltuding dan beristirahat sejenak.',
                            'description_en' => 'Descend back to Paltuding Post and take a short rest.',
                            'description_zh' => '返回 Paltuding 岗位并稍作休息。',
                        ],
                        [
                            'time' => '07.00 – 09.00',
                            'description_id' => 'Perjalanan kembali ke Banyuwangi dan menuju pelabuhan penyebrangan ke Pulau Bali.',
                            'description_en' => 'Drive back to Banyuwangi and head to the ferry port to Bali.',
                            'description_zh' => '驱车返回巴纽旺宜并前往前往巴厘岛的渡轮码头。',
                        ],
                        [
                            'time' => '09.00 – 13.30',
                            'description_id' => 'Penyebrangan ke Pulau Bali (±2 jam tergantung cuaca, zona waktu berubah dari WIB ke WITA), lalu penjemputan di Pelabuhan Gilimanuk dan perjalanan menuju hotel di sekitar Pantai Lovina.',
                            'description_en' => 'Ferry crossing to Bali (±2 hours depending on weather, time zone changes from WIB to WITA), then pickup at Gilimanuk Harbor and transfer to a hotel near Lovina Beach.',
                            'description_zh' => '乘坐渡轮前往巴厘岛（约2小时，视天气而定，时区从WIB变为WITA），然后在吉利马努克港口接客，前往洛维纳海滩附近的酒店。',
                        ],
                    ],
                    'note' => [
                        'id' => 'Waktu pendakian dapat berbeda tergantung kondisi fisik dan cuaca. API biru biasanya mulai mengecil setelah pukul 05.00 pagi. Wajib membawa masker gas karena bau belerang sangat kuat di sekitar kawah.',
                        'en' => 'Hiking time may vary depending on physical condition and weather. The blue fire usually gets dimmer after 5 AM. A gas mask is mandatory due to strong sulfur smell near the crater.',
                        'zh' => '徒步时间可能因身体状况和天气而异。蓝火通常在早上5点后变暗。由于火山口附近硫磺气味浓烈，必须佩戴防毒面具。',
                    ],
                ],
                [
                    'day' => [
                        'id' => 'DAY 5 – Lovina Dolphin & Ubud Tegalalang',
                        'en' => 'DAY 5 – Lovina Dolphin & Ubud Tegalalang',
                        'zh' => '第5天 – 洛维纳海豚 & 乌布特加拉朗',
                    ],
                    'activities' => [
                        [
                            'time' => '04.00 – 04.30',
                            'description_id' => 'Keluar hotel di Lovina Beach untuk persiapan naik perahu.',
                            'description_en' => 'Leave the hotel at Lovina Beach to prepare for the boat trip.',
                            'description_zh' => '离开洛维纳海滩的酒店，准备乘船出海。',
                        ],
                        [
                            'time' => '05.00 – 07.00',
                            'description_id' => 'Berburu tarian lumba-lumba di tengah laut dengan perahu tradisional.',
                            'description_en' => 'Dolphin watching trip in the open sea with a traditional boat.',
                            'description_zh' => '乘坐传统船只在公海上观赏海豚表演。',
                        ],
                        [
                            'time' => '07.00 – 09.00',
                            'description_id' => 'Sarapan dan bersantai di Pantai Lovina, kemudian checkout hotel.',
                            'description_en' => 'Breakfast and relaxing time at Lovina Beach, then hotel checkout.',
                            'description_zh' => '在洛维纳海滩享用早餐和放松时间，然后办理酒店退房。',
                        ],
                        [
                            'time' => '09.00 – 11.00',
                            'description_id' => 'Perjalanan menuju Tegalalang, Ubud.',
                            'description_en' => 'Drive to Tegalalang, Ubud.',
                            'description_zh' => '驱车前往乌布的特加拉朗。',
                        ],
                        [
                            'time' => '11.00 – 14.00',
                            'description_id' => 'Explore Sawah Terasering Tegalalang, menikmati pemandangan indah, trekking ringan, dan mencoba ayunan ikonik di Bali.',
                            'description_en' => 'Explore Tegalalang Rice Terrace, enjoy the scenery with a light walk, and try one of Bali’s iconic swings.',
                            'description_zh' => '探索特加拉朗梯田，享受轻松徒步的美景，并尝试巴厘岛标志性的秋千之一。',
                        ],
                        [
                            'time' => '14.00 – 16.30',
                            'description_id' => 'Perjalanan menuju hotel di area Legian / Kuta, check-in dan waktu bebas menikmati sunset serta suasana malam di Kuta.',
                            'description_en' => 'Drive to hotel in Legian / Kuta area, check-in and free time to enjoy the sunset and nightlife in Kuta.',
                            'description_zh' => '驱车前往雷吉安/库塔地区的酒店，办理入住手续，自由时间享受库塔的日落和夜生活。',
                        ],
                    ],
                ],
                [
                    'day' => [
                        'id' => 'DAY 6 – One Day Trip Nusa Penida & Kepulangan',
                        'en' => 'DAY 6 – Nusa Penida One Day Trip & Departure',
                        'zh' => '第6天 - 努沙佩尼达一日游 & 出发',
                    ],
                    'activities' => [
                        [
                            'time' => '07.15',
                            'description_id' => 'Penjemputan di hotel menuju Pelabuhan Sanur untuk naik fast boat.',
                            'description_en' => 'Pick up at hotel and transfer to Sanur Harbor to board the fast boat.',
                            'description_zh' => '在酒店接机，前往萨努尔港乘坐快艇。',
                        ],
                        [
                            'time' => '09.00 – 09.45',
                            'description_id' => 'Berangkat dari Sanur ke Nusa Penida dan tiba di pelabuhan Nusa Penida.',
                            'description_en' => 'Fast boat from Sanur to Nusa Penida and arrival at Nusa Penida Harbor.',
                            'description_zh' => '从萨努尔出发前往努沙佩尼达，抵达努沙佩尼达港口。',
                        ],
                        [
                            'time' => '10.50 – 13.30',
                            'description_id' => 'Mengunjungi Angel’s Billabong, Broken Beach, Kelingking Beach, dan Paluang Cliff.',
                            'description_en' => 'Visit Angel’s Billabong, Broken Beach, Kelingking Beach, and Paluang Cliff.',
                            'description_zh' => '参观天使的水池、破碎海滩、克林金海滩和帕鲁昂悬崖。',
                        ],
                        [
                            'time' => '14.30 – 15.00',
                            'description_id' => 'Beristirahat dan makan siang di sekitar Crystal Bay.', 
                            'description_en' => 'Rest and have lunch around Crystal Bay.',
                            'description_zh' => '在水晶湾附近休息并享用午餐。',
                        ],
                        [
                            'time' => '15.30 – 16.15',
                            'description_id' => 'Kembali ke Pelabuhan Nusa Penida, naik fast boat kembali ke Sanur, dan tiba di Sanur.',
                            'description_en' => 'Return to Nusa Penida Harbor, fast boat back to Sanur, and arrive at Sanur.',
                            'description_zh' => '返回努沙佩尼达港口，乘坐快艇返回萨努尔，并抵达萨努尔。',
                        ],
                        [
                            'time' => 'Sore',
                            'description_id' => 'Pengantaran ke bandara untuk penerbangan kepulangan (jadwal menyesuaikan).',
                            'description_en' => 'Transfer to the airport for your return flight (schedule may vary).',
                            'description_zh' => '送往机场，准备返程航班（时间可能有所调整）。',
                        ],
                    ],
                ],
            ]),

            'includes' => json_encode([
                [
                    'name_id' => 'Tour Guide, Transportasi selama tour, dan airport transfer',
                    'name_en' => 'Tour guide, transportation during the tour, and airport transfer',
                    'name_zh' => '导游、旅游期间的交通和机场接送',
                ],
                [
                    'name_id' => 'Hotel selama 5 malam dan sarapan 5x di hotel',
                    'name_en' => 'Hotel for 5 nights and 5x breakfast at the hotel',
                    'name_zh' => '酒店住宿5晚及5次酒店早餐',
                ],
                [
                    'name_id' => 'Tiket penyebrangan, medical checkup, masker di Kawah Ijen (carter)',
                    'name_en' => 'Ferry tickets, medical checkup, and gas mask at Kawah Ijen (charter)',
                    'name_zh' => '渡轮票、体检和伊真火山的防毒面具（包车）',
                ],
                [
                    'name_id' => 'Speedboat di Pantai Lovina dan fast boat di Nusa Penida',
                    'name_en' => 'Speedboat at Lovina Beach and fast boat in Nusa Penida',
                    'name_zh' => '洛维纳海滩的快艇和努沙佩尼达的快艇',
                ],
                [
                    'name_id' => 'Tiket masuk Tegalalang dan seluruh tiket masuk objek wisata utama dalam itinerary',
                    'name_en' => 'Entrance tickets to Tegalalang and all main attractions in the itinerary',
                    'name_zh' => '特加拉朗及行程中所有主要景点的门票',
                ],
            ]),

            'excludes' => json_encode([
                [
                    'name_id' => 'Tracking pole dan jaket pribadi',
                    'name_en' => 'Trekking pole and personal jacket',
                    'name_zh' => '徒步杆和个人夹克',
                ],
                [
                    'name_id' => 'Opsional “local Lamborghini” (kendaraan mewah)',
                    'name_en' => 'Optional “local Lamborghini” (luxury vehicle)',
                    'name_zh' => '可选的“本地兰博基尼”（豪华车辆）',
                ],
                [
                    'name_id' => 'Tiket ayunan di Tegalalang dan surfing di Pantai Kuta',
                    'name_en' => 'Swing ticket at Tegalalang and surfing at Kuta Beach',
                    'name_zh' => '特加拉朗的秋千票和库塔海滩的冲浪票',
                ],
                [
                    'name_id' => 'Masuk diskotik / klub malam di Bali',
                    'name_en' => 'Entrance to clubs / discos in Bali',
                    'name_zh' => '进入巴厘岛的夜总会/迪斯科',
                ],
                [
                    'name_id' => 'Makan selain sarapan di hotel (lunch & dinner)',
                    'name_en' => 'Meals other than breakfast at the hotel (lunch & dinner)',
                    'name_zh' => '除酒店早餐外的餐食（午餐和晚餐）',
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
