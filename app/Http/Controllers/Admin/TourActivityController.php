<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourActivity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\ProcessImageDerivatives;

class TourActivityController extends Controller
{
    public function index()
    {
        $activities = TourActivity::latest()->paginate(20);
        return view('admin.tour-activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.tour-activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'what_to_bring' => 'nullable|array',
            'what_to_bring.*' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            // Create a clean filename without spaces or special characters
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $cleanName = Str::slug($originalName); // Convert to URL-friendly format
            $filename = time() . '_' . $cleanName . '.' . $extension;
            
            // Store in Laravel Storage disk (storage/app/public/images/activities)
            $path = $photo->storeAs('images/activities', $filename, 'public');
            $validated['photo'] = $path;
            
            // Dispatch job to generate image derivatives (thumbnails, responsive sizes)
            ProcessImageDerivatives::dispatch($path, 'public');
        }

        // Convert arrays to JSON
        if (isset($validated['highlights'])) {
            $validated['highlights'] = json_encode(array_filter($validated['highlights']));
        }
        if (isset($validated['what_to_bring'])) {
            $validated['what_to_bring'] = json_encode(array_filter($validated['what_to_bring']));
        }

        TourActivity::create($validated);

        return redirect()->route('admin.tour-activities.index')->with('success', 'Activity created successfully');
    }

    public function edit(TourActivity $tourActivity)
    {
        return view('admin.tour-activities.edit', compact('tourActivity'));
    }

    public function update(Request $request, TourActivity $tourActivity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'what_to_bring' => 'nullable|array',
            'what_to_bring.*' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo from Storage disk
            if ($tourActivity->photo && Storage::disk('public')->exists($tourActivity->photo)) {
                Storage::disk('public')->delete($tourActivity->photo);
                
                // Also delete derivatives if they exist
                $pathInfo = pathinfo($tourActivity->photo);
                $dir = $pathInfo['dirname'];
                $filename = $pathInfo['filename'];
                $ext = $pathInfo['extension'] ?? '';
                
                $derivatives = [
                    $dir . '/' . $filename . '_thumb.' . $ext,
                    $dir . '/' . $filename . '_md.' . $ext,
                    $dir . '/' . $filename . '_lg.' . $ext,
                ];
                
                foreach ($derivatives as $derivative) {
                    if (Storage::disk('public')->exists($derivative)) {
                        Storage::disk('public')->delete($derivative);
                    }
                }
            }
            // Also check and delete from old public path (for backward compatibility)
            elseif ($tourActivity->photo && file_exists(public_path($tourActivity->photo))) {
                unlink(public_path($tourActivity->photo));
            }
            
            $photo = $request->file('photo');
            
            // Create a clean filename without spaces or special characters
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $cleanName = Str::slug($originalName); // Convert to URL-friendly format
            $filename = time() . '_' . $cleanName . '.' . $extension;
            
            // Store in Laravel Storage disk (storage/app/public/images/activities)
            $path = $photo->storeAs('images/activities', $filename, 'public');
            $validated['photo'] = $path;
            
            // Dispatch job to generate image derivatives (thumbnails, responsive sizes)
            ProcessImageDerivatives::dispatch($path, 'public');
        }

        // Convert arrays to JSON
        if (isset($validated['highlights'])) {
            $validated['highlights'] = json_encode(array_filter($validated['highlights']));
        }
        if (isset($validated['what_to_bring'])) {
            $validated['what_to_bring'] = json_encode(array_filter($validated['what_to_bring']));
        }

        $tourActivity->update($validated);

        return redirect()->route('admin.tour-activities.index')->with('success', 'Activity updated successfully');
    }

    public function destroy(TourActivity $tourActivity)
    {
        // Delete photo from Storage disk
        if ($tourActivity->photo && Storage::disk('public')->exists($tourActivity->photo)) {
            Storage::disk('public')->delete($tourActivity->photo);
            
            // Also delete derivatives if they exist
            $pathInfo = pathinfo($tourActivity->photo);
            $dir = $pathInfo['dirname'];
            $filename = $pathInfo['filename'];
            $ext = $pathInfo['extension'] ?? '';
            
            $derivatives = [
                $dir . '/' . $filename . '_thumb.' . $ext,
                $dir . '/' . $filename . '_md.' . $ext,
                $dir . '/' . $filename . '_lg.' . $ext,
            ];
            
            foreach ($derivatives as $derivative) {
                if (Storage::disk('public')->exists($derivative)) {
                    Storage::disk('public')->delete($derivative);
                }
            }
        }
        // Also check and delete from old public path (for backward compatibility)
        elseif ($tourActivity->photo && file_exists(public_path($tourActivity->photo))) {
            unlink(public_path($tourActivity->photo));
        }
        
        $tourActivity->delete();
        return redirect()->route('admin.tour-activities.index')->with('success', 'Activity deleted');
    }
}
