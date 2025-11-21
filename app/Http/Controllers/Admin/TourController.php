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

        // Get statistics
        $totalBookings = 0;
        $totalRevenue = 0;
        $featuredCount = 0;
        
        // Check if Booking model exists
        if (class_exists(\App\Models\Booking::class)) {
            $totalBookings = \App\Models\Booking::count();
            $totalRevenue = \App\Models\Booking::where('payment_status', 'paid')
                ->sum('total_price');
        }
        
        $featuredCount = Tour::where('featured', true)->count();

        return view('admin.tours.index', compact('tours', 'userMarket', 'userCountry', 'userCurrency', 'totalBookings', 'totalRevenue', 'featuredCount'));
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
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'nullable|image|max:4096',
            'itinerary' => 'nullable|string',
            'includes' => 'nullable|string',
            'excludes' => 'nullable|string',
            'featured' => 'nullable|boolean',
        ]);

        // Set price_usd from price field
        $data['price_usd'] = $data['price'];
        unset($data['price']);

        // Set default values
        $data['featured'] = $request->has('featured') ? true : false;
        $data['status'] = 'active';
        $data['target_market'] = 'both';
        $data['exchange_rate_idr'] = 15000;
        $data['exchange_rate_cny'] = 6.5;

        // Convert text to array for itinerary, includes, excludes
        if (!empty($data['itinerary'])) {
            $data['itinerary'] = json_encode(array_filter(explode("\n", $data['itinerary'])));
        }
        if (!empty($data['includes'])) {
            $data['includes'] = json_encode(array_filter(explode("\n", $data['includes'])));
        }
        if (!empty($data['excludes'])) {
            $data['excludes'] = json_encode(array_filter(explode("\n", $data['excludes'])));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour = Tour::create($data);

        // Auto-convert prices
        $tour->autoConvertPrices();
        $tour->save();

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($data['image'])) {
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
            'duration' => 'required|integer|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'itinerary' => 'nullable|string',
            'includes' => 'nullable|string',
            'excludes' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|string|in:active,inactive',
            'target_market' => 'nullable|string|in:domestic,international,both',
            'price_usd' => 'required|numeric|min:0',
            'price_idr' => 'nullable|numeric|min:0',
            'price_cny' => 'nullable|numeric|min:0',
            'exchange_rate_idr' => 'nullable|numeric|min:0',
            'exchange_rate_cny' => 'nullable|numeric|min:0',
        ]);

        // Set values
        $data['featured'] = $request->has('featured') ? true : false;
        $data['status'] = $request->input('status', 'active');
        $data['target_market'] = $request->input('target_market', 'both');
        
        // Keep existing exchange rates if not provided
        if (!isset($data['exchange_rate_idr'])) {
            $data['exchange_rate_idr'] = $tour->exchange_rate_idr ?? 15000;
        }
        if (!isset($data['exchange_rate_cny'])) {
            $data['exchange_rate_cny'] = $tour->exchange_rate_cny ?? 6.5;
        }

        // JSON fields - keep as string (already JSON from form)
        // Just validate they're valid JSON if provided
        if (!empty($data['itinerary'])) {
            $decoded = json_decode($data['itinerary']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['itinerary' => 'Invalid JSON format for itinerary'])->withInput();
            }
        }
        if (!empty($data['includes'])) {
            $decoded = json_decode($data['includes']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['includes' => 'Invalid JSON format for includes'])->withInput();
            }
        }
        if (!empty($data['excludes'])) {
            $decoded = json_decode($data['excludes']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['excludes' => 'Invalid JSON format for excludes'])->withInput();
            }
        }

        // Handle image upload BEFORE updating other data
        if ($request->hasFile('image')) {
            // Delete old image and derivatives if they exist
            if ($tour->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($tour->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($tour->image);
            }
            
            // Store new image
            $imagePath = $request->file('image')->store('tours', 'public');
            $data['image'] = $imagePath;
            
            \Log::info('Tour image uploaded', [
                'tour_id' => $tour->id,
                'image_path' => $imagePath,
                'original_name' => $request->file('image')->getClientOriginalName()
            ]);
        }

        // Update tour with all data including image
        $tour->update($data);

        // Auto-convert prices if price_usd was updated
        if (isset($data['price_usd'])) {
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
        
        return redirect()->route('admin.tours.edit', $tour)
            ->with('success', 'Tour updated successfully. Image: ' . ($request->hasFile('image') ? 'Updated' : 'Not changed'));
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