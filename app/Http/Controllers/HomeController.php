<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourPackage; 
use App\Models\TourActivity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('featured', true)->take(6)->get();
        $tours = Tour::where('featured', true)
            ->where('status', 'active')
            ->with('destination')
            ->take(6)
            ->get();
        $tourPackages = TourPackage::with('tours')->take(3)->get(); // Fetch 3 tour packages and eager load their tours
        $tourActivities = TourActivity::latest()->take(3)->get(); // Fetch 6 latest tour activities

        return view('home', compact('destinations', 'tours', 'tourPackages', 'tourActivities'));
    }
}
