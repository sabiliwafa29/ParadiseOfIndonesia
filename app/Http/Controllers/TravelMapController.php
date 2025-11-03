<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\PickoffDestination;

class TravelMapController extends Controller
{
    public function index()
    {
        $pickups = Pickup::all();
        $pickoffdestinations = PickoffDestination::all();

        return view('travel-services.map', compact('pickups', 'pickoffdestinations'));
    }
}
