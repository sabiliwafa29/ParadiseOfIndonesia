<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\MidtransService;

class BookingController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()->with('tour.destination')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'date' => 'required|date|after:today',
            'guests' => 'required|integer|min:1',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'tour_id' => $tour->id,
            'date' => $validated['date'],
            'guests' => $validated['guests'],
            'total_price' => $tour->price * $validated['guests'],
            'status' => 'pending',
        ]);

        // Get Midtrans payment token
        $snapToken = $this->midtransService->createTransaction($booking);

        return view('bookings.payment', compact('booking', 'snapToken'));
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }
}