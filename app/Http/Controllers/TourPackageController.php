<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the tour packages.
     */
    public function index()
    {
        $packages = TourPackage::paginate(9);
        return view('tour-packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new tour package.
     */
    public function create()
    {
        $tours = Tour::all();
        return view('tour-packages.create', compact('tours'));
    }

    /**
     * Store a newly created tour package in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_zh' => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'description_zh' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'includes_guide' => 'boolean',
            'includes_transport' => 'boolean',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
            'itinerary' => 'nullable|array',
            'itinerary.*.title_id' => 'required_with:itinerary|string|max:255',
            'itinerary.*.title_en' => 'required_with:itinerary|string|max:255',
            'itinerary.*.title_zh' => 'required_with:itinerary|string|max:255',
            'itinerary.*.description_id' => 'required_with:itinerary|string',
            'itinerary.*.description_en' => 'required_with:itinerary|string',
            'itinerary.*.description_zh' => 'required_with:itinerary|string',
        ]);

        // Handle checkbox (jika tidak dicentang, tidak akan ada di request)
        $validated['includes_guide'] = $request->has('includes_guide') ? 1 : 0;
        $validated['includes_transport'] = $request->has('includes_transport') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        // Reset array index (0, 1, 2...) - Laravel akan otomatis convert ke JSON
        if (isset($validated['itinerary'])) {
            $validated['itinerary'] = array_values($validated['itinerary']);
        }

        $package = TourPackage::create($validated);

        if (!empty($validated['tours'])) {
            $package->tours()->sync($validated['tours']);
        }

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Tour package created successfully');
    }

    /**
     * Display the specified tour package.
     */
    public function show(TourPackage $tourPackage)
    {
        $tourPackage->load('tours.destination');
        return view('admin.tour-packages.show', compact('tourPackage'));
    }

    /**
     * Show the form for editing the specified tour package.
     */
    public function edit(TourPackage $tourPackage)
    {
        $tours = Tour::all();
        
        // Tidak perlu decode manual karena sudah ada cast 'json' di model
        // Laravel otomatis mengubah JSON string menjadi array
        
        return view('admin.tour-packages.edit', compact('tourPackage', 'tours'));
    }

    /**
     * Update the specified tour package in storage.
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_zh' => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'description_zh' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'includes_guide' => 'boolean',
            'includes_transport' => 'boolean',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
            'itinerary' => 'nullable|array',
            'itinerary.*.title_id' => 'required_with:itinerary|string|max:255',
            'itinerary.*.title_en' => 'required_with:itinerary|string|max:255',
            'itinerary.*.title_zh' => 'required_with:itinerary|string|max:255',
            'itinerary.*.description_id' => 'required_with:itinerary|string',
            'itinerary.*.description_en' => 'required_with:itinerary|string',
            'itinerary.*.description_zh' => 'required_with:itinerary|string',
        ]);

        // Handle checkbox
        $validated['includes_guide'] = $request->has('includes_guide') ? 1 : 0;
        $validated['includes_transport'] = $request->has('includes_transport') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($tourPackage->image && Storage::disk('public')->exists($tourPackage->image)) {
                Storage::disk('public')->delete($tourPackage->image);
            }
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        // Reset array index - Laravel otomatis convert ke JSON
        if (isset($validated['itinerary'])) {
            $validated['itinerary'] = array_values($validated['itinerary']);
        }

        $tourPackage->update($validated);

        $tourPackage->tours()->sync($validated['tours'] ?? []);

        return redirect()->route('admin.tour-packages.show', $tourPackage)
            ->with('success', 'Tour package updated successfully');
    }

    /**
     * Remove the specified tour package from storage.
     */
    public function destroy(TourPackage $tourPackage)
    {
        if ($tourPackage->image && Storage::disk('public')->exists($tourPackage->image)) {
            Storage::disk('public')->delete($tourPackage->image);
        }

        $tourPackage->tours()->detach();
        $tourPackage->delete();

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Tour package deleted successfully');
    }
}