<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\PickoffDestination;
use App\Models\TravelService;
use App\Models\TravelServiceBooking;
use App\Http\Requests\StoreTravelServiceBookingRequest;
use App\Services\MidtransService;
use App\Services\OrderIdService;

class TravelServiceController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = TravelService::latest()->paginate(12);
        return view('travel-services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function booking(TravelService $service)
    {
        $pickups = Pickup::all();
        $destinations = PickoffDestination::all();
        return view('travel-services.booking', compact('service', 'pickups', 'destinations'));
    }

    public function confirm(StoreTravelServiceBookingRequest $request, TravelService $service)
    {
        $validated = $request->validated();

        // Ambil data pickup dan destination dari database
        $pickup = Pickup::findOrFail($validated['pickup_id']);
        $destination = PickoffDestination::findOrFail($validated['destination_id']);

        // Hitung jarak menggunakan Haversine formula
        $distance = $this->calculateDistance(
            $pickup->latitude,
            $pickup->longitude,
            $destination->latitude,
            $destination->longitude
        );

        // Hitung total price (bisa ditambahkan logic untuk round-trip)
        $basePrice = $service->price;
        $totalPrice = $basePrice;
        if ($validated['booking_type'] === 'round-trip') {
            $totalPrice = $basePrice * 1.8; // 80% discount untuk return trip
        }

        // Simpan booking ke database
        $orderId = OrderIdService::generate('TSB'); // Travel Service Booking

        $booking = TravelServiceBooking::create([
            'user_id' => auth()->id(),
            'travel_service_id' => $service->id,
            'pickup_id' => $pickup->id,
            'pickoff_destination_id' => $destination->id,
            'booking_type' => $validated['booking_type'],
            'schedule_date' => $validated['schedule_date'],
            'schedule_time' => $validated['schedule_time'],
            'distance' => $distance,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'order_id' => $orderId,
        ]);

        return view('travel-services.confirmation', compact('service', 'pickup', 'destination', 'distance', 'booking'));
    }

    public function pay(Request $request, TravelService $service)
    {
        // Ambil booking dari database berdasarkan order_id atau booking_id
        $bookingId = $request->input('booking_id');
        
        if (!$bookingId) {
            return redirect()->back()->with('error', 'Booking ID tidak ditemukan');
        }

        $booking = TravelServiceBooking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->where('travel_service_id', $service->id)
            ->firstOrFail();

        // Generate Midtrans transaction
        $snapToken = $this->createTravelServiceTransaction($booking);

        if (!$snapToken) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran');
        }

        return view('travel-services.payment', compact('snapToken', 'booking', 'service'));
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371; // km

        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) ** 2 
            + cos(deg2rad($lat1)) 
            * cos(deg2rad($lat2)) 
            * sin($lonDiff / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return round($distance, 2);
    }

    /**
     * Create Midtrans transaction for travel service booking
     */
    private function createTravelServiceTransaction(TravelServiceBooking $booking): ?string
    {
        $booking->load('user', 'travelService', 'pickup', 'pickoffDestination');

        $params = [
            'transaction_details' => [
                'order_id' => $booking->order_id,
                'gross_amount' => (int) $booking->total_price,
            ],
            'item_details' => [
                [
                    'id' => $booking->travelService->id,
                    'price' => (int) $booking->total_price,
                    'quantity' => 1,
                    'name' => 'Travel Service: ' . $booking->travelService->name 
                        . ' (' . $booking->booking_type . ')',
                ],
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Guest',
                'email' => $booking->user->email ?? 'noemail@example.com',
                'phone' => $booking->user->phone ?? '08123456789',
            ],
            'enabled_payments' => [
                'qris', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'gopay', 'shopeepay',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans error: ' . $e->getMessage());
            return null;
        }
    }


    public function paymentSuccess(Request $request)
    {
        return view('travel-services.success');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelService $service)
    {
        $pickups = Pickup::all();
        $pickoffdestinations = PickoffDestination::all();

        return view('travel-services.show', compact('service', 'pickups', 'pickoffdestinations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
