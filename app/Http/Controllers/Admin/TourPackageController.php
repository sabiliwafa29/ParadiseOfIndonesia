<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessImageDerivatives;
use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\Tour;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $locale = app()->getLocale(); // 'id', 'en', atau 'zh'
        $nameColumn = 'name_' . $locale;

        $query = TourPackage::query();

        if ($search) {
            $query->where($nameColumn, 'ILIKE', '%' . $search . '%'); 
        }

        $packages = $query->paginate(10);

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
            'itinerary' => 'nullable|array',
            'itinerary.*.title_id' => 'required|string',
            'itinerary.*.title_en' => 'required|string',
            'itinerary.*.title_zh' => 'required|string',
            'itinerary.*.description_id' => 'required|string',
            'itinerary.*.description_en' => 'required|string',
            'itinerary.*.description_zh' => 'required|string',
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

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $package);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $package);
            }
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
            'itinerary' => 'nullable|array',
            'itinerary.*.title_id' => 'required|string',
            'itinerary.*.title_en' => 'required|string',
            'itinerary.*.title_zh' => 'required|string',
            'itinerary.*.description_id' => 'required|string',
            'itinerary.*.description_en' => 'required|string',
            'itinerary.*.description_zh' => 'required|string',
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

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $tourPackage);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $tourPackage);
            }
        }

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
