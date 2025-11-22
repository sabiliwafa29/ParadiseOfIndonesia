<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourSession;

class TourSessionController extends Controller
{
    public function index()
    {
        $sessions = TourSession::with(['tourPackage.destination'])->latest()->paginate(20);
        
        // Calculate stats
        $totalSessions = TourSession::count();
        $upcomingSessions = TourSession::where('date', '>=', now())->count();
        $pastSessions = TourSession::where('date', '<', now())->count();
        
        return view('admin.tour-sessions.index', compact('sessions', 'totalSessions', 'upcomingSessions', 'pastSessions'));
    }

    public function create()
    {
        $tourPackages = \App\Models\TourPackage::with('destination')->get();
        return view('admin.tour-sessions.create', compact('tourPackages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'date' => 'required|date',
            'capacity' => 'nullable|integer',
        ]);

        TourSession::create($validated);

        return redirect()->route('admin.tour-sessions.index')->with('success', 'Session created successfully');
    }

    public function edit(TourSession $tourSession)
    {
        return view('admin.tour-sessions.edit', compact('tourSession'));
    }

    public function update(Request $request, TourSession $tourSession)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'capacity' => 'nullable|integer',
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
