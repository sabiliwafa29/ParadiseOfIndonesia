<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourActivity;
use App\Models\Tour;
use App\Models\Destination;


class TourActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get destinations by slug/name for better targeting
        $bali = Destination::where('slug', 'bali')->orWhere('name', 'like', '%Bali%')->first();
        $yogyakarta = Destination::where('slug', 'jawatengah-yogyakarta')->orWhere('name', 'like', '%Yogyakarta%')->first();
        $banyuwangi = Destination::where('slug', 'east-java')->orWhere('name', 'like', '%Banyuwangi%')->first();
        $bromo = Destination::where('slug', 'east-java')->orWhere('name', 'like', '%Bromo%')->first();
        $lumajang = Destination::where('slug', 'east-java')->orWhere('name', 'like', '%Lumajang%')->first();

        // Get tours from specific destinations
        $baliTours = $bali ? Tour::where('destination_id', $bali->id)->get() : collect();
        $yogyaTours = $yogyakarta ? Tour::where('destination_id', $yogyakarta->id)->get() : collect();
        $banyuwangiTours = $banyuwangi ? Tour::where('destination_id', $banyuwangi->id)->get() : collect();
        $bromoTours = $bromo ? Tour::where('destination_id', $bromo->id)->get() : collect();
        $lumajangTours = $lumajang ? Tour::where('destination_id', $lumajang->id)->get() : collect();

        // Fallback to any tours if specific destination tours not found
        $tours = Tour::all();

        if ($tours->isEmpty()) {
            $this->command->info('No tours found, skipping TourActivitySeeder.');
            return;
        }

        // Bali Activities
        TourActivity::create([
            'tour_id' => $baliTours->isNotEmpty() ? $baliTours->random()->id : $tours->random()->id,
            'name' => 'Snorkeling di Pulau Tabuhan',
            'slug' => 'snorkeling-di-pulau-tabuhan',
            'location' => 'Pulau Tabuhan, Bali',
            'photo' => 'images/activities/snorkeling.jpg',
            'description' => 'Snorkeling di Pulau Tabuhan, Banyuwangi, menawarkan keindahan bawah laut dengan terumbu karang dan ikan warna-warni. Anda bisa melakukan aktivitas ini dengan menyewa alat di pantai terdekat seperti Bangsring atau menggunakan paket tur yang sudah termasuk perlengkapan, perahu, dan pemandu. Waktu terbaik untuk berkunjung adalah saat musim kemarau karena air lebih tenang dan jernih, biasanya pagi hingga siang hari.'
        ]);

        TourActivity::create([
            'tour_id' => $baliTours->isNotEmpty() ? $baliTours->random()->id : $tours->random()->id,
            'name' => 'Dolphin Dance Lovina Beach',
            'slug' => 'dolphin-dance-lovina-beach',
            'location' => 'Lovina Beach, Bali',
            'photo' => 'images/activities/lovina_dolphins.jpg',
            'description' => 'Pantai Lovina adalah destinasi wisata terkenal di pesisir utara Bali, sekitar 10 km sebelah barat Singaraja, yang daya tarik utamanya adalah pengalaman melihat lumba-lumba liar di habitat aslinya saat matahari terbit 
Berikut adalah beberapa highlight utama dari Pantai Lovina:
Melihat Lumba-lumba Liar: Ratusan lumba-lumba hidung botol dan spesies lain sering terlihat di perairan lepas pantai ini. Pengunjung harus menyewa perahu nelayan tradisional dan berangkat ke tengah laut pada pagi hari, sekitar pukul 06.00 WITA, untuk menyaksikan atraksi alami ini.
Waktu Terbaik: Waktu terbaik untuk melihat lumba-lumba adalah saat matahari terbit, antara pukul 05.30 hingga 07.00 pagi, karena lumba-lumba biasanya muncul pada jam-jam tersebut.

Snorkeling dan Menyelam: Selain melihat lumba-lumba, air laut di Lovina yang relatif tenang dan jernih sangat cocok untuk aktivitas snorkeling dan menyelam, dengan keanekaragaman biota laut yang menarik.
Suasana Tenang: Berbeda dengan pantai-pantai di Bali selatan yang lebih ramai dan berombak besar, Lovina menawarkan suasana yang lebih tenang dan alami, cocok untuk relaksasi.
Pasir Hitam: Pantai ini memiliki ciri khas pasir berwarna hitam.
Destinasi Sekitar: Di sekitar Lovina, pengunjung juga dapat menjelajahi tempat wisata lain seperti Pemandian Air Panas Banjar dan Kuil Buddha Brahmavihara-Arama.
'
        ]);

        // Yogyakarta Activity
        TourActivity::create([
            'tour_id' => $yogyaTours->isNotEmpty() ? $yogyaTours->random()->id : $tours->random()->id,
            'name' => 'Sunrise di Puncak Borobudur',
            'slug' => 'sunrise-di-puncak-borobudur',
            'location' => 'Candi Borobudur, Magelang',
            'photo' => 'images/activities/borobudur_sunrise.jpg',
            'description' => 'Saksikan matahari terbit yang memukau dari puncak Candi Borobudur, warisan dunia UNESCO. Pengalaman spiritual dan fotografi yang tak terlupakan di tengah kabut pagi yang mistis.'
        ]);

        // Banyuwangi Activities
        TourActivity::create([
            'tour_id' => $banyuwangiTours->isNotEmpty() ? $banyuwangiTours->random()->id : $tours->random()->id,
            'name' => 'Trekking ke Kawah Ijen',
            'slug' => 'trekking-ke-kawah-ijen',
            'location' => 'Gunung Ijen, Banyuwangi',
            'photo' => 'images/activities/ijen_trekking.jpg',
            'description' => 'Petualangan menantang mendaki Gunung Ijen untuk menyaksikan fenomena Blue Fire yang langka. Nikmati pemandangan kawah dengan danau asam terbesar di dunia dan keindahan sunrise dari ketinggian.'
        ]);
        
        TourActivity::create([
            'tour_id' => $banyuwangiTours->isNotEmpty() ? $banyuwangiTours->random()->id : $tours->random()->id,
            'name' => 'Blue Fire Ijen Carter',
            'slug' => 'blue-fire-ijen-carter',
            'location' => 'Kawah Ijen, Banyuwangi',
            'photo' => 'images/activities/ijen_trekking.jpg',
            'description' => 'Fenomena Api Biru Kawah Ijen adalah daya tarik alam langka di perbatasan Kabupaten Banyuwangi dan Bondowoso, Jawa Timur. Api biru ini bukanlah lava cair, melainkan api dari pembakaran gas belerang yang muncul dari retakan vulkanik dan hanya dapat dilihat dengan jelas saat gelap gulita. 
Api Biru Kawah Ijen
Penyebab Fenomena: Api biru terjadi ketika gas belerang (SO₂) bertekanan tinggi keluar dari celah batuan vulkanik pada suhu ekstrem, mencapai lebih dari 600°C. Gas-gas ini langsung terbakar saat kontak dengan oksigen di udara, menghasilkan nyala api berwarna biru terang yang bisa mencapai 5 meter tingginya.
Bukan Lava Biru: Meskipun tampak seperti aliran lava biru, warna biru tersebut berasal dari nyala api pembakaran gas belerang, bukan lava cair itu sendiri.
Kelangkaan Global: Fenomena ini sangat langka dan hanya dapat ditemukan di dua lokasi di dunia: Kawah Ijen di Indonesia dan Gunung Dalal di Ethiopia.
Waktu Pengamatan: Api biru hanya terlihat jelas dalam kegelapan. Waktu terbaik untuk menyaksikannya adalah antara pukul 02.00 dini hari hingga sebelum matahari terbit (sekitar pukul 04.30 atau 05.00 pagi). Pendakian biasanya dimulai sekitar pukul 01.00 dini hari untuk mencapai lokasi tepat waktu.
Lokasi: Api biru terlihat di dasar kawah Kawah Ijen, yang juga terkenal dengan danau kawah asam terbesar dan paling berbahaya di dunia.
Kondisi Ekstrem: Area ini penuh dengan asap belerang beracun, sehingga pengunjung wajib menggunakan masker gas untuk keselamatan. Penambang belerang lokal juga bekerja di area ini dalam kondisi yang keras.
Waktu Kunjungan Terbaik: Musim kemarau (April hingga November) adalah waktu terbaik untuk berkunjung karena kondisi cuaca lebih cerah dan jarak pandang lebih baik.
'
        ]);

        // Bromo Activity
        TourActivity::create([
            'tour_id' => $bromoTours->isNotEmpty() ? $bromoTours->random()->id : $tours->random()->id,
            'name' => 'Bromo',
            'slug' => 'bromo',
            'location' => 'Gunung Bromo, Jawa Timur',
            'photo' => 'images/activities/ijen_trekking.jpg',
            'description' => 'Gunung Bromo menawarkan pengalaman wisata alam yang memukau, dengan sunrise ikonik dari Penanjakan, lautan pasir yang luas, Kawah Bromo yang berasap, Padang Savana Teletubbies, dan Pasir Berbisik sebagai daya tarik utama yang wajib dikunjungi, terutama bagi pencinta keindahan alam. 
Daya Tarik Utama Gunung Bromo:
Sunrise Terbaik di Penanjakan: Spot paling populer untuk menyaksikan matahari terbit yang spektakuler, menampilkan pemandangan Gunung Bromo, Gunung Semeru, dan Gunung Batok.
Lautan Pasir: Hamparan pasir yang luas dan unik, menjadi bagian tak terpisahkan dari lanskap Bromo.
Kawah Bromo: Kawah utama yang masih aktif, mengeluarkan asap dan bisa didekati oleh wisatawan.
Padang Savana Teletubbies: Dataran rumput berbukit yang hijau dan bergelombang, mirip dengan pemandangan di film Teletubbies, menjadi spot foto favorit.
Pasir Berbisik: Fenomena pasir yang mengeluarkan suara seperti berbisik ketika tertiup angin.
Pura Luhur Poten: Sebuah pura Hindu yang megah di tengah lautan pasir, menambah nilai budaya dan spiritual. 
Spot Populer Lainnya:
Bukit Kingkong/Kedaluh: Alternatif spot sunrise dengan pemandangan yang tak kalah indah.
Seruni Point: Tembok besar di lereng Penanjakan 2 yang menawarkan pemandangan serupa. 
Aktivitas Unggulan:
Menyaksikan "The Golden Sunrise of Bromo".
Berfoto di Padang Savana Teletubbies.
Mengunjungi Kawah Bromo dan Pasir Berbisik.'
        ]);

        // Lumajang Activity
        TourActivity::create([
            'tour_id' => $lumajangTours->isNotEmpty() ? $lumajangTours->random()->id : $tours->random()->id,
            'name' => 'Tumpak Sewu Waterfall Adventure',
            'slug' => 'tumpak-sewu-waterfall-adventure',
            'location' => 'Lumajang, Jawa Timur',
            'photo' => 'images/activities/ijen_trekking.jpg',
            'description' => 'Air Terjun Tumpak Sewu adalah destinasi wisata alam spektakuler di Jawa Timur yang sering dijuluki "Niagara Falls-nya Indonesia" karena pemandangannya yang megah menyerupai tirai air raksasa. 
Berikut adalah highlight atau daya tarik utama Air Terjun Tumpak Sewu:
Pemandangan "Tirai Seribu Air Terjun": Daya tarik utamanya adalah formasi air terjun bertingkat dengan ratusan aliran air kecil yang jatuh bersamaan di lereng tebing berbentuk setengah lingkaran, menciptakan panorama yang luar biasa indah dan unik.
Ketinggian Mencapai 120 Meter: Air terjun ini memiliki ketinggian sekitar 120 meter dan mengalir ke dalam lembah curam di ketinggian sekitar 450-500 mdpl, memberikan kesan visual yang menakjubkan.
Dua Sudut Pandang (Viewpoints): Pengunjung dapat menikmati keindahan dari dua perspektif:
Dari atas (panorama view): Menawarkan pemandangan keseluruhan air terjun yang dramatis dari ketinggian, cocok untuk mengabadikan momen dengan latar belakang Gunung Semeru (jika cuaca cerah).
Dari bawah (dasar air terjun): Memberikan pengalaman yang lebih imersif, di mana pengunjung dapat merasakan langsung percikan air dan kedekatan dengan aliran air yang deras setelah melalui jalur trekking yang menantang.
Jalur Trekking yang Menantang: Perjalanan turun ke dasar air terjun membutuhkan stamina yang baik dan kehati-hatian karena jalurnya yang curam dan licin, melibatkan tangga bambu dan menyeberangi sungai, menambah unsur petualangan dalam kunjungan.
Hidden Gem Goa Tetes: Di dekat area dasar air terjun, terdapat Goa Tetes, sebuah gua dengan stalaktit dan aliran air kecil yang juga menarik untuk dijelajahi sebagai bagian dari petualangan.
Sumber Air dari Gunung Semeru: Aliran air yang melimpah dan stabil berasal dari mata air alami serta aliran Sungai Glidih yang berhulu di Gunung Semeru, memastikan air terjun tetap spektakuler. 
'
        ]);
    }
}
