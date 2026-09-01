<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Services\LocationService;

class TourController extends Controller
{
    public function index()
    {
        $userMarket = LocationService::getUserMarket();
        $tours = Tour::forMarket($userMarket)
            ->where('status', 'active')
            ->latest()
            ->paginate(15);

        return view('tours.index', compact('tours', 'userMarket'));
    }

    public function show(Tour $tour)
    {
        if (!$tour->isAvailableForUser()) {
            return redirect()->intended(route('tours.index'))
                ->with('error', 'This tour is not available in your region.');
        }

        $tour->load('destination');
        return view('tours.show', compact('tour'));
    }
}