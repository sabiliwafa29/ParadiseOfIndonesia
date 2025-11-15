<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourPackage;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePackageBookingRequest;
use App\Services\MidtransService;
use App\Services\OrderIdService;

class BookingController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()->with(['tour.destination', 'package'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function store(StoreBookingRequest $request, Tour $tour)
    {
        try {
            $validated = $request->validated();

            // Get prices from config
            $guidePricePerGuest = config('booking.addon_prices.guide', 50);
            $transportPricePerGuest = config('booking.addon_prices.transport', 30);

            // Calculate addon costs
            $guidePrice = $validated['guide'] ? $guidePricePerGuest * $validated['guests'] : 0;
            $transportPrice = $validated['transport'] ? $transportPricePerGuest * $validated['guests'] : 0;
            $addonCost = $guidePrice + $transportPrice;
            $basePrice = $tour->price * $validated['guests'];
            $totalPrice = $basePrice + $addonCost;

            // Generate order ID
            $orderId = OrderIdService::generate('BOOK');

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
                'order_id' => $orderId,
            ]);

            // Get Midtrans payment token
            $snapToken = $this->midtransService->createTransaction($booking);

            return view('bookings.payment', compact('booking', 'snapToken'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pemesanan: ' . $e->getMessage());
        }
    }

    public function package(TourPackage $package)
    {
        return view('bookings.package', compact('package'));
    }

    public function storePackage(StorePackageBookingRequest $request, TourPackage $package)
    {
        try {
            $validated = $request->validated();

            // Get prices from config
            $guidePricePerGuest     = config('booking.addon_prices.guide', 50);
            $transportPricePerGuest = config('booking.addon_prices.transport', 30);

            // Calculate addon costs
            $guidePrice     = !empty($validated['guide']) ? $guidePricePerGuest * $validated['guests'] : 0;
            $transportPrice = !empty($validated['transport']) ? $transportPricePerGuest * $validated['guests'] : 0;
            $addonCost      = $guidePrice + $transportPrice;

            $basePrice  = $package->price * $validated['guests'];
            $totalPrice = $basePrice + $addonCost;

            // Generate order ID
            $orderId = OrderIdService::generate('BOOK');

            $booking = Booking::create([
                'user_id'   => auth()->id(), // bisa null untuk guest
                'package_id'=> $package->id,

                'full_name'      => $validated['full_name'],
                'contact_handle' => $validated['contact_handle'],
                'email'          => $validated['email'],

                'date'            => $validated['date'],
                'guests'          => $validated['guests'],
                'guide_service'   => $validated['guide'],
                'transport_service'=> $validated['transport'],
                'addon_cost'      => $addonCost,
                'total_price'     => $totalPrice,
                'status'          => 'pending',
                'order_id'        => $orderId,
            ]);

            // Get Midtrans payment token
            $snapToken = $this->midtransService->createTransaction($booking);

            return view('bookings.package-payment', compact('booking', 'snapToken'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pemesanan paket: ' . $e->getMessage());
        }
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $snapToken = null;
        if ($booking->payment_status !== 'paid') {
            $snapToken = $this->midtransService->createTransaction($booking);
        }

        return view('bookings.show', compact('booking', 'snapToken'));
    }
}
