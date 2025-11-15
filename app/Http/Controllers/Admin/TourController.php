<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessImageDerivatives;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Destination;
use App\Services\LocationService;

class TourController extends Controller
{
    /**
     * Display a listing of tours.
     */
    public function index()
    {
        try {
            $userMarket = LocationService::getUserMarket();
            $userCountry = LocationService::detectCountry();
            $userCurrency = LocationService::getUserCurrency();
        } catch (\Exception $e) {
            \Log::warning("LocationService failed: " . $e->getMessage());
            $userMarket = 'both';
            $userCountry = 'US';
            $userCurrency = 'USD';
        }
        $tours = Tour::forMarket($userMarket)
            ->active()
            ->latest()
            ->paginate(15);

        return view('admin.tours.index', compact('tours', 'userMarket', 'userCountry', 'userCurrency'));
    }

    /**
     * Show the form for creating a new tour.
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('admin.tours.create', compact('destinations'));
    }

    /**
     * Store a newly created tour in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_zh' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tours,slug',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'description_zh' => 'required|string',
            'price_usd' => 'required|numeric|min:0',
            'price_idr' => 'nullable|numeric|min:0',
            'price_cny' => 'nullable|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'nullable|image|max:4096',
            'itinerary' => 'nullable|json',
            'includes' => 'nullable|json',
            'excludes' => 'nullable|json',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|in:active,inactive',
            'target_market' => 'required|in:domestic,international,both',
            'exchange_rate_idr' => 'nullable|numeric|min:0',
            'exchange_rate_cny' => 'nullable|numeric|min:0',
        ]);

        $data['featured'] = $request->has('featured') ? true : false;
        $data['status'] = $data['status'] ?? 'active';
        $data['exchange_rate_idr'] = $data['exchange_rate_idr'] ?? 15000;
        $data['exchange_rate_cny'] = $data['exchange_rate_cny'] ?? 6.5;

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour = Tour::create($data);

        // Auto-convert if only USD is provided
        if ($tour->price_usd && (!$tour->price_idr || !$tour->price_cny)) {
            $tour->autoConvertPrices();
            $tour->save();
        }

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && $data['image']) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($data['image'], 'public', $tour);
            } else {
                ProcessImageDerivatives::dispatch($data['image'], 'public', $tour);
            }
        }
        
        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully.');
    }

    /**
     * Show the form for editing the specified tour.
     */
    public function edit(Tour $tour)
    {
        $destinations = Destination::all();
        
        // Decode JSON data for editing
        $tour->itinerary_decoded = is_string($tour->itinerary) ? json_decode($tour->itinerary, true) : $tour->itinerary;
        $tour->includes_decoded = is_string($tour->includes) ? json_decode($tour->includes, true) : $tour->includes;
        $tour->excludes_decoded = is_string($tour->excludes) ? json_decode($tour->excludes, true) : $tour->excludes;
        
        return view('admin.tours.edit', compact('tour', 'destinations'));
    }

    /**
     * Update the specified tour in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        $data = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_zh' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tours,slug,' . $tour->id,
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'description_zh' => 'required|string',
            'price_usd' => 'required|numeric|min:0',
            'price_idr' => 'nullable|numeric|min:0',
            'price_cny' => 'nullable|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'nullable|image|max:4096',
            'itinerary' => 'nullable|json',
            'includes' => 'nullable|json',
            'excludes' => 'nullable|json',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|in:active,inactive',
            'target_market' => 'required|in:domestic,international,both',
            'exchange_rate_idr' => 'nullable|numeric|min:0',
            'exchange_rate_cny' => 'nullable|numeric|min:0',
        ]);

        $data['featured'] = $request->has('featured') ? true : false;
        $data['status'] = $data['status'] ?? 'active';
        $data['exchange_rate_idr'] = $data['exchange_rate_idr'] ?? 15000;
        $data['exchange_rate_cny'] = $data['exchange_rate_cny'] ?? 6.5;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image and derivatives if they exist
            if ($tour->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($tour->image);
            }
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour->update($data);

        // Auto-convert if USD changed
        if ($request->has('price_usd') && $request->input('auto_convert') === '1') {
            $tour->autoConvertPrices();
            $tour->save();
        }

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($data['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($data['image'], 'public', $tour);
            } else {
                ProcessImageDerivatives::dispatch($data['image'], 'public', $tour);
            }
        }
        
        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully.');
    }

    /**
     * Remove the specified tour from storage.
     */
    public function destroy(Tour $tour)
    {
        $tour->delete();
        
        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully.');
    }

    /**
     * Show tour details
     */
    public function show(Tour $tour)
    {
        $tour->load('destination');
        return view('admin.tours.show', compact('tour'));
    }
}