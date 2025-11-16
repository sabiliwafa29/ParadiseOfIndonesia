<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingStatusController extends Controller
{
    /**
     * Update booking status after payment (called from frontend)
     */
    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        try {
            Log::info('📥 Frontend callback received', [
                'booking_id' => $booking->id,
                'order_id' => $booking->order_id,
                'result' => $request->all(),
            ]);

            // Validasi order_id cocok
            if ($request->order_id !== $booking->order_id) {
                Log::warning('⚠️ Order ID mismatch', [
                    'expected' => $booking->order_id,
                    'received' => $request->order_id,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID tidak cocok'
                ], 400);
            }

            // Update status berdasarkan transaction_status dari Midtrans
            $transactionStatus = $request->transaction_status;
            
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    $booking->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'payment_method' => $request->payment_type ?? 'Midtrans',
                        'payment_id' => $request->transaction_id ?? $booking->order_id,
                    ]);
                    Log::info('✅ Booking confirmed', ['booking_id' => $booking->id]);
                    break;

                case 'pending':
                    $booking->update([
                        'payment_status' => 'pending',
                        'payment_id' => $request->transaction_id ?? $booking->order_id,
                    ]);
                    Log::info('⏳ Payment pending', ['booking_id' => $booking->id]);
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $booking->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                        'payment_id' => $request->transaction_id ?? $booking->order_id,
                    ]);
                    Log::info('❌ Payment failed/cancelled', ['booking_id' => $booking->id]);
                    break;

                default:
                    Log::warning('Unknown transaction status', [
                        'status' => $transactionStatus,
                        'booking_id' => $booking->id,
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'booking' => [
                    'id' => $booking->id,
                    'payment_status' => $booking->payment_status,
                    'status' => $booking->status,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error updating payment status', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: ' . $e->getMessage()
            ], 500);
        }
    }
}
