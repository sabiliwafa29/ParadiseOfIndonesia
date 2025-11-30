<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessImageDerivatives;
use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\Tour;
use App\Helpers\ItineraryHelper;

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
                'price_idr' => 'nullable|numeric|min:0',
                'price_usd' => 'nullable|numeric|min:0',
                'price_cny' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'itinerary' => 'nullable|array',
            'itinerary.*.title_id' => 'required|string',
            'itinerary.*.title_en' => 'required|string',
            'itinerary.*.title_zh' => 'required|string',
            'itinerary.*.description_id' => 'required|string',
            'itinerary.*.description_en' => 'required|string',
            'itinerary.*.description_zh' => 'required|string',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
            'min_guests' => 'nullable|integer|min:1',
        ]);

        // Require at least one price field
        if (empty($request->input('price_idr')) && empty($request->input('price_usd')) && empty($request->input('price_cny'))) {
            return back()->withErrors(['price_usd' => 'Please provide at least one price (IDR, USD or CNY)'])->withInput();
        }

        // Handle checkbox
        $validated['includes_guide'] = $request->has('includes_guide');
        $validated['includes_transport'] = $request->has('includes_transport');

        // Default min_guests
        $validated['min_guests'] = (int) $request->input('min_guests', 1);

        // Handle image upload
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

        // Validate itinerary structure
        if ($request->has('itinerary')) {
            $itinerary = $request->input('itinerary');
            $errors = ItineraryHelper::validate($itinerary);
            
            if (!empty($errors)) {
                return back()
                    ->withErrors(['itinerary' => 'Itinerary validation failed: ' . implode(', ', $errors)])
                    ->withInput();
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
                'price_idr' => 'nullable|numeric|min:0',
                'price_usd' => 'nullable|numeric|min:0',
                'price_cny' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'itinerary' => 'nullable|array',
            'itinerary.*.title_id' => 'required|string',
            'itinerary.*.title_en' => 'required|string',
            'itinerary.*.title_zh' => 'required|string',
            'itinerary.*.description_id' => 'required|string',
            'itinerary.*.description_en' => 'required|string',
            'itinerary.*.description_zh' => 'required|string',
            'tours' => 'nullable|array',
            'tours.*' => 'exists:tours,id',
            'min_guests' => 'nullable|integer|min:1',
        ]);

        // Handle checkbox yang tidak dicentang (tidak ada di request)
        $validated['includes_guide'] = $request->has('includes_guide');
        $validated['includes_transport'] = $request->has('includes_transport');

        // Default min_guests when updating
        $validated['min_guests'] = (int) $request->input('min_guests', $tourPackage->min_guests ?? 1);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($tourPackage->image && \Storage::disk('public')->exists($tourPackage->image)) {
                \Storage::disk('public')->delete($tourPackage->image);
            }
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        // Update tour package
        $tourPackage->update($validated);

        // Sync tours
        $tourPackage->tours()->sync($validated['tours'] ?? []);

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $tourPackage);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $tourPackage);
            }
        }

        // Require at least one price field
        if (empty($validated['price_idr']) && empty($validated['price_usd']) && empty($validated['price_cny'])) {
            return back()->withErrors(['price_usd' => 'Please provide at least one price (IDR, USD or CNY)'])->withInput();
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
