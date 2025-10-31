<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourPackage; // Add this line
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('featured', true)->take(6)->get();
        $tours = Tour::where('featured', true)->with('destination')->take(6)->get();
        $tourPackages = TourPackage::with('tours')->take(3)->get(); // Fetch 3 tour packages and eager load their tours

        return view('home', compact('destinations', 'tours', 'tourPackages'));
    }
}
