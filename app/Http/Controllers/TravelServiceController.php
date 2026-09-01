<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Models\PickoffDestination;
use App\Models\TravelService;
use App\Models\TravelServiceBooking;
use App\Http\Requests\StoreTravelServiceBookingRequest;
use App\Services\MidtransService;
use App\Services\OrderIdService;
use App\Services\OsrmService;
use Illuminate\Http\Request;

class TravelServiceController extends Controller
{
    protected MidtransService $midtransService;
    protected OsrmService $osrmService;

    public function __construct(MidtransService $midtransService, OsrmService $osrmService)
    {
        $this->midtransService = $midtransService;
        $this->osrmService = $osrmService;
    }

    public function index()
    {
        $services = TravelService::latest()->paginate(12);
        return view('travel-services.index', compact('services'));
    }

    public function show(TravelService $service)
    {
        $pickups = Pickup::all();
        $pickoffdestinations = PickoffDestination::all();

        return view('travel-services.show', compact('service', 'pickups', 'pickoffdestinations'));
    }

    public function booking(TravelService $service)
    {
        $pickups = Pickup::all();
        $destinations = PickoffDestination::all();

        return view('travel-services.booking', compact('service', 'pickups', 'destinations'));
    }

    public function confirm(StoreTravelServiceBookingRequest $request, TravelService $service)
    {
        $validated = $request->validated();

        $pickup = Pickup::findOrFail($validated['pickup_id']);
        $destination = PickoffDestination::findOrFail($validated['destination_id']);

        $distanceResult = $this->osrmService->calculateDistance(
            $pickup->latitude,
            $pickup->longitude,
            $destination->latitude,
            $destination->longitude
        );

        $distance = $distanceResult['distance'];
        $basePrice = \App\Helpers\LanguageHelper::getPrice($service);
        $totalPrice = $this->calculateTotalPrice($basePrice, $validated['booking_type']);

        $orderId = OrderIdService::generate('TSB');

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

    protected function calculateTotalPrice(float $basePrice, string $bookingType): float
    {
        return $bookingType === 'round-trip' ? $basePrice * 1.8 : $basePrice;
    }

    public function pay(Request $request, TravelService $service)
    {
        $bookingId = $request->input('booking_id');

        if (!$bookingId) {
            return redirect()->back()->with('error', 'Booking ID not found');
        }

        $booking = TravelServiceBooking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->where('travel_service_id', $service->id)
            ->firstOrFail();

        $snapToken = $this->createTravelServiceTransaction($booking);

        if (!$snapToken) {
            return redirect()->back()->with('error', 'Failed to create payment transaction');
        }

        return view('travel-services.payment', compact('snapToken', 'booking', 'service'));
    }

    protected function createTravelServiceTransaction(TravelServiceBooking $booking): ?string
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
                    'name' => 'Travel Service: ' . $booking->travelService->name . ' (' . $booking->booking_type . ')',
                ],
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Guest',
                'email' => $booking->user->email ?? 'noemail@example.com',
                'phone' => $booking->user->phone ?? '08123456789',
            ],
            'enabled_payments' => ['qris', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'gopay', 'shopeepay'],
        ];

        try {
            return \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans error: ' . $e->getMessage());
            return null;
        }
    }

    public function paymentSuccess(Request $request)
    {
        return view('travel-services.success');
    }
}