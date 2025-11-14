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

        // Contoh data multilanguage
        $packageData = [
            'name_id' => 'PAKET MIX JAWA TIMUR & BALI',
            'name_en' => 'MIX EAST JAVA BALI PARADISE PACKAGE',
            'name_zh' => '东爪哇和巴厘岛混合天堂套餐',
            'description_id' => 'Tumpak Sewu - Bromo Tour - Kawah Ijen Blue Fire Carter - Snorkeling Pulau Tabuhan - Dolpin Dance Lovina Beach - Tegalalang, keindahan alam Ubud - Kelingking Beach',
            'description_en' => 'Tumpak Sewu - Bromo Tour - Kawah Ijen Blue Fire Carter - Snorkeling Pulau Tabuhan - Dolpin Dance Lovina Beach - Tegalalang, the natural beauty of Ubud - Kelingking Beach',
            'description_zh' => 'Tumpak Sewu - 布罗莫之旅 - Ijen火山蓝火 - Tabuhan岛浮潜 - 洛维纳海豚舞 - 乌布Tegalalang的自然美景 - Kelingking海滩',
            'price' => 840,
            'image' => 'images/packages/nusaPenida.jpg',
            'includes_guide' => true,
            'includes_transport' => true,
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
