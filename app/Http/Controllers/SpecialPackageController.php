<?php

namespace App\Http\Controllers;

use App\Models\SpecialLink;
use App\Models\TourPackage;
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

        return view('tour-packages.show', [
            'package' => $package,
            'specialPrices' => $specialPrices,
            'specialLink' => $link,
        ]);
    }
}
