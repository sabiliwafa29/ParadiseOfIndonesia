<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class BookingStatusController extends Controller
{
    /**
     * Update booking status after payment (called from frontend)
     */
    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        try {
            Log::info('📥 [PAYMENT CALLBACK] Frontend callback received', [
                'booking_id' => $booking->id,
                'order_id' => $booking->order_id,
                'current_payment_status' => $booking->payment_status,
                'current_status' => $booking->status,
                'request_data' => $request->all(),
            ]);

            // Validasi order_id cocok
            $requestOrderId = $request->order_id ?? $request->input('order_id');
            
            Log::info('🔍 [PAYMENT CALLBACK] Validating order_id', [
                'booking_order_id' => $booking->order_id,
                'request_order_id' => $requestOrderId,
            ]);
            
            if ($requestOrderId && $requestOrderId !== $booking->order_id) {
                Log::warning('⚠️ [PAYMENT CALLBACK] Order ID mismatch', [
                    'expected' => $booking->order_id,
                    'received' => $requestOrderId,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID tidak cocok'
                ], 400);
            }

            // Update status berdasarkan transaction_status dari Midtrans
            $transactionStatus = $request->transaction_status ?? $request->input('transaction_status');
            $paymentType = $request->payment_type ?? $request->input('payment_type');
            $transactionId = $request->transaction_id ?? $request->input('transaction_id');
            
            Log::info('💳 [PAYMENT CALLBACK] Processing transaction', [
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId,
            ]);
            
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    Log::info('✅ [PAYMENT CALLBACK] Payment successful, updating to confirmed');
                    
                    $updateData = [
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'payment_id' => $transactionId ?? $booking->order_id,
                    ];
                    
                    // Only add payment_method if column exists
                    if (Schema::hasColumn('bookings', 'payment_method')) {
                        $updateData['payment_method'] = $paymentType ?? 'Midtrans';
                    }
                    
                    $booking->update($updateData);
                    
                    Log::info('✅ [PAYMENT CALLBACK] Booking confirmed', [
                        'booking_id' => $booking->id,
                        'new_payment_status' => $booking->fresh()->payment_status,
                        'new_status' => $booking->fresh()->status,
                    ]);
                    break;

                case 'pending':
                    Log::info('⏳ [PAYMENT CALLBACK] Payment pending');
                    $booking->update([
                        'payment_status' => 'pending',
                        'payment_id' => $transactionId ?? $booking->order_id,
                    ]);
                    Log::info('⏳ [PAYMENT CALLBACK] Payment pending recorded', ['booking_id' => $booking->id]);
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    Log::info('❌ [PAYMENT CALLBACK] Payment failed/cancelled');
                    $booking->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                        'payment_id' => $transactionId ?? $booking->order_id,
                    ]);
                    Log::info('❌ [PAYMENT CALLBACK] Payment failed/cancelled recorded', ['booking_id' => $booking->id]);
                    break;

                default:
                    Log::warning('⚠️ [PAYMENT CALLBACK] Unknown transaction status', [
                        'status' => $transactionStatus,
                        'booking_id' => $booking->id,
                    ]);
            }

            // Refresh booking untuk ambil data terbaru
            $booking = $booking->fresh();
            
            Log::info('📤 [PAYMENT CALLBACK] Sending response', [
                'booking_id' => $booking->id,
                'payment_status' => $booking->payment_status,
                'status' => $booking->status,
            ]);

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
            Log::error('❌ [PAYMENT CALLBACK] Error updating payment status', [
                'booking_id' => $booking->id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: ' . $e->getMessage(),
                'error_details' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            ], 500);
        }
    }
}
