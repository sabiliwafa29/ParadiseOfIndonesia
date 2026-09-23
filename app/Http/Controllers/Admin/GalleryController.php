<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessImageDerivatives;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('destination')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        $galleries = $query->paginate(20)->withQueryString();
        $totalImages = Gallery::count();
        $destinations = Destination::orderBy('name_en')->get();

        return view('admin.gallery.index', compact('galleries', 'totalImages', 'destinations'));
    }

    public function create()
    {
        $destinations = Destination::orderBy('name_en')->get();
        return view('admin.gallery.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination_id' => 'nullable|exists:destinations,id',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
        ]);

        $storedPath = null;
        if ($request->hasFile('image')) {
            $storedPath = $request->file('image')->store('gallery', 'public');
        }

        $gallery = Gallery::create([
            'destination_id' => !empty($validated['destination_id']) ? $validated['destination_id'] : null,
            'name' => $validated['title'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'path' => $storedPath,
        ]);

        if ($storedPath) {
            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($storedPath, 'public', $gallery);
            } else {
                ProcessImageDerivatives::dispatch($storedPath, 'public', $gallery);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image uploaded successfully!');
    }

    public function edit(Gallery $gallery)
    {
        $destinations = Destination::orderBy('name_en')->get();
        return view('admin.gallery.edit', compact('gallery', 'destinations'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination_id' => 'nullable|exists:destinations,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
        ]);

        $updateData = [
            'destination_id' => !empty($validated['destination_id']) ? $validated['destination_id'] : null,
            'name' => $validated['title'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('image')) {
            // Delete old stored image and derivatives if present
            $oldPath = $gallery->path;
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            if ($gallery->image_derivatives && is_array($gallery->image_derivatives)) {
                foreach ($gallery->image_derivatives as $derivativePath) {
                    if (Storage::disk('public')->exists($derivativePath)) {
                        Storage::disk('public')->delete($derivativePath);
                    }
                }
            }

            $storedPath = $request->file('image')->store('gallery', 'public');
            $updateData['path'] = $storedPath;
            $updateData['image_derivatives'] = null;

            if (config('queue.default') === 'sync') {
                ProcessImageDerivatives::dispatchSync($storedPath, 'public', $gallery);
            } else {
                ProcessImageDerivatives::dispatch($storedPath, 'public', $gallery);
            }
        }

        $gallery->update($updateData);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image updated successfully!');
    }

    public function destroy(Gallery $gallery)
    {
        $oldPath = $gallery->path ?? $gallery->image;
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        if ($gallery->image_derivatives && is_array($gallery->image_derivatives)) {
            foreach ($gallery->image_derivatives as $derivativePath) {
                if (Storage::disk('public')->exists($derivativePath)) {
                    Storage::disk('public')->delete($derivativePath);
                }
            }
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery image deleted successfully!');
    }
}
