<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourSession;
use App\Models\TourPackage;

class TourSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = TourPackage::all();

        if ($packages->isEmpty()) {
            $this->command->info('No tour packages found, skipping TourSessionSeeder.');
            return;
        }

        TourSession::create([
            'tour_package_id' => $packages->random()->id,
            'name' => 'Festival Danau Toba 2025',
            'description' => 'Paket spesial selama Festival Danau Toba berlangsung.',
            'start_date' => '2025-11-20',
            'end_date' => '2025-11-25',
            'location' => 'Danau Toba, Sumatera Utara',
        ]);

        TourSession::create([
            'tour_package_id' => $packages->random()->id,
            'name' => 'Jazz Gunung Bromo 2025',
            'description' => 'Nikmati musik jazz di ketinggian Bromo dengan paket eksklusif.',
            'start_date' => '2025-07-18',
            'end_date' => '2025-07-20',
            'location' => 'Gunung Bromo, Jawa Timur',
        ]);
    }
}
