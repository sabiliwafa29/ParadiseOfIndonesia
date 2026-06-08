<?php

// Quick script to check booking status
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$orderId = 'BOOK-20251116135243-QYVV4D';

$booking = \App\Models\Booking::where('order_id', $orderId)->first();

if ($booking) {
    echo "✅ Booking Found!\n";
    echo "ID: {$booking->id}\n";
    echo "Order ID: {$booking->order_id}\n";
    echo "Payment Status: {$booking->payment_status}\n";
    echo "Status: {$booking->status}\n";
    echo "Payment ID: {$booking->payment_id}\n";
    echo "Payment Method: " . ($booking->payment_method ?? 'NULL') . "\n";
    echo "Total Price: {$booking->total_price}\n";
    echo "Created: {$booking->created_at}\n";
    echo "Updated: {$booking->updated_at}\n";
} else {
    echo "❌ Booking NOT found with order_id: {$orderId}\n";
}
