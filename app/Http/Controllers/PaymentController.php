<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelServiceBooking;
use App\Models\Booking as BookingModel;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function getSnapToken(Booking $booking)
    {
        try {
            $booking->load('user', 'tour');

            $snapToken = $this->midtransService->createTransaction($booking);

            if (!$snapToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create Snap Token',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'client_key' => config('services.midtrans.client_key'),
            ]);
        } catch (\Throwable $th) {
            Log::error('Midtrans Error: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            Log::info('Midtrans Notification Received', $request->all());

            $notif = $this->midtransService->handleNotification($request);
            $orderId = $notif['order_id'];
            $transactionStatus = $notif['transaction_status'];

            $booking = $this->findBookingByOrderId($orderId);

            if (!$booking) {
                Log::warning("Booking not found for Order ID: {$orderId}");

                return response()->json([
                    'success' => true,
                    'message' => 'Notification received but booking not found',
                    'order_id' => $orderId,
                ], 200);
            }

            $this->updateBookingStatus($booking, $notif);

            return response()->json(['success' => true, 'message' => 'Notification processed']);
        } catch (\Throwable $th) {
            Log::error('Midtrans Notification Error: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to process notification',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    protected function findBookingByOrderId(string $orderId): ?BookingModel
    {
        $booking = BookingModel::where('order_id', $orderId)->first();

        if (!$booking) {
            $booking = TravelServiceBooking::where('order_id', $orderId)->first();
        }

        if (!$booking && str_starts_with($orderId, 'BOOK-')) {
            $bookingId = (int) str_replace('BOOK-', '', $orderId);
            $booking = BookingModel::find($bookingId);
        }

        return $booking;
    }

    protected function updateBookingStatus($booking, array $notif): void
    {
        $transactionStatus = $notif['transaction_status'];
        $paymentType = $notif['payment_type'] ?? null;
        $transactionId = $notif['transaction_id'] ?? null;
        $fraudStatus = $notif['fraud_status'] ?? 'accept';

        $bookingType = $booking instanceof TravelServiceBooking ? 'TravelServiceBooking' : 'Booking';
        $bookingId = $booking->id;

        $updateData = $this->buildUpdateData($transactionStatus, $fraudStatus, $paymentType, $transactionId);

        $booking->update($updateData);
        Log::info("{$bookingType} {$bookingId} updated: {$transactionStatus}");
    }

    protected function buildUpdateData(string $transactionStatus, string $fraudStatus, ?string $paymentType, ?string $transactionId): array
    {
        return match($transactionStatus) {
            'capture' => [
                'payment_status' => $fraudStatus === 'accept' ? 'paid' : 'pending',
                'status' => $fraudStatus === 'accept' ? 'confirmed' : 'pending',
                'payment_id' => $transactionId,
                'payment_method' => $paymentType,
            ],
            'settlement' => [
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'payment_id' => $transactionId,
                'payment_method' => $paymentType,
            ],
            'pending' => [
                'payment_status' => 'pending',
                'payment_id' => $transactionId,
                'payment_method' => $paymentType,
            ],
            'deny', 'expire', 'cancel' => [
                'payment_status' => 'failed',
                'status' => 'cancelled',
                'payment_id' => $transactionId,
                'payment_method' => $paymentType,
            ],
            default => [],
        };
    }
}