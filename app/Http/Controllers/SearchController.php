<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourPackage;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Services\LocationService;

class SearchController extends Controller
{
    /**
     * Display search results across tours, packages and destinations.
     */
    public function index(Request $request)
    {
        $query = trim((string) $request->input('query', ''));
        $userMarket = LocationService::getUserMarket();

        $tours = collect();
        $packages = collect();
        $destinations = collect();

        if ($query !== '') {
            $like = '%' . $query . '%';

            $tours = Tour::forMarket($userMarket)
                ->where('status', 'active')
                ->where(function ($q) use ($like) {
                    $q->where('name_id', 'like', $like)
                        ->orWhere('name_en', 'like', $like)
                        ->orWhere('name_zh', 'like', $like)
                        ->orWhere('description_id', 'like', $like)
                        ->orWhere('description_en', 'like', $like)
                        ->orWhere('description_zh', 'like', $like);
                })
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $packages = TourPackage::where(function ($q) use ($like) {
                    $q->where('name_id', 'like', $like)
                        ->orWhere('name_en', 'like', $like)
                        ->orWhere('name_zh', 'like', $like)
                        ->orWhere('description_id', 'like', $like)
                        ->orWhere('description_en', 'like', $like)
                        ->orWhere('description_zh', 'like', $like);
                })
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $destinations = Destination::where(function ($q) use ($like) {
                    $q->where('name_id', 'like', $like)
                        ->orWhere('name_en', 'like', $like)
                        ->orWhere('name_zh', 'like', $like)
                        ->orWhere('description_id', 'like', $like)
                        ->orWhere('description_en', 'like', $like)
                        ->orWhere('description_zh', 'like', $like);
                })
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        return view('search.index', compact('query', 'tours', 'packages', 'destinations'));
    }
}
