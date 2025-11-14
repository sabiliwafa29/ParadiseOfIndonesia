<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::paginate(10);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_zh' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:destinations,slug',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'description_zh' => 'required|string',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        Destination::create($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully');
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_zh' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:destinations,slug,' . $destination->id,
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'description_zh' => 'required|string',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($destination->image && \Storage::disk('public')->exists($destination->image)) {
                \Storage::disk('public')->delete($destination->image);
            }
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        $destination->update($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination updated successfully');
    }

    public function destroy(Destination $destination)
    {
        if ($destination->image && \Storage::disk('public')->exists($destination->image)) {
            \Storage::disk('public')->delete($destination->image);
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully');
    }
}
