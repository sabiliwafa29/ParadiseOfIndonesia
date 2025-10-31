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
        try {
            // Ensure boolean fields are present with false if not checked
            $request->merge([
                'guide' => $request->has('guide'),
                'transport' => $request->has('transport'),
            ]);

            $validated = $request->validate([
                'date' => 'required|date|after:today',
                'guests' => 'required|integer|min:1',
                'guide' => 'boolean', // Now it's always present as boolean
                'transport' => 'boolean', // Now it's always present as boolean
            ]);

            // Calculate addon costs
            $guidePrice = $validated['guide'] ? 50 * $validated['guests'] : 0;
            $transportPrice = $validated['transport'] ? 30 * $validated['guests'] : 0;
            $addonCost = $guidePrice + $transportPrice;
            $basePrice = $tour->price * $validated['guests'];
            $totalPrice = $basePrice + $addonCost;

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'tour_id' => $tour->id,
                'date' => $validated['date'],
                'guests' => $validated['guests'],
                'guide_service' => $validated['guide'],
                'transport_service' => $validated['transport'],
                'addon_cost' => $addonCost,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Get Midtrans payment token
            $snapToken = $this->midtransService->createTransaction($booking);

            return view('bookings.payment', compact('booking', 'snapToken'));
        } catch (\Exception $e) {
            // Untuk debugging, tampilkan error langsung
            dd($e->getMessage(), $e->getFile(), $e->getLine());
            // Atau redirect dengan pesan error
            // return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pemesanan: ' . $e->getMessage());
        }
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }
}
