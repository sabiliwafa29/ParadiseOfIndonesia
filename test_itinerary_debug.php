<?php
/**
 * Test script untuk debug itinerary data
 * Jalankan: php test_itinerary_debug.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TourPackage;

echo "=== TOUR PACKAGE ITINERARY DEBUG ===\n\n";

// Get all tour packages
$packages = TourPackage::all();

if ($packages->isEmpty()) {
    echo "❌ Tidak ada tour package di database\n";
    exit;
}

foreach ($packages as $package) {
    echo "📦 Package ID: {$package->id}\n";
    echo "   Name: {$package->name_en}\n";
    echo "   ------------------------\n";
    
    // 1. Raw value from database
    $raw = $package->getRawOriginal('itinerary');
    echo "   1️⃣ RAW DB VALUE:\n";
    echo "      Type: " . gettype($raw) . "\n";
    echo "      Value: " . ($raw ?: 'NULL') . "\n\n";
    
    // 2. After Laravel casting
    $casted = $package->itinerary;
    echo "   2️⃣ AFTER CASTING:\n";
    echo "      Type: " . gettype($casted) . "\n";
    echo "      Is Array: " . (is_array($casted) ? 'YES' : 'NO') . "\n";
    echo "      Count: " . (is_array($casted) ? count($casted) : 'N/A') . "\n";
    
    if (is_array($casted) && !empty($casted)) {
        echo "      First item keys: " . implode(', ', array_keys($casted[0])) . "\n";
        echo "      Sample data:\n";
        echo "      " . json_encode($casted[0], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    } else {
        echo "      Value: " . json_encode($casted) . "\n";
    }
    
    echo "\n   3️⃣ JSON VALIDATION:\n";
    if (is_string($raw)) {
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            echo "      ✅ Valid JSON\n";
            echo "      Decoded count: " . (is_array($decoded) ? count($decoded) : '0') . "\n";
        } else {
            echo "      ❌ Invalid JSON: " . json_last_error_msg() . "\n";
        }
    } else {
        echo "      ⚠️ Not a string, type: " . gettype($raw) . "\n";
    }
    
    echo "\n" . str_repeat("=", 50) . "\n\n";
}

echo "✅ Debug complete!\n";
