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
            
            \Illuminate\Support\Facades\Log::info('📝 [DEBUG] Package booking started', [
                'package_id' => $package->id,
                'package_name' => $package->name,
                'validated_data' => $validated,
                'user_id' => auth()->id(),
            ]);

            // Untuk paket ini kita tidak pakai lagi add-on guide/transport, set 0 saja
            $guidePricePerGuest     = config('booking.addon_prices.guide', 50);
            $transportPricePerGuest = config('booking.addon_prices.transport', 30);

            $guidePrice     = !empty($validated['guide']) ? $guidePricePerGuest * $validated['guests'] : 0;
            $transportPrice = !empty($validated['transport']) ? $transportPricePerGuest * $validated['guests'] : 0;
            $addonCost      = $guidePrice + $transportPrice;

            $basePrice  = $package->price * $validated['guests'];
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

            // Arahkan ke halaman payment khusus paket
            return view('bookings.package-payment', compact('booking', 'snapToken'));
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
}
