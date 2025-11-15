<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourActivity;

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
            'description' => 'nullable|string',
        ]);

        TourActivity::create($validated);

        return redirect()->route('admin.tour-activities.index')->with('success', 'Activity created');
    }

    public function edit(TourActivity $tourActivity)
    {
        return view('admin.tour-activities.edit', compact('tourActivity'));
    }

    public function update(Request $request, TourActivity $tourActivity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tourActivity->update($validated);

        return redirect()->route('admin.tour-activities.index')->with('success', 'Activity updated');
    }

    public function destroy(TourActivity $tourActivity)
    {
        $tourActivity->delete();
        return redirect()->route('admin.tour-activities.index')->with('success', 'Activity deleted');
    }
}
