<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;

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
        return view('tour-packages.create');
    }

    /**
     * Store a newly created tour package in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'includes_guide' => 'boolean',
            'includes_transport' => 'boolean',
        ]);

        $package = new TourPackage($validated);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        TourPackage::create($validated);

        return redirect()->route('tour-packages.index')
            ->with('success', 'Tour package created successfully');
    }

    /**
     * Display the specified tour package.
     */
    public function show(TourPackage $package)
    {
        $package->load('tours.destination');
        return view('tour-packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified tour package.
     */
    public function edit(TourPackage $package)
    {
        return view('tour-packages.edit', compact('package'));
    }

    /**
     * Update the specified tour package in storage.
     */
    public function update(Request $request, TourPackage $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'includes_guide' => 'boolean',
            'includes_transport' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && file_exists(storage_path('app/public/' . $package->image))) {
                unlink(storage_path('app/public/' . $package->image));
            }
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $package->update($validated);

        return redirect()->route('tour-packages.show', $package)
            ->with('success', 'Tour package updated successfully');
    }

    /**
     * Remove the specified tour package from storage.
     */
    public function destroy(TourPackage $package)
    {
        // Delete image if exists
        if ($package->image && file_exists(storage_path('app/public/' . $package->image))) {
            unlink(storage_path('app/public/' . $package->image));
        }

        $package->delete();

        return redirect()->route('tour-packages.index')
            ->with('success', 'Tour package deleted successfully');
    }
}