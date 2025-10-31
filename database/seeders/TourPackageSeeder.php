<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourPackage;
use App\Models\Tour;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = Tour::all();

        if ($tours->count() < 2) {
            $this->command->info('Not enough tours to create packages, skipping TourPackageSeeder.');
            return;
        }

        $package1 = TourPackage::create([
            'name' => 'Java Overland Adventure',
            'description' => 'Jelajahi keindahan pulau Jawa dari barat ke timur, termasuk Borobudur dan Kawah Ijen.',
            'price' => 5000000,
            'image' => 'images/packages/java_adventure.jpg',
        ]);
        $package1->tours()->attach($tours->random(2)->pluck('id'));

        $package2 = TourPackage::create([
            'name' => 'Bali & Lombok Escape',
            'description' => 'Nikmati pantai-pantai eksotis dan budaya unik di Bali dan Lombok.',
            'price' => 4500000,
            'image' => 'images/packages/bali_lombok.jpg',
        ]);
        $package2->tours()->attach($tours->random(2)->pluck('id'));
    }
}
