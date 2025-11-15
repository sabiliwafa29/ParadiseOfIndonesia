<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourSession;

class TourSessionController extends Controller
{
    public function index()
    {
        $sessions = TourSession::latest()->paginate(20);
        return view('admin.tour-sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.tour-sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'date' => 'required|date',
            'capacity' => 'nullable|integer',
        ]);

        TourSession::create($validated);

        return redirect()->route('admin.tour-sessions.index')->with('success', 'Session created');
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
