<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessImageDerivatives;
use App\Models\TravelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TravelServiceController extends Controller
{
    protected array $defaultTypes = [
        'Transport',
        'Accommodation',
        'Guide',
        'Document',
        'Insurance',
        'Event',
        'Package',
        'Custom',
    ];

    public function index(Request $request)
    {
        $search = $request->input('search');
        $currentType = $request->input('type');

        $query = TravelService::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($currentType && $currentType !== 'all') {
            $query->where('type', $currentType);
        }

        $services = $query->latest()->paginate(12)->withQueryString();

        $totalServices = TravelService::count();
        $typesInDb = TravelService::whereNotNull('type')->where('type', '!=', '')->distinct()->pluck('type')->toArray();
        $types = array_values(array_unique(array_merge($this->defaultTypes, $typesInDb)));
        $totalTypes = count($typesInDb);
        $avgPrice = TravelService::avg('price') ?? 0;

        return view('admin.travel-services.index', compact(
            'services',
            'totalServices',
            'totalTypes',
            'avgPrice',
            'types',
            'currentType',
            'search'
        ));
    }

    public function create()
    {
        $typesInDb = TravelService::whereNotNull('type')->where('type', '!=', '')->distinct()->pluck('type')->toArray();
        $suggestedTypes = array_values(array_unique(array_merge($this->defaultTypes, $typesInDb)));

        return view('admin.travel-services.create', compact('suggestedTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('travel-services', 'public');
        }

        $service = TravelService::create($validated);

        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $service);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $service);
            }
        }

        return redirect()->route('admin.travel-services.index')->with('success', 'Travel service created successfully!');
    }

    public function show(TravelService $travel_service)
    {
        return redirect()->route('admin.travel-services.edit', $travel_service);
    }

    public function edit(TravelService $travel_service)
    {
        $service = $travel_service;
        $typesInDb = TravelService::whereNotNull('type')->where('type', '!=', '')->distinct()->pluck('type')->toArray();
        $suggestedTypes = array_values(array_unique(array_merge($this->defaultTypes, $typesInDb)));

        return view('admin.travel-services.edit', compact('service', 'suggestedTypes'));
    }

    public function update(Request $request, TravelService $travel_service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Delete old stored image and derivatives if present in public disk
            if ($travel_service->image && Storage::disk('public')->exists($travel_service->image)) {
                Storage::disk('public')->delete($travel_service->image);

                if ($travel_service->image_derivatives && is_array($travel_service->image_derivatives)) {
                    foreach ($travel_service->image_derivatives as $derivativePath) {
                        if (Storage::disk('public')->exists($derivativePath)) {
                            Storage::disk('public')->delete($derivativePath);
                        }
                    }
                }
            }

            $validated['image'] = $request->file('image')->store('travel-services', 'public');
            $validated['image_derivatives'] = null;
        }

        $travel_service->update($validated);

        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $travel_service);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $travel_service);
            }
        }

        return redirect()->route('admin.travel-services.index')->with('success', 'Travel service updated successfully!');
    }

    public function destroy(TravelService $travel_service)
    {
        if ($travel_service->image && Storage::disk('public')->exists($travel_service->image)) {
            Storage::disk('public')->delete($travel_service->image);

            if ($travel_service->image_derivatives && is_array($travel_service->image_derivatives)) {
                foreach ($travel_service->image_derivatives as $derivativePath) {
                    if (Storage::disk('public')->exists($derivativePath)) {
                        Storage::disk('public')->delete($derivativePath);
                    }
                }
            }
        }

        $travel_service->delete();

        return redirect()->route('admin.travel-services.index')->with('success', 'Travel service deleted successfully!');
    }
}
