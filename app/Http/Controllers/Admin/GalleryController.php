<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

// Intervention Image is optional; guard with class_exists to keep deploy-safe
use App\Jobs\ProcessImageDerivatives;
use Intervention\Image\ImageManagerStatic as Image;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(20);
        
        // Calculate stats
        $totalImages = Gallery::count();
        
        return view('admin.gallery.index', compact('galleries', 'totalImages'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            // Store original upload
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery = Gallery::create($validated);

        // Dispatch background job to create derivatives (best-effort).
        // If queue driver is 'sync', dispatchSync will run immediately.
        if (config('queue.default') === 'sync') {
            ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $gallery);
        } else {
            ProcessImageDerivatives::dispatch($validated['image'], 'public', $gallery);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image && \Storage::disk('public')->exists($gallery->image)) {
                \Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery updated');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && \Storage::disk('public')->exists($gallery->image)) {
            \Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery deleted');
    }
}
