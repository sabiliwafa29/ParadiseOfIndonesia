<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Destination;
use App\Services\LocationService;


class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userMarket = LocationService::getUserMarket();
        
        $tours = Tour::forMarket($userMarket)
            ->where('status', 'active')
            ->latest()
            ->paginate(15);

        return view('tours.index', compact('tours', 'userMarket'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        // Check if tour is available for this user
        if (!$tour->isAvailableForUser()) {
            abort(403, 'This tour is not available in your region.');
        }

        $tour->load('destination');
        return view('tours.show', compact('tour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
