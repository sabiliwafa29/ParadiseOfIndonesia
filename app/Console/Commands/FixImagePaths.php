<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Tour;
use App\Models\TourActivity;
use App\Models\TourPackage;

class FixImagePaths extends Command
{
    protected $signature = 'images:fix-paths';
    protected $description = 'Check and report image path issues';

    public function handle()
    {
        $this->info('Checking Tour images...');
        $this->checkTours();
        
        $this->info("\nChecking Tour Activity images...");
        $this->checkTourActivities();
        
        $this->info("\nChecking Tour Package images...");
        $this->checkTourPackages();
        
        $this->info("\n✅ Done! Check the report above.");
    }

    private function checkTours()
    {
        $tours = Tour::all();
        $missing = 0;
        $found = 0;

        foreach ($tours as $tour) {
            if (!$tour->image) {
                continue;
            }

            $inStorage = Storage::disk('public')->exists($tour->image);
            $inPublic = file_exists(public_path($tour->image));

            if (!$inStorage && !$inPublic) {
                $missing++;
                $this->error("  ❌ Tour #{$tour->id}: {$tour->name}");
                $this->line("     Path: {$tour->image}");
                $this->line("     Not found in storage or public directory");
            } else {
                $found++;
                $location = $inStorage ? 'storage/app/public' : 'public';
                $this->line("  ✅ Tour #{$tour->id}: {$tour->name} (in {$location})");
            }
        }

        $this->info("\nTours Summary: {$found} found, {$missing} missing");
    }

    private function checkTourActivities()
    {
        $activities = TourActivity::all();
        $missing = 0;
        $found = 0;

        foreach ($activities as $activity) {
            if (!$activity->photo) {
                continue;
            }

            $inStorage = Storage::disk('public')->exists($activity->photo);
            $inPublic = file_exists(public_path($activity->photo));

            if (!$inStorage && !$inPublic) {
                $missing++;
                $this->error("  ❌ Activity #{$activity->id}: {$activity->name}");
                $this->line("     Path: {$activity->photo}");
                $this->line("     Not found in storage or public directory");
            } else {
                $found++;
                $location = $inStorage ? 'storage/app/public' : 'public';
                $this->line("  ✅ Activity #{$activity->id}: {$activity->name} (in {$location})");
            }
        }

        $this->info("\nActivities Summary: {$found} found, {$missing} missing");
    }

    private function checkTourPackages()
    {
        $packages = TourPackage::all();
        $missing = 0;
        $found = 0;

        foreach ($packages as $package) {
            if (!$package->image) {
                continue;
            }

            $inStorage = Storage::disk('public')->exists($package->image);
            $inPublic = file_exists(public_path($package->image));

            if (!$inStorage && !$inPublic) {
                $missing++;
                $this->error("  ❌ Package #{$package->id}: {$package->name}");
                $this->line("     Path: {$package->image}");
                $this->line("     Not found in storage or public directory");
            } else {
                $found++;
                $location = $inStorage ? 'storage/app/public' : 'public';
                $this->line("  ✅ Package #{$package->id}: {$package->name} (in {$location})");
            }
        }

        $this->info("\nPackages Summary: {$found} found, {$missing} missing");
    }
}
