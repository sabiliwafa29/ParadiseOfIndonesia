<?php

namespace App\Http\Controllers;

use App\Models\SpecialLink;
use App\Models\TourPackage;
use App\Services\LocationService;
use Illuminate\Http\Request;

class SpecialPackageController extends Controller
{
    public function show(Request $request, $token)
    {
        $link = SpecialLink::where('token', $token)->firstOrFail();

        if (!$link->isValid()) {
            abort(404);
        }

        $package = $link->package()->with('tours.destination')->firstOrFail();

        $specialPrices = [
            'idr' => $link->price_special_idr,
            'usd' => $link->price_special_usd,
            'cny' => $link->price_special_cny,
        ];

        // Detect user's currency from geolocation (IP / session)
        $userCurrency = LocationService::getUserCurrency(); // returns 'IDR', 'CNY', or 'USD'

        // Map to our keys
        $currencyKey = match($userCurrency) {
            'IDR' => 'idr',
            'CNY' => 'cny',
            default => 'usd',
        };

        $selectedSpecialPrice = $specialPrices[$currencyKey] ?? null;

        return view('tour-packages.show', [
            'package' => $package,
            'specialPrices' => $specialPrices,
            'specialPrice' => $selectedSpecialPrice,
            'detectedCurrency' => $userCurrency,
            'specialLink' => $link,
        ]);
    }
}
