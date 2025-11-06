<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\PickoffDestination;
use App\Models\TravelService;

class TravelServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = \App\Models\TravelService::latest()->paginate(12);
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

    public function confirm(Request $request, $serviceId)
    {
        $service = TravelService::findOrFail($serviceId);

        // Ambil data pickup dan destination dari database
        $pickup = Pickup::find($request->pickup_id);
        $destination = PickoffDestination::find($request->destination_id);

        // Hitung jarak sederhana (opsional, atau bisa dari JS dikirim)
        $distance = 0;
        if ($pickup && $destination) {
            $earthRadius = 6371; // km
            $latDiff = deg2rad($destination->latitude - $pickup->latitude);
            $lngDiff = deg2rad($destination->longitude - $pickup->longitude);
            $a = sin($latDiff / 2) ** 2 + cos(deg2rad($pickup->latitude)) * cos(deg2rad($destination->latitude)) * sin($lngDiff / 2) ** 2;
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = round($earthRadius * $c, 2);
        }

        // Simpan sementara di session
        session([
            'booking' => [
                'service_id' => $service->id,
                'pickup' => $pickup,
                'destination' => $destination,
                'booking_type' => $request->booking_type,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => $request->schedule_time,
                'distance' => $distance,
            ]
        ]);

        return view('travel-services.confirmation', compact('service', 'pickup', 'destination', 'distance', 'request'));
    }

    public function pay(Request $request, $serviceId)
    {
        $booking = session('booking');
        $service = TravelService::findOrFail($serviceId);

        // Simpan booking ke database sebelum buat transaksi
        $orderId = 'BOOK-' . rand(1000, 9999);

        $transaction = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $service->price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($transaction);

        return view('travel-services.payment', compact('snapToken', 'orderId', 'service'));
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
