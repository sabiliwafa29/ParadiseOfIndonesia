<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\Tour;

class TourPackageController extends Controller
{
    public function index()
    {
        $packages = TourPackage::paginate(10);
        return view('admin.tour-packages.index', compact('packages'));
    }

    public function create()
    {
        $tours = Tour::all();
        return view('admin.tour-packages.create', compact('tours'));
    }

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
            'image' => 'nullable|image|max:2048',
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

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Tour package created successfully');
    }

    public function edit(TourPackage $tourPackage)
    {
        $tours = Tour::all();
        return view('admin.tour-packages.edit', compact('tourPackage', 'tours'));
    }

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
            'image' => 'nullable|image|max:2048',
            'includes_guide' => 'boolean',
            'includes_transport' => 'boolean',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
        ]);

        if ($request->hasFile('image')) {
            if ($tourPackage->image && \Storage::disk('public')->exists($tourPackage->image)) {
                \Storage::disk('public')->delete($tourPackage->image);
            }
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $tourPackage->update($validated);

        $tourPackage->tours()->sync($validated['tours'] ?? []);

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Tour package updated successfully');
    }

    public function destroy(TourPackage $tourPackage)
    {
        if ($tourPackage->image && \Storage::disk('public')->exists($tourPackage->image)) {
            \Storage::disk('public')->delete($tourPackage->image);
        }

        $tourPackage->tours()->detach();
        $tourPackage->delete();

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Tour package deleted successfully');
    }
}
