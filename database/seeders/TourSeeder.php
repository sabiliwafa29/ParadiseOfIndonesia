<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Destination;

class TourSeeder extends Seeder
{
    public function run()
    {
        $bali = Destination::where('slug', 'bali')->first();
        $raja = Destination::where('slug', 'raja-ampat')->first();
        $jogja = Destination::where('slug', 'yogyakarta')->first();

        $tours = [
            [
                'name' => 'Bali Paradise Escape',
                'slug' => 'bali-beach-escape',
                'description' => 'Nikmati keindahan alam, budaya, dan kuliner khas Pulau Dewata dalam paket 5 hari 4 malam.',
                'price' => 499.00,
                'duration' => 5,
                'destination_id' => $bali->id,
                'image' => 'images/tour-bali.svg',
                'itinerary' => "Kedatangan & Uluwatu Sunset: Penjemputan di Bandara Ngurah Rai; Check-in hotel di Kuta/Seminyak; Pura Uluwatu & Kecak sunset; Makan malam seafood BBQ di Jimbaran; Menginap di Kuta/Seminyak.\nBudaya & Alam Ubud: Sarapan, berangkat ke Ubud; Tegalalang Rice Terrace; Monkey Forest; Pasar Seni Ubud; Makan siang dengan pemandangan lembah; Menginap di Ubud.\nSunrise di Kintamani & Tirta Empul: Pagi ke Gunung Batur untuk sunrise; Sarapan dengan pemandangan Danau Batur; Kunjungan ke Pura Tirta Empul; Makan siang di Tampaksiring; Santai/spa; Menginap di Ubud/Kintamani.\nNusa Penida Island Adventure: Pagi ke Sanur, speedboat ke Nusa Penida; Kelingking Beach; Angel's Billabong & Broken Beach; Crystal Bay (snorkeling opsional); Kembali ke Bali & makan malam di Sanur; Menginap di Sanur/Nusa Dua.\nBelanja & Kepulangan: Sarapan & waktu bebas; Belanja oleh-oleh di Krisna/The Keranjang Bali; Transfer ke Bandara Ngurah Rai untuk keberangkatan.",
                'includes' => "Akomodasi hotel bintang 3-4\nTransportasi ber-AC + driver berpengalaman\nTiket objek wisata\nSpeedboat ke Nusa Penida (PP)\n4x sarapan, 3x makan siang, 2x makan malam\nTour guide lokal berlisensi",
                'excludes' => "Tiket pesawat dari/ke Bali\nPengeluaran pribadi\nAktivitas opsional (spa, watersport)",
                'featured' => true,
            ],
            [
                'name' => 'Raja Ampat Diving Adventure',
                'slug' => 'raja-ampat-diving',
                'description' => 'Explore world-class diving sites with expert guides and comfortable liveaboard.',
                'price' => 1299.00,
                'duration' => 7,
                'destination_id' => $raja->id,
                'image' => 'images/tour-raja.svg',
                'itinerary' => 'Day 1: Arrival\nDay 2-6: Diving\nDay 7: Departure',
                'includes' => 'Liveaboard, Meals, Diving equipment',
                'excludes' => 'Flights, Dive insurance',
                'featured' => true,
            ],
            [
                'name' => 'Yogyakarta Culture & Temples',
                'slug' => 'yogyakarta-culture',
                'description' => 'Visit Borobudur and Prambanan and experience Javanese culture.',
                'price' => 299.00,
                'duration' => 3,
                'destination_id' => $jogja->id,
                'image' => 'images/tour-jogja.svg',
                'itinerary' => 'Day 1: Borobudur\nDay 2: Prambanan\nDay 3: City tour',
                'includes' => 'Accommodation, Guide, Entrance fees',
                'excludes' => 'Flights, Meals not specified',
                'featured' => true,
            ],
        ];

        foreach ($tours as $t) {
            Tour::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
