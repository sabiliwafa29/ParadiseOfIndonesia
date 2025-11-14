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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $locale = app()->getLocale(); // 'id', 'en', atau 'zh'
        $nameColumn = 'name_' . $locale;

        $query = TourPackage::query();

        if ($search) {
            $query->where($nameColumn, 'ILIKE', '%' . $search . '%'); 
        }

        $packages = $query->paginate(9);

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
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $package = TourPackage::create($validated);

        if (!empty($validated['tours'])) {
            $package->tours()->sync($validated['tours']);
        }

        return redirect()->route('tour-packages.index')
            ->with('success', 'Tour package created successfully');
    }

    /**
     * Display the specified tour package.
     */
    public function show(TourPackage $tourPackage)
    {
        $tourPackage->load('tours.destination');
        return view('tour-packages.show', compact('tourPackage'));
    }

    /**
     * Show the form for editing the specified tour package.
     */
    public function edit(TourPackage $tourPackage)
    {
        $tours = Tour::all();
        return view('tour-packages.edit', compact('tourPackage', 'tours'));
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
        ]);

        if ($request->hasFile('image')) {
            if ($tourPackage->image && Storage::disk('public')->exists($tourPackage->image)) {
                Storage::disk('public')->delete($tourPackage->image);
            }
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $tourPackage->update($validated);

        $tourPackage->tours()->sync($validated['tours'] ?? []);

        return redirect()->route('tour-packages.show', $tourPackage)
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

        return redirect()->route('tour-packages.index')
            ->with('success', 'Tour package deleted successfully');
    }
}
