<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Services\OrderIdService;

class BookingController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    // ✅ AMBIL SEMUA BOOKING USER LOGIN
    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->with('tour.destination')
            ->latest()
            ->get();

        return response()->json($bookings);
    }

    // ✅ BUAT BOOKING BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'date' => 'required|date|after:today',
            'guests' => 'required|integer|min:1',
            'guide' => 'boolean',
            'transport' => 'boolean',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);

        // Get prices from config
        $guidePricePerGuest = config('booking.addon_prices.guide', 50);
        $transportPricePerGuest = config('booking.addon_prices.transport', 30);

        $guidePrice = ($validated['guide'] ?? false) ? $guidePricePerGuest * $validated['guests'] : 0;
        $transportPrice = ($validated['transport'] ?? false) ? $transportPricePerGuest * $validated['guests'] : 0;
        $addonCost = $guidePrice + $transportPrice;
        $totalPrice = (get_price($tour) * $validated['guests']) + $addonCost;

        // Generate order ID
        $orderId = OrderIdService::generate('BOOK');

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'tour_id' => $tour->id,
            'date' => $validated['date'],
            'guests' => $validated['guests'],
            'guide_service' => $validated['guide'] ?? false,
            'transport_service' => $validated['transport'] ?? false,
            'addon_cost' => $addonCost,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'order_id' => $orderId,
        ]);

        // 🔹 Generate Snap Token
        $snapToken = $this->midtrans->createTransaction($booking);

        return response()->json([
            'success' => true,
            'booking' => $booking,
            'snap_token' => $snapToken,
        ]);
    }

    // ✅ DETAIL BOOKING
    public function show(Booking $booking, Request $request)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $snapToken = $this->midtrans->createTransaction($booking);

        return response()->json([
            'booking' => $booking->load('tour.destination'),
            'snap_token' => $snapToken,
        ]);
    }
}
