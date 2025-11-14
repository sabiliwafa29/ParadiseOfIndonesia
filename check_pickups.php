<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pickup;

echo "Total pickups: " . Pickup::count() . PHP_EOL;

$stations = Pickup::where('name', 'ILIKE', '%stasiun%')
    ->orWhere('name', 'ILIKE', '%station%')
    ->orWhere('description', 'ILIKE', '%stasiun%')
    ->orWhere('description', 'ILIKE', '%station%')
    ->get(['name', 'description']);

echo "Stations found: " . $stations->count() . PHP_EOL;

foreach ($stations as $station) {
    echo "- " . $station->name . " - " . $station->description . PHP_EOL;
}

echo PHP_EOL . "All pickups:" . PHP_EOL;
$all = Pickup::all(['name', 'description']);
foreach ($all as $pickup) {
    echo "- " . $pickup->name . " - " . $pickup->description . PHP_EOL;
}
