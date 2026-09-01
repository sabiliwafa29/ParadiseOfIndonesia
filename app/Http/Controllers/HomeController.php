<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourActivity;
use App\Models\TourPackage;
use App\Models\TravelService;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('featured', true)->take(6)->get();
        $travelServices = TravelService::latest()->take(6)->get();
        $tours = Tour::where('featured', true)
            ->where('status', 'active')
            ->with('destination')
            ->take(6)
            ->get();
        $tourPackages = TourPackage::with('tours')->latest()->take(3)->get();
        $tourActivities = TourActivity::latest()->take(3)->get();

        return view('home', compact('destinations', 'travelServices', 'tours', 'tourPackages', 'tourActivities'));
    }
}