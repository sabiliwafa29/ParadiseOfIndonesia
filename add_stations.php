<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pickup;

$stations = [
    [
        'name' => 'Stasiun Gambir Jakarta',
        'description' => 'Main train station in Jakarta for intercity and international trains',
        'latitude' => -6.1767,
        'longitude' => 106.8307,
    ],
    [
        'name' => 'Stasiun Pasar Senen Jakarta',
        'description' => 'Major train station in Jakarta for economy class trains',
        'latitude' => -6.1764,
        'longitude' => 106.8456,
    ],
    [
        'name' => 'Stasiun Bandung',
        'description' => 'Main train station in Bandung, West Java',
        'latitude' => -6.9175,
        'longitude' => 107.6191,
    ],
    [
        'name' => 'Stasiun Yogyakarta (Tugu)',
        'description' => 'Main train station in Yogyakarta, Central Java',
        'latitude' => -7.7896,
        'longitude' => 110.3636,
    ],
    [
        'name' => 'Stasiun Semarang Tawang',
        'description' => 'Main train station in Semarang, Central Java',
        'latitude' => -6.9667,
        'longitude' => 110.4222,
    ],
    [
        'name' => 'Stasiun Surabaya Gubeng',
        'description' => 'Main train station in Surabaya, East Java',
        'latitude' => -7.2653,
        'longitude' => 112.7508,
    ],
    [
        'name' => 'Stasiun Surabaya Pasar Turi',
        'description' => 'Secondary train station in Surabaya',
        'latitude' => -7.2489,
        'longitude' => 112.7344,
    ],
    [
        'name' => 'Stasiun Malang',
        'description' => 'Main train station in Malang, East Java',
        'latitude' => -7.9778,
        'longitude' => 112.6333,
    ],
    [
        'name' => 'Stasiun Solo Balapan',
        'description' => 'Main train station in Surakarta (Solo), Central Java',
        'latitude' => -7.5561,
        'longitude' => 110.8222,
    ],
    [
        'name' => 'Stasiun Cirebon',
        'description' => 'Main train station in Cirebon, West Java',
        'latitude' => -6.7167,
        'longitude' => 108.5500,
    ],
    [
        'name' => 'Stasiun Medan',
        'description' => 'Main train station in Medan, North Sumatra',
        'latitude' => 3.5952,
        'longitude' => 98.6722,
    ],
    [
        'name' => 'Stasiun Palembang',
        'description' => 'Main train station in Palembang, South Sumatra',
        'latitude' => -2.9833,
        'longitude' => 104.7667,
    ],
];

$added = 0;
foreach ($stations as $station) {
    try {
        Pickup::create($station);
        $added++;
        echo "Added: {$station['name']}\n";
    } catch (\Exception $e) {
        echo "Error adding {$station['name']}: {$e->getMessage()}\n";
    }
}

echo "\nTotal stations added: $added\n";
echo "Total pickups now: " . Pickup::count() . "\n";
