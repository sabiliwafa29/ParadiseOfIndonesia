<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function getSnapToken($orderId)
    {
        // Get order details from WooCommerce
        $order = $this->getOrderDetails($orderId);
        
        // Generate Snap Token
        $snapToken = $this->midtransService->createTransaction($order);
        
        return response()->json([
            'snap_token' => $snapToken,
            'client_key' => config('services.midtrans.client_key')
        ]);
    }

    public function handleNotification(Request $request)
    {
        $notification = $this->midtransService->handleNotification($request->all());
        
        // Update order status in WooCommerce based on the payment status
        $this->updateOrderStatus($notification);
        
        return response()->json(['success' => true]);
    }

    private function getOrderDetails($orderId)
    {
        // Implement WooCommerce order fetching logic here
        // You'll need to inject WooCommerceService and use it to get order details
    }

    private function updateOrderStatus($notification)
    {
        // Implement WooCommerce order status update logic here
        // You'll need to inject WooCommerceService and use it to update order status
    }
}