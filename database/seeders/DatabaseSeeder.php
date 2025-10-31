<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DestinationSeeder::class,
            TourSeeder::class,
            AdminUserSeeder::class,
            TourActivitySeeder::class,
            GallerySeeder::class,
            TourPackageSeeder::class,
            TourSessionSeeder::class,
            TravelServiceSeeder::class,
        ]);
    }
}
