<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialLink;
use App\Models\TourPackage;
use Illuminate\Support\Str;

class SpecialLinkSeeder extends Seeder
{
    public function run(): void
    {
        // Try to attach to an existing package
        $package = TourPackage::first();

        if (!$package) {
            $this->command->info('No TourPackage found, skipping SpecialLink seeder.');
            return;
        }

        // Create a couple of example special links
        $examples = [
            [
                'token' => 'promo-' . Str::lower(Str::random(8)),
                'tour_package_id' => $package->id,
                'price_special_usd' => 99.00,
                'price_special_idr' => null,
                'price_special_cny' => null,
                'expires_at' => now()->addDays(14),
                'max_uses' => 50,
                'note' => 'Promotional link - 14 days',
                'created_by' => null,
            ],
            [
                'token' => 'vip-' . Str::lower(Str::random(8)),
                'tour_package_id' => $package->id,
                'price_special_usd' => 79.00,
                'price_special_idr' => null,
                'price_special_cny' => null,
                'expires_at' => now()->addMonths(1),
                'max_uses' => 10,
                'note' => 'VIP discount',
                'created_by' => null,
            ],
        ];

        foreach ($examples as $data) {
            SpecialLink::updateOrCreate(['token' => $data['token']], $data);
            $this->command->info('Inserted special link: ' . $data['token']);
        }
    }
}
