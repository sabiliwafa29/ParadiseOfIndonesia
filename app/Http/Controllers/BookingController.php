<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourPackage;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePackageBookingRequest;
use App\Services\MidtransService;
use App\Services\OrderIdService;
use App\Helpers\LanguageHelper;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        // Get all bookings including those made before registration (by email)
        $bookings = auth()->user()->allBookings();
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
            $basePrice = get_price($tour) * $validated['guests'];
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
                'currency' => LanguageHelper::getCurrentCurrency(),
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

    public function tour(Tour $tour)
    {
        return view('bookings.tour', compact('tour'));
    }

    public function storeTour(Request $request, Tour $tour)
    {
        try {
            \Illuminate\Support\Facades\Log::info('🚀 [TOUR BOOKING] Starting tour booking process', [
                'tour_id' => $tour->id,
                'tour_name' => $tour->name,
                'user_id' => auth()->id(),
                'is_guest' => auth()->guest(),
                'request_data' => $request->all(),
            ]);

            // Validasi input - gunakan min_guests dari tour
            $minGuests = $tour->min_guests ?? 1;
            $validated = $request->validate([
                'name' => auth()->guest() ? 'required|string|max:255' : 'nullable',
                'email' => auth()->guest() ? 'required|email' : 'nullable',
                'phone' => auth()->guest() ? 'required|string|max:20' : 'nullable',
                'date' => 'required|date|after:today',
                'guests' => "required|integer|min:{$minGuests}|max:50",
                'special_requests' => 'nullable|string|max:500',
                'terms' => 'accepted',
            ], [
                'guests.min' => "Minimal {$minGuests} tamu diperlukan untuk tour ini.",
            ]);

            \Illuminate\Support\Facades\Log::info('✅ [TOUR BOOKING] Validation passed', [
                'validated' => $validated,
            ]);

            // Prepare booking data
            $bookingData = [
                'user_id' => auth()->id(),
                'tour_id' => $tour->id,
                'date' => $validated['date'],
                'guests' => $validated['guests'],
                'special_requests' => $validated['special_requests'] ?? null,
                'status' => 'pending',
                'payment_status' => 'pending',
            ];

            // Untuk guest, simpan data kontak
            if (auth()->guest()) {
                $bookingData['full_name'] = $validated['name'];
                $bookingData['email'] = $validated['email'];
                $bookingData['contact_handle'] = $validated['phone'];
            } else {
                $bookingData['full_name'] = auth()->user()->name;
                $bookingData['email'] = auth()->user()->email;
                $bookingData['contact_handle'] = auth()->user()->phone ?? $validated['phone'] ?? '';
            }

            \Illuminate\Support\Facades\Log::info('📋 [TOUR BOOKING] Booking data prepared', [
                'booking_data' => $bookingData,
            ]);

            // ✅ PREVENT DUPLICATE: Cek apakah ada booking pending yang sama dalam 10 menit terakhir
            $recentBookingQuery = Booking::where('tour_id', $tour->id)
                ->where('date', $validated['date'])
                ->where('guests', $validated['guests'])
                ->where('status', 'pending')
                ->where('payment_status', '!=', 'paid')
                ->where('created_at', '>=', now()->subMinutes(10));
            
            // Jika user login, cek by user_id, jika guest cek by email
            if (auth()->check()) {
                $recentBookingQuery->where('user_id', auth()->id());
            } else {
                $recentBookingQuery->where('email', $bookingData['email']);
            }
            
            $existingBooking = $recentBookingQuery->first();
            
            if ($existingBooking) {
                \Illuminate\Support\Facades\Log::info('⚠️ [DEBUG] Duplicate booking detected, redirecting to existing', [
                    'existing_booking_id' => $existingBooking->id,
                    'order_id' => $existingBooking->order_id,
                ]);
                
                // Load relasi sebelum generate snap token
                $existingBooking->load('tour', 'user');
                
                // Generate snap token untuk booking yang sudah ada
                $snapToken = $this->midtransService->createTransaction($existingBooking);
                
                return view('bookings.payment', [
                    'booking' => $existingBooking,
                    'snapToken' => $snapToken
                ])->with('info', 'You already have a pending booking for this tour. Please complete the payment.');
            }

            // Calculate price
            $pricePerPerson = get_price($tour);
            $totalPrice = $pricePerPerson * $validated['guests'];

            // Generate order ID
            $orderId = OrderIdService::generate('TOUR');
            
            $bookingData['total_price'] = $totalPrice;
            $bookingData['order_id'] = $orderId;
            // Persist currency at booking creation so payment choice is deterministic
            $bookingData['currency'] = LanguageHelper::getCurrentCurrency();

            \Illuminate\Support\Facades\Log::info('💰 [DEBUG] Price calculated', [
                'price_per_person' => $pricePerPerson,
                'total_price' => $totalPrice,
                'order_id' => $orderId,
            ]);

            // Create booking
            $booking = Booking::create($bookingData);
            
            // ✅ PENTING: Load relasi tour sebelum pass ke Midtrans
            $booking->load('tour', 'user');
            
            \Illuminate\Support\Facades\Log::info('✅ [DEBUG] Booking created', [
                'booking_id' => $booking->id,
                'order_id' => $booking->order_id,
                'has_tour' => $booking->tour ? true : false,
            ]);

            // Generate Midtrans snap token
            \Illuminate\Support\Facades\Log::info('🎫 [TOUR BOOKING] Generating Midtrans snap token...', [
                'booking_id' => $booking->id,
                'order_id' => $booking->order_id,
                'total_price' => $booking->total_price,
                'has_tour' => $booking->tour ? true : false,
                'tour_name' => $booking->tour ? $booking->tour->name : 'N/A',
            ]);
            
            $snapToken = $this->midtransService->createTransaction($booking);
            
            \Illuminate\Support\Facades\Log::info('✅ [TOUR BOOKING] Snap token result', [
                'booking_id' => $booking->id,
                'snap_token' => $snapToken ? 'SUCCESS' : 'NULL_RETURNED',
                'token_length' => $snapToken ? strlen($snapToken) : 0,
                'token_type' => gettype($snapToken),
            ]);

            if (!$snapToken) {
                \Illuminate\Support\Facades\Log::error('❌ [DEBUG] Failed to generate snap token, deleting booking', [
                    'booking_id' => $booking->id,
                ]);
                
                // Hapus booking jika gagal generate snap token
                $booking->delete();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create payment transaction. Please try again or contact admin.');
            }

            \Illuminate\Support\Facades\Log::info('🚀 [DEBUG] Redirecting to payment page', [
                'booking_id' => $booking->id,
                'has_snap_token' => !empty($snapToken),
            ]);

            // Simpan snap token di session
            session(['booking_' . $booking->id . '_snap_token' => $snapToken]);
            
            // Simpan booking ID di session untuk guest access
            session(['last_booking_id' => $booking->id]);

            // Redirect to payment page
            return redirect()->route('bookings.payment', $booking);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('❌ [DEBUG] Error creating tour booking: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'tour_id' => $tour->id ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while processing your booking: ' . $e->getMessage());
        }
    }

    public function storePackage(StorePackageBookingRequest $request, TourPackage $package)
    {
        try {
            $validated = $request->validated();
            
            \Illuminate\Support\Facades\Log::info('📝 [DEBUG] Package booking started', [
                'package_id' => $package->id,
                'package_name' => $package->name,
                'validated_data' => $validated,
                'user_id' => auth()->id(),
            ]);

            // ✅ PREVENT DUPLICATE: Cek apakah ada booking pending yang sama dalam 10 menit terakhir
            $recentBookingQuery = Booking::where('package_id', $package->id)
                ->where('date', $validated['date'])
                ->where('guests', $validated['guests'])
                ->where('status', 'pending')
                ->where('payment_status', '!=', 'paid')
                ->where('created_at', '>=', now()->subMinutes(10));
            
            // Jika user login, cek by user_id, jika guest cek by email
            if (auth()->check()) {
                $recentBookingQuery->where('user_id', auth()->id());
            } else {
                $recentBookingQuery->where('email', $validated['email']);
            }
            
            $existingBooking = $recentBookingQuery->first();
            
            if ($existingBooking) {
                \Illuminate\Support\Facades\Log::info('⚠️ [DEBUG] Duplicate booking detected, redirecting to existing', [
                    'existing_booking_id' => $existingBooking->id,
                    'order_id' => $existingBooking->order_id,
                ]);
                
                // Generate snap token untuk booking yang sudah ada
                $snapToken = $this->midtransService->createTransaction($existingBooking);
                
                return view('bookings.package-payment', [
                    'booking' => $existingBooking,
                    'snapToken' => $snapToken
                ])->with('info', 'You already have a pending booking for this package. Please complete the payment.');
            }

            // Untuk paket ini kita tidak pakai lagi add-on guide/transport, set 0 saja
            $guidePricePerGuest     = config('booking.addon_prices.guide', 50);
            $transportPricePerGuest = config('booking.addon_prices.transport', 30);

            $guidePrice     = !empty($validated['guide']) ? $guidePricePerGuest * $validated['guests'] : 0;
            $transportPrice = !empty($validated['transport']) ? $transportPricePerGuest * $validated['guests'] : 0;
            $addonCost      = $guidePrice + $transportPrice;

            $basePrice  = get_price($package) * $validated['guests'];
            $totalPrice = $basePrice + $addonCost;

            // Generate order ID
            $orderId = OrderIdService::generate('BOOK');
            
            \Illuminate\Support\Facades\Log::info('💰 [DEBUG] Price calculated', [
                'base_price' => $basePrice,
                'addon_cost' => $addonCost,
                'total_price' => $totalPrice,
                'order_id' => $orderId,
            ]);

            $booking = Booking::create([
                'user_id'    => auth()->id(), // boleh null untuk guest
                'package_id' => $package->id,

                'full_name'      => $validated['full_name'],
                'contact_handle' => $validated['contact_handle'],
                'email'          => $validated['email'],
                'route_option'   => $validated['route_option'] ?? null,

                'date'             => $validated['date'],
                'guests'           => $validated['guests'],
                'guide_service'    => $validated['guide'] ?? false,
                'transport_service'=> $validated['transport'] ?? false,
                'addon_cost'       => $addonCost,
                'total_price'      => $totalPrice,
                'currency'         => LanguageHelper::getCurrentCurrency(),
                'status'           => 'pending',
                'order_id'         => $orderId,
            ]);
            
            \Illuminate\Support\Facades\Log::info('✅ [DEBUG] Booking created', [
                'booking_id' => $booking->id,
                'order_id' => $booking->order_id,
            ]);

            // Ambil Snap token Midtrans
            \Illuminate\Support\Facades\Log::info('🎫 [DEBUG] Generating Midtrans snap token...');
            
            $snapToken = $this->midtransService->createTransaction($booking);
            
            \Illuminate\Support\Facades\Log::info('🎫 [DEBUG] Snap token generated', [
                'snap_token' => $snapToken ? 'SUCCESS' : 'FAILED',
                'token_length' => $snapToken ? strlen($snapToken) : 0,
            ]);

            if (!$snapToken) {
                \Illuminate\Support\Facades\Log::error('❌ [DEBUG] Failed to generate snap token, deleting booking', [
                    'booking_id' => $booking->id,
                ]);
                
                // Hapus booking jika gagal generate snap token
                $booking->delete();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal membuat transaksi pembayaran. Silakan coba lagi atau hubungi admin.');
            }

            \Illuminate\Support\Facades\Log::info('🚀 [DEBUG] Redirecting to payment page', [
                'booking_id' => $booking->id,
                'has_snap_token' => !empty($snapToken),
            ]);

            // Simpan snap token di session untuk prevent regenerate
            session(['booking_' . $booking->id . '_snap_token' => $snapToken]);
            
            // Simpan booking ID di session untuk guest access
            session(['last_booking_id' => $booking->id]);

            // REDIRECT to GET route untuk prevent duplicate on refresh
            return redirect()->route('bookings.payment', $booking);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('❌ [DEBUG] Error creating package booking: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'package_id' => $package->id ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
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


public function showPayment(Booking $booking)
    {
        try {
            // Authorization: allow if user_id matches OR email matches OR no auth (guest with session)
            if (auth()->check()) {
                $this->authorize('view', $booking);
            } else {
                // Guest: verify via session or email
                $sessionBookingId = session('last_booking_id');
                if ($sessionBookingId !== $booking->id) {
                    abort(403, 'Unauthorized access to this booking.');
                }
            }

            // Load relasi untuk ensure data lengkap
            $booking->load(['tour', 'package', 'user']);
            
            // Ambil snap token dari session atau generate baru
            $snapToken = session('booking_' . $booking->id . '_snap_token');
            
            if (!$snapToken && $booking->payment_status !== 'paid') {
                $snapToken = $this->midtransService->createTransaction($booking);
                session(['booking_' . $booking->id . '_snap_token' => $snapToken]);
            }

            // Tentukan view berdasarkan jenis booking
            $view = $booking->package_id ? 'bookings.package-payment' : 'bookings.payment';
            
            return view($view, compact('booking', 'snapToken'));
        } catch (\Exception $e) {
            \Log::error('Error showing payment page: ' . $e->getMessage(), [
                'booking_id' => $booking->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->route('home')
                ->with('error', 'Error loading payment page: ' . $e->getMessage());
        }
    }

    /**
 * Show reschedule form
 */
public function reschedule(Booking $booking)
{
    // Authorization check
    $this->authorize('view', $booking);
    
    // Hanya bisa reschedule booking yang confirmed atau pending
    if (!in_array($booking->status, ['confirmed', 'pending', 'rescheduled'])) {
        return redirect()->route('my-bookings')
            ->with('error', __('Cannot reschedule this booking.'));
    }
    
    // Ambil data tour atau package
    if ($booking->package) {
        $item = $booking->package;
        $type = 'package';
    } else {
        $item = $booking->tour;
        $type = 'tour';
    }
    
    return view('bookings.reschedule', compact('booking', 'item', 'type'));
}

/**
 * Update rescheduled booking
 */
public function updateReschedule(Request $request, Booking $booking)
{
    // Authorization check
    $this->authorize('view', $booking);
    
    // Validasi
    $validated = $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'reason' => 'nullable|string|max:500',
    ]);
    
    // Update booking
    $booking->update([
        'date' => $validated['date'],
        'status' => 'rescheduled',
        'reschedule_reason' => $validated['reason'] ?? null,
    ]);
    
    return redirect()->route('my-bookings')
        ->with('success', 'Booking rescheduled successfully to ' . \Carbon\Carbon::parse($validated['date'])->format('d M Y'));
}

/**
 * Cancel a pending booking
 */
public function cancel(Booking $booking)
{
    // Authorization check
    $this->authorize('view', $booking);
    
    // Hanya bisa cancel booking yang pending dan belum dibayar
    if ($booking->status !== 'pending' || $booking->payment_status === 'paid') {
        return redirect()->route('my-bookings')
            ->with('error', __('Cannot cancel this booking. Only pending unpaid bookings can be cancelled.'));
    }
    
    // Update status booking menjadi cancelled
    $booking->update([
        'status' => 'cancelled',
    ]);
    
    return redirect()->route('my-bookings')
        ->with('success', 'Booking cancelled successfully');
}
}
