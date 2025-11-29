<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function createOrder(Request $request, Booking $booking)
    {
        // Authorization: allow owner or guest with session
        if (auth()->check()) {
            $this->authorize('view', $booking);
        } else {
            $sessionBookingId = session('last_booking_id');
            if ($sessionBookingId !== $booking->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $currency = $request->input('currency', app()->getLocale() === 'id' ? 'IDR' : \App\Helpers\LanguageHelper::getCurrentCurrency());

        // Create PayPal order
        $result = $this->payPalService->createOrder($booking, $currency);

        if (!$result) {
            $detail = $this->payPalService->getLastError();
            $safeDetail = $detail ? (is_string($detail) ? substr($detail, 0, 1000) : json_encode($detail)) : 'Unknown error from PayPal service';
            return response()->json(['error' => 'Failed to create PayPal order', 'details' => $safeDetail], 500);
        }

        return response()->json($result);
    }

    public function captureOrder(Request $request, Booking $booking)
    {
        // Validate same auth logic
        if (auth()->check()) {
            $this->authorize('view', $booking);
        } else {
            $sessionBookingId = session('last_booking_id');
            if ($sessionBookingId !== $booking->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $orderId = $request->input('orderID');
        if (!$orderId) {
            return response()->json(['error' => 'Missing orderID'], 400);
        }

        $capture = $this->payPalService->captureOrder($orderId);

        if (!$capture) {
            $detail = $this->payPalService->getLastError();
            $safeDetail = $detail ? (is_string($detail) ? substr($detail, 0, 1000) : json_encode($detail)) : 'Unknown error from PayPal service';
            return response()->json(['error' => 'Failed to capture PayPal order', 'details' => $safeDetail], 500);
        }

        // Update booking payment status - minimal: mark paid
        try {
            $booking->payment_status = 'paid';
            $booking->payment_method = 'paypal';
            $booking->status = 'confirmed';
            $booking->save();

            // Optionally dispatch events or send confirmation email here
        } catch (\Exception $e) {
            Log::error('Failed to update booking after PayPal capture: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return response()->json($capture);
    }
}
