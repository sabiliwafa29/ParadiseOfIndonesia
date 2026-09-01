<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourPackage;
use App\Services\LocationService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('query', ''));
        $userMarket = LocationService::getUserMarket();

        $tours = collect();
        $packages = collect();
        $destinations = collect();

        if ($query !== '') {
            $term = mb_strtolower($query);
            $tours = Tour::forMarket($userMarket)
                ->where('status', 'active')
                ->where(function ($q) use ($term) {
                    $this->applySearchToColumns($q, $term, ['name_id', 'name_en', 'name_zh', 'description_id', 'description_en', 'description_zh']);
                })
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $packages = TourPackage::where(function ($q) use ($term) {
                $this->applySearchToColumns($q, $term, ['name_id', 'name_en', 'name_zh', 'description_id', 'description_en', 'description_zh']);
            })
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $destinations = Destination::where(function ($q) use ($term) {
                $this->applySearchToColumns($q, $term, ['name_id', 'name_en', 'name_zh', 'description_id', 'description_en', 'description_zh']);
            })
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        return view('search.index', compact('query', 'tours', 'packages', 'destinations'));
    }

    protected function applySearchToColumns($query, string $term, array $columns): void
    {
        foreach ($columns as $i => $col) {
            $clause = 'LOWER(' . $col . ') LIKE ?';
            $bind = ['%' . $term . '%'];

            if ($i === 0) {
                $query->whereRaw($clause, $bind);
            } else {
                $query->orWhereRaw($clause, $bind);
            }
        }
    }
}