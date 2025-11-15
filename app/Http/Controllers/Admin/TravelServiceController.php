<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessImageDerivatives;
use Illuminate\Http\Request;
use App\Models\TravelService;

class TravelServiceController extends Controller
{
    public function index()
    {
        $services = TravelService::latest()->paginate(20);
        return view('admin.travel-services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.travel-services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('travel-services', 'public');
        }

        $service = TravelService::create($validated);

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $service);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $service);
            }
        }

        return redirect()->route('admin.travel-services.index')->with('success', 'Service created');
    }

    public function edit(TravelService $service)
    {
        return view('admin.travel-services.edit', compact('service'));
    }

    public function update(Request $request, TravelService $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image && \Storage::disk('public')->exists($service->image)) {
                \Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('travel-services', 'public');
        }

        $service->update($validated);

        // Dispatch derivative processing job if image was uploaded
        if ($request->hasFile('image') && isset($validated['image'])) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $service);
            } else {
                ProcessImageDerivatives::dispatch($validated['image'], 'public', $service);
            }
        }

        return redirect()->route('admin.travel-services.index')->with('success', 'Service updated');
    }

    public function destroy(TravelService $service)
    {
        $service->delete();
        return redirect()->route('admin.travel-services.index')->with('success', 'Service deleted');
    }
}
