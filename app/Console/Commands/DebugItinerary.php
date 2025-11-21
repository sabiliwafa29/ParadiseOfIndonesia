<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourPackage;

class DebugItinerary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:itinerary {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug itinerary data for tour packages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        
        $this->info('=== TOUR PACKAGE ITINERARY DEBUG ===');
        $this->newLine();

        if ($id) {
            $package = TourPackage::find($id);
            if (!$package) {
                $this->error("Package with ID {$id} not found!");
                return 1;
            }
            $this->debugPackage($package);
        } else {
            $packages = TourPackage::all();
            
            if ($packages->isEmpty()) {
                $this->warn('No tour packages found in database');
                return 0;
            }
            
            foreach ($packages as $package) {
                $this->debugPackage($package);
                $this->newLine();
            }
        }

        return 0;
    }

    private function debugPackage(TourPackage $package)
    {
        $this->line("📦 Package ID: <fg=cyan>{$package->id}</>");
        $this->line("   Name: <fg=yellow>{$package->name_en}</>");
        $this->line('   ' . str_repeat('-', 60));
        
        // 1. Raw value from database
        $raw = $package->getRawOriginal('itinerary');
        $this->line('   <fg=green>1️⃣ RAW DB VALUE:</>');
        $this->line("      Type: " . gettype($raw));
        $this->line("      Length: " . (is_string($raw) ? strlen($raw) : 'N/A') . " chars");
        $this->line("      Preview: " . (is_string($raw) ? substr($raw, 0, 100) . '...' : ($raw ?: 'NULL')));
        $this->newLine();
        
        // 2. After Laravel casting
        $casted = $package->itinerary;
        $this->line('   <fg=green>2️⃣ AFTER CASTING:</>');
        $this->line("      Type: " . gettype($casted));
        $this->line("      Is Array: " . (is_array($casted) ? '<fg=green>YES</>' : '<fg=red>NO</>'));
        $this->line("      Count: " . (is_array($casted) ? count($casted) : 'N/A'));
        
        if (is_array($casted) && !empty($casted)) {
            $this->line("      Keys in first item: <fg=cyan>" . implode(', ', array_keys($casted[0])) . "</>");
            $this->newLine();
            $this->line('      <fg=yellow>Sample Data (first item):</>');
            
            $table = [];
            foreach ($casted[0] as $key => $value) {
                $table[] = [$key, substr($value, 0, 50) . (strlen($value) > 50 ? '...' : '')];
            }
            $this->table(['Key', 'Value'], $table);
        } else {
            $this->line("      Value: " . json_encode($casted));
        }
        
        $this->newLine();
        $this->line('   <fg=green>3️⃣ JSON VALIDATION:</>');
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->line("      <fg=green>✅ Valid JSON</>");
                $this->line("      Decoded type: " . gettype($decoded));
                $this->line("      Decoded count: " . (is_array($decoded) ? count($decoded) : '0'));
            } else {
                $this->line("      <fg=red>❌ Invalid JSON: " . json_last_error_msg() . "</>");
            }
        } else {
            $this->line("      <fg=yellow>⚠️ Not a string, type: " . gettype($raw) . "</>");
        }
        
        $this->newLine();
        $this->line('   <fg=green>4️⃣ MODEL CASTS CHECK:</>');
        $casts = $package->getCasts();
        $this->line("      Itinerary cast: " . ($casts['itinerary'] ?? 'NOT SET'));
        
        $this->line('   ' . str_repeat('=', 60));
    }
}
