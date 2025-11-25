<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourSession;

class TourSessionController extends Controller
{
    public function index()
    {
        try {
            $sessions = TourSession::with(['tourPackage.tours.destination'])->latest()->paginate(20);
            
            // Calculate stats
            $totalSessions = TourSession::count();
            $upcomingSessions = TourSession::where('start_date', '>=', now())->count();
            $pastSessions = TourSession::where('end_date', '<', now())->count();
            
            return view('admin.tour-sessions.index', compact('sessions', 'totalSessions', 'upcomingSessions', 'pastSessions'));
        } catch (\Exception $e) {
            \Log::error('TourSession index error: ' . $e->getMessage());
            return back()->with('error', 'Error loading tour sessions: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $tourPackages = \App\Models\TourPackage::with('tours.destination')->get();
            return view('admin.tour-sessions.create', compact('tourPackages'));
        } catch (\Exception $e) {
            \Log::error('TourSession create error: ' . $e->getMessage());
            return back()->with('error', 'Error loading form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
        ]);

        TourSession::create($validated);

        return redirect()->route('admin.tour-sessions.index')->with('success', 'Session created successfully');
    }

    public function edit(TourSession $tourSession)
    {
        try {
            $tourSession->load('tourPackage.tours.destination');
            return view('admin.tour-sessions.edit', compact('tourSession'));
        } catch (\Exception $e) {
            \Log::error('TourSession edit error: ' . $e->getMessage());
            return back()->with('error', 'Error loading session: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TourSession $tourSession)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
        ]);

        $tourSession->update($validated);

        return redirect()->route('admin.tour-sessions.index')->with('success', 'Session updated');
    }

    public function destroy(TourSession $tourSession)
    {
        $tourSession->delete();
        return redirect()->route('admin.tour-sessions.index')->with('success', 'Session deleted');
    }
}
