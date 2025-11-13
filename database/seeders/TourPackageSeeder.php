<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // Create Package
        $package1 = TourPackage::create([
            'name' => 'MIX EAST JAVA BALI PARADISE PACKAGE',
            'description' => 'Jelajahi keindahan pulau Jawa dari barat ke timur, termasuk Borobudur dan Kawah Ijen.',
            'price' => 840,
            'image' => 'images/packages/java_adventure.jpg',
            'includes_guide' => true,
            'includes_transport' => true,
        ]);

        // Get Tours
        $tourNames = [
            'Tumpak Sewu',
            'Bromo Tour',
            'Kawah Ijen Blue Fire Carter',
            'Snorkeling Pulau Tabuhan',
            'Dolpin Dance Lovina Beach',
            'Tegalalang, the natural beauty of Ubud',
            'Kelingking Beach',
        ];

        $selectedTours = Tour::whereIn('name', $tourNames)->pluck('id');

        if ($selectedTours->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada tour yang cocok ditemukan!');
            return;
        }

        // Attach Tours to Package
        $package1->tours()->attach($selectedTours);
        
        $this->command->info("✅ Paket '{$package1->name}' berhasil dibuat dengan {$selectedTours->count()} tour.");
    }
}