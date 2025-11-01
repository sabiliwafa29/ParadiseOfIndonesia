<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function getSnapToken(Booking $booking)
    {
        // Generate Snap Token
        $snapToken = $this->midtransService->createTransaction($booking);
        
        return response()->json([
            'snap_token' => $snapToken,
            'client_key' => config('services.midtrans.client_key')
        ]);
    }

    public function handleNotification(Request $request)
    {
        $notification = $this->midtransService->handleNotification($request->all());
        
        // Find the booking by ID
        $booking = Booking::find($notification->order_id);

        if ($booking) {
            // Update booking status based on the payment status
            $booking->payment_status = $notification->transaction_status;
            $booking->save();
        }
        
        return response()->json(['success' => true]);
    }
}
