<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourPackage;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePackageBookingRequest;
use App\Services\MidtransService;
use App\Services\OrderIdService;
use App\Services\BookingPriceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected MidtransService $midtransService;
    protected BookingPriceCalculator $priceCalculator;

    public function __construct(MidtransService $midtransService, BookingPriceCalculator $priceCalculator)
    {
        $this->midtransService = $midtransService;
        $this->priceCalculator = $priceCalculator;
    }

    public function index()
    {
        $bookings = auth()->user()->allBookings();
        return view('bookings.index', compact('bookings'));
    }

    public function store(StoreBookingRequest $request, Tour $tour)
    {
        return $this->handleTourBooking($request, $tour);
    }

    public function tour(Tour $tour)
    {
        return view('bookings.tour', compact('tour'));
    }

    public function package(TourPackage $package)
    {
        return $this->renderPackageBookingPage($package);
    }

    public function storePackage(StorePackageBookingRequest $request, TourPackage $package)
    {
        return $this->handlePackageBooking($request, $package);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $snapToken = $booking->payment_status !== 'paid'
            ? $this->midtransService->createTransaction($booking)
            : null;

        return view('bookings.show', compact('booking', 'snapToken'));
    }

    public function showPayment(Booking $booking)
    {
        if (!$this->authorizeBookingAccess($booking)) {
            return redirect()->route('home')->with('error', 'Unauthorized access to this booking.');
        }

        $booking->load(['tour', 'package', 'user']);

        $snapToken = session('booking_' . $booking->id . '_snap_token');
        if (!$snapToken && $booking->payment_status !== 'paid') {
            $snapToken = $this->midtransService->createTransaction($booking);
            session(['booking_' . $booking->id . '_snap_token' => $snapToken]);
        }

        $view = $booking->package_id ? 'bookings.package-payment' : 'bookings.payment';

        return view($view, compact('booking', 'snapToken'));
    }

    public function reschedule(Booking $booking)
    {
        $this->authorize('view', $booking);

        if (!in_array($booking->status, ['confirmed', 'pending', 'rescheduled'])) {
            return redirect()->route('my-bookings')
                ->with('error', __('Cannot reschedule this booking.'));
        }

        $item = $booking->package ? $booking->package : $booking->tour;
        $type = $booking->package ? 'package' : 'tour';

        return view('bookings.reschedule', compact('booking', 'item', 'type'));
    }

    public function updateReschedule(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'date' => $validated['date'],
            'status' => 'rescheduled',
            'reschedule_reason' => $validated['reason'] ?? null,
        ]);

        return redirect()->route('my-bookings')
            ->with('success', 'Booking rescheduled successfully to ' . \Carbon\Carbon::parse($validated['date'])->format('d M Y'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('view', $booking);

        if ($booking->status !== 'pending' || $booking->payment_status === 'paid') {
            return redirect()->route('my-bookings')
                ->with('error', __('Cannot cancel this booking. Only pending unpaid bookings can be cancelled.'));
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('my-bookings')
            ->with('success', 'Booking cancelled successfully');
    }

    protected function handleTourBooking(Request $request, Tour $tour): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $userId = auth()->id();
            $guests = (int) $validated['guests'];
            $date = $validated['date'];

            $duplicate = $this->priceCalculator->checkDuplicateBooking(
                'tour',
                $tour->id,
                $date,
                $guests,
                $validated['email'] ?? '',
                $userId
            );

            if ($duplicate) {
                return $this->redirectToExistingBooking($duplicate, $tour);
            }

            $bookingData = $this->buildTourBookingData($request, $tour, $validated, $userId);

            $prices = $this->priceCalculator->calculateTourBooking($validated, $tour);

            $booking = Booking::create(array_merge($bookingData, [
                'total_price' => $prices['total_price'],
                'addon_cost' => $prices['addon_cost'],
                'currency' => $prices['currency'],
                'order_id' => OrderIdService::generate('TOUR'),
            ]));

            $booking->load('tour', 'user');

            $snapToken = $this->midtransService->createTransaction($booking);

            if (!$snapToken) {
                $booking->delete();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create payment transaction. Please try again or contact admin.');
            }

            session([
                'booking_' . $booking->id . '_snap_token' => $snapToken,
                'last_booking_id' => $booking->id,
            ]);

            return redirect()->route('bookings.payment', $booking);
        } catch (\Exception $e) {
            Log::error('Tour booking error: ' . $e->getMessage(), [
                'tour_id' => $tour->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while processing your booking: ' . $e->getMessage());
        }
    }

    protected function handlePackageBooking(Request $request, TourPackage $package): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            $userId = auth()->id();
            $guests = (int) $validated['guests'];
            $date = $validated['date'];

            $duplicate = $this->priceCalculator->checkDuplicateBooking(
                'package',
                $package->id,
                $date,
                $guests,
                $validated['email'],
                $userId
            );

            if ($duplicate) {
                return $this->redirectToExistingPackageBooking($duplicate);
            }

            $prices = $this->priceCalculator->calculatePackageBooking(
                $package->price,
                $guests,
                $validated['guide'] ?? false,
                $validated['transport'] ?? false,
                $validated['special_link_token'] ?? null
            );

            $booking = Booking::create([
                'user_id' => $userId,
                'package_id' => $package->id,
                'full_name' => $validated['full_name'],
                'contact_handle' => $validated['contact_handle'],
                'email' => $validated['email'],
                'route_option' => $validated['route_option'] ?? null,
                'date' => $validated['date'],
                'guests' => $guests,
                'guide_service' => $validated['guide'] ?? false,
                'transport_service' => $validated['transport'] ?? false,
                'addon_cost' => $prices['addon_cost'],
                'total_price' => $prices['total_price'],
                'currency' => $prices['currency'],
                'status' => 'pending',
                'order_id' => OrderIdService::generate('BOOK'),
            ]);

            if (!empty($validated['special_link_token'])) {
                $link = \App\Models\SpecialLink::where('token', $validated['special_link_token'])->first();
                if ($link) {
                    $link->increment('used_count');
                }
            }

            $snapToken = $this->midtransService->createTransaction($booking);

            if (!$snapToken) {
                $booking->delete();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi atau hubungi admin.');
            }

            session([
                'booking_' . $booking->id . '_snap_token' => $snapToken,
                'last_booking_id' => $booking->id,
            ]);

            return redirect()->route('bookings.payment', $booking);
        } catch (\Exception $e) {
            Log::error('Package booking error: ' . $e->getMessage(), [
                'package_id' => $package->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pemesanan paket: ' . $e->getMessage());
        }
    }

    protected function buildTourBookingData(Request $request, Tour $tour, array $validated, int $userId): array
    {
        $bookingData = [
            'user_id' => $userId,
            'tour_id' => $tour->id,
            'date' => $validated['date'],
            'guests' => $validated['guests'],
            'special_requests' => $validated['special_requests'] ?? null,
            'status' => 'pending',
            'payment_status' => 'pending',
        ];

        if (auth()->guest()) {
            $bookingData['full_name'] = $validated['name'];
            $bookingData['email'] = $validated['email'];
            $bookingData['contact_handle'] = $validated['phone'];
        } else {
            $bookingData['full_name'] = auth()->user()->name;
            $bookingData['email'] = auth()->user()->email;
            $bookingData['contact_handle'] = auth()->user()->phone ?? $validated['phone'] ?? '';
        }

        return $bookingData;
    }

    protected function renderPackageBookingPage(TourPackage $package): \Illuminate\View\View
    {
        $specialLink = null;
        $basePrice = get_price($package);
        $preselectedGuests = null;

        if (request()->has('special')) {
            $token = request()->get('special');
            $specialLink = \App\Models\SpecialLink::where('token', $token)->first();

            if ($specialLink && $specialLink->isValid()) {
                $currency = \App\Helpers\LanguageHelper::getCurrentCurrency();
                $specialPrice = $specialLink->priceForCurrency($currency);
                if ($specialPrice) {
                    $basePrice = $specialPrice;
                }

                if (request()->has('guests')) {
                    $preselectedGuests = intval(request()->get('guests')) ?: null;
                }
            } else {
                $specialLink = null;
            }
        }

        return view('bookings.package', compact('package', 'specialLink', 'basePrice', 'preselectedGuests'));
    }

    protected function authorizeBookingAccess(Booking $booking): bool
    {
        if (auth()->check()) {
            $this->authorize('view', $booking);
            return true;
        }

        $sessionBookingId = session('last_booking_id');
        return $sessionBookingId === $booking->id;
    }

    protected function redirectToExistingBooking($existingBooking, Tour $tour): \Illuminate\Http\RedirectResponse
    {
        $existingBooking->load('tour', 'user');
        $snapToken = $this->midtransService->createTransaction($existingBooking);

        return view('bookings.payment', [
            'booking' => $existingBooking,
            'snapToken' => $snapToken,
        ])->with('info', 'You already have a pending booking for this tour. Please complete the payment.');
    }

    protected function redirectToExistingPackageBooking($existingBooking): \Illuminate\Http\RedirectResponse
    {
        $snapToken = $this->midtransService->createTransaction($existingBooking);

        return view('bookings.package-payment', [
            'booking' => $existingBooking,
            'snapToken' => $snapToken,
        ])->with('info', 'You already have a pending booking for this package. Please complete the payment.');
    }
}