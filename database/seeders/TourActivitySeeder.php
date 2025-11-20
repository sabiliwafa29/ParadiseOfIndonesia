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
        // Get or create tours for each destination
        $baliTour = $this->ensureTourExists('bali', 'Bali Adventure Tour');
        $yogyaTour = $this->ensureTourExists('jawatengah-yogyakarta', 'Yogyakarta Cultural Tour');
        $eastJavaTour = $this->ensureTourExists('east-java', 'East Java Nature Expedition');

        if (!$baliTour || !$yogyaTour || !$eastJavaTour) {
            $this->command->error('Failed to create required tours. Please check destinations exist.');
            return;
        }

        // Clear existing tour activities to avoid duplicates
        TourActivity::truncate();

        // Bali Activities (using Bali tour)
        TourActivity::create([
            'tour_id' => $baliTour->id,
            'name' => 'Snorkeling di Pulau Menjangan',
            'slug' => 'snorkeling-di-pulau-menjangan',
            'location' => 'Pulau Menjangan, Bali',
            'photo' => 'images/activities/snorkeling.jpg',
            'description' => 'Jelajahi keindahan bawah laut Pulau Menjangan dengan snorkeling. Nikmati terumbu karang yang masih terjaga dan berbagai jenis ikan tropis yang berwarna-warni di perairan jernih Bali Barat.'
        ]);

        TourActivity::create([
            'tour_id' => $baliTour->id,
            'name' => 'Dolphin Dance Lovina Beach',
            'slug' => 'dolphin-dance-lovina-beach',
            'location' => 'Lovina Beach, Bali',
            'photo' => 'images/lovinaBeach.jpg',
            'description' => 'Pantai Lovina adalah destinasi wisata terkenal di pesisir utara Bali yang menawarkan pengalaman melihat lumba-lumba liar di habitat aslinya saat matahari terbit. Waktu terbaik adalah antara pukul 05.30 hingga 07.00 pagi.'
        ]);

        // Yogyakarta Activity (using Yogyakarta tour)
        TourActivity::create([
            'tour_id' => $yogyaTour->id,
            'name' => 'Sunrise di Puncak Borobudur',
            'slug' => 'sunrise-di-puncak-borobudur',
            'location' => 'Candi Borobudur, Magelang',
            'photo' => 'images/activities/borobudur_sunrise.jpg',
            'description' => 'Saksikan matahari terbit yang memukau dari puncak Candi Borobudur, warisan dunia UNESCO. Pengalaman spiritual dan fotografi yang tak terlupakan di tengah kabut pagi yang mistis.'
        ]);

        // East Java Activities (using East Java tour)
        TourActivity::create([
            'tour_id' => $eastJavaTour->id,
            'name' => 'Trekking ke Kawah Ijen',
            'slug' => 'trekking-ke-kawah-ijen',
            'location' => 'Gunung Ijen, Banyuwangi',
            'photo' => 'images/activities/ijen_trekking.jpg',
            'description' => 'Petualangan menantang mendaki Gunung Ijen untuk menyaksikan fenomena Blue Fire yang langka. Nikmati pemandangan kawah dengan danau asam terbesar di dunia dan keindahan sunrise dari ketinggian.'
        ]);
        
        TourActivity::create([
            'tour_id' => $eastJavaTour->id,
            'name' => 'Blue Fire Ijen Crater',
            'slug' => 'blue-fire-ijen-crater',
            'location' => 'Kawah Ijen, Banyuwangi',
            'photo' => 'images/blufireIjenCarter.webp',
            'description' => 'Fenomena Api Biru Kawah Ijen adalah daya tarik alam langka yang hanya dapat ditemukan di dua lokasi di dunia. Api biru terjadi ketika gas belerang bertekanan tinggi terbakar pada suhu ekstrem mencapai 600°C. Waktu terbaik untuk menyaksikannya adalah antara pukul 02.00 hingga 05.00 dini hari.'
        ]);

        TourActivity::create([
            'tour_id' => $eastJavaTour->id,
            'name' => 'Mount Bromo Sunrise',
            'slug' => 'mount-bromo-sunrise',
            'location' => 'Gunung Bromo, Probolinggo',
            'photo' => 'images/activities/bromo-sunrise.jpg',
            'description' => 'Gunung Bromo menawarkan pengalaman wisata alam yang memukau dengan sunrise ikonik dari Penanjakan, lautan pasir yang luas, Kawah Bromo yang berasap, dan Padang Savana Teletubbies. Spot paling populer untuk menyaksikan matahari terbit spektakuler dengan pemandangan Gunung Bromo, Semeru, dan Batok.'
        ]);

        TourActivity::create([
            'tour_id' => $eastJavaTour->id,
            'name' => 'Tumpak Sewu Waterfall Adventure',
            'slug' => 'tumpak-sewu-waterfall-adventure',
            'location' => 'Lumajang, Jawa Timur',
            'photo' => 'images/activities/tumpaksewu.jpg',
            'description' => 'Air Terjun Tumpak Sewu adalah destinasi wisata alam spektakuler yang dijuluki "Niagara Falls-nya Indonesia" dengan formasi air terjun bertingkat setinggi 120 meter. Daya tarik utamanya adalah "Tirai Seribu Air Terjun" dengan ratusan aliran air yang jatuh bersamaan membentuk panorama yang luar biasa indah.'
        ]);
        TourActivity::create([
            'tour_id' => $baliTour->id,
            'name' => 'Tegalalang, the natural beauty of Ubud',
            'slug' => 'tegalalang-the-natural-beauty-of-ubud',
            'location' => 'Ubud, Bali',
            'photo' => 'images/activities/tegallalangBali.jpg',
            'description' => 'Tegalalang di Ubud terkenal karena terasering sawahnya yang indah dan menakjubkan, yang diakui sebagai Situs Warisan Dunia UNESCO. Area ini menawarkan kombinasi unik antara keindahan alam, budaya agrikultur tradisional Bali, dan berbagai aktivitas wisata.'
        ]);
        TourActivity::create([
            'tour_id' => $baliTour->id,
            'name' => 'Kelingking Beach, the iconic cliff of Nusa Penida',
            'slug' => 'kelingking-beach-the-iconic-cliff-of-nusa-penida',
            'location' => 'Nusa Penida, Bali',
            'photo' => 'images/activities/kelingkingBeach.jpg',
            'description' => 'Kelingking Beach di Nusa Penida terkenal dengan tebing ikoniknya yang menyerupai bentuk T-Rex. Pantai ini menawarkan pemandangan spektakuler, pasir putih, dan air laut yang jernih, menjadi destinasi favorit bagi para wisatawan dan fotografer.'
        ]);

        $this->command->info('Tour Activities seeded successfully!');
        $this->command->info('- Bali: 2 activities');
        $this->command->info('- Yogyakarta: 1 activity');
        $this->command->info('- East Java: 4 activities (Ijen, Blue Fire, Bromo, Tumpak Sewu)');
    }

    /**
     * Ensure a tour exists for the destination, create if not exists
     */
    private function ensureTourExists($destinationSlug, $tourName)
    {
        $destination = Destination::where('slug', $destinationSlug)->first();
        
        if (!$destination) {
            $this->command->warn("Destination with slug '{$destinationSlug}' not found!");
            return null;
        }

        // Check if tour already exists for this destination
        $tour = Tour::where('destination_id', $destination->id)->first();

        if (!$tour) {
            // Create a new tour for this destination
            $tour = Tour::create([
                'name_id' => $tourName,
                'name_en' => $tourName,
                'name_zh' => $tourName,
                'slug' => \Illuminate\Support\Str::slug($tourName),
                'description_id' => 'Paket wisata terbaik untuk menjelajahi ' . $destination->name,
                'description_en' => 'Best tour package to explore ' . $destination->name,
                'description_zh' => '探索的最佳旅游套餐 ' . $destination->name,
                'price_usd' => 100.00,
                'price_idr' => 1500000.00,
                'price_cny' => 700.00,
                'duration' => '3',
                'destination_id' => $destination->id,
                'image' => 'images/tours/default.jpg',
                'featured' => true,
                'status' => 'active',
                'target_market' => 'both',
                'exchange_rate_idr' => 15000,
                'exchange_rate_cny' => 7,
            ]);

            $this->command->info("Created tour '{$tourName}' for destination '{$destination->name}'");
        }

        return $tour;
    }
}

