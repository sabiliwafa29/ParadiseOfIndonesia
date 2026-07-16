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
            $term = mb_strtolower($query);
            $match = function ($q) use ($term) {
                $cols = [
                    'name_id', 'name_en', 'name_zh',
                    'description_id', 'description_en', 'description_zh',
                ];
                foreach ($cols as $i => $col) {
                    $clause = 'LOWER(' . $col . ') LIKE ?';
                    $bind = ['%' . $term . '%'];
                    if ($i === 0) {
                        $q->whereRaw($clause, $bind);
                    } else {
                        $q->orWhereRaw($clause, $bind);
                    }
                }
                return $q;
            };

            $tours = Tour::forMarket($userMarket)
                ->where('status', 'active')
                ->where($match)
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $packages = TourPackage::where($match)
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $destinations = Destination::where($match)
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        return view('search.index', compact('query', 'tours', 'packages', 'destinations'));
    }
}
