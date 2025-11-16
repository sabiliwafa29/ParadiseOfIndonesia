@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Payment Status Card (Large, Center) -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full mb-4
                    {{ $booking->payment_status === 'paid' ? 'bg-green-100' : 'bg-yellow-100' }}">
                    @if($booking->payment_status === 'paid')
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                
                <h2 class="text-3xl font-bold mb-2
                    {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $booking->payment_status === 'paid' ? 'Payment Complete' : 'Payment Pending' }}
                </h2>
                
                <p class="text-gray-600 text-lg">
                    {{ $booking->payment_status === 'paid' 
                        ? 'Your booking has been confirmed!' 
                        : 'Please complete your payment to confirm booking' }}
                </p>
            </div>

            <!-- Booking Details -->
            <div class="border-t border-b border-gray-200 py-6 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Package</p>
                        <p class="font-semibold">{{ $booking->package->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Order ID</p>
                        <p class="font-mono text-sm">{{ $booking->order_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Guests</p>
                        <p class="font-semibold">{{ $booking->guests }} {{ $booking->guests > 1 ? 'people' : 'person' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact</p>
                        <p class="font-semibold">{{ $booking->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Price</p>
                        <p class="font-bold text-emerald-600 text-xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Button or Success Message -->
            @if($booking->payment_status !== 'paid')
                @if($snapToken)
                    <button id="pay-button" class="w-full py-4 bg-emerald-600 text-white rounded-lg font-semibold text-lg hover:bg-emerald-700 transition shadow-lg">
                        {{ __('messages.pay_now_with_midtrans') }}
                    </button>
                @else
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <p class="font-bold">Error</p>
                        <p>Gagal membuat transaksi pembayaran. Silakan hubungi admin.</p>
                    </div>
                    <a href="{{ route('tour-packages.show', $booking->package) }}" class="inline-block w-full py-3 bg-gray-600 text-white text-center rounded-md font-semibold hover:bg-gray-700 transition">
                        Kembali ke Package
                    </a>
                @endif
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <p class="text-green-800 font-semibold text-center">Thank you for your payment!</p>
                    <p class="text-green-600 text-sm mt-1 text-center">A confirmation email has been sent to {{ $booking->email }}</p>
                </div>
                
                @auth
                    <div class="flex gap-3">
                        <a href="{{ route('my-bookings') }}" class="flex-1 py-3 bg-emerald-600 text-white text-center rounded-lg font-semibold hover:bg-emerald-700 transition">
                            View My Bookings
                        </a>
                        <a href="{{ route('bookings.show', $booking) }}" class="flex-1 py-3 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                @else
                    <div class="flex gap-3">
                        <a href="{{ route('register') }}" class="flex-1 py-3 bg-emerald-600 text-white text-center rounded-lg font-semibold hover:bg-emerald-700 transition">
                            Register to Manage
                        </a>
                        <a href="{{ route('tour-packages.index') }}" class="flex-1 py-3 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition">
                            Browse More Packages
                        </a>
                    </div>
                @endauth
            @endif
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-blue-800 font-semibold mb-1">Important Information</p>
                    <p class="text-blue-700 text-sm">
                        @auth
                            This booking is linked to your account. You can view and manage it from <a href="{{ route('my-bookings') }}" class="underline font-semibold">My Bookings</a>.
                        @else
                            This booking is linked to your email <strong>{{ $booking->email }}</strong>. 
                            <a href="{{ route('register') }}" class="underline font-semibold">Register</a> with this email to manage your bookings.
                        @endauth
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($snapToken)
@push('scripts')
<script type="text/javascript">
    console.log('💳 [DEBUG] Payment Page Loaded');
    console.log('🎫 Snap Token:', '{{ $snapToken }}');
    console.log('📦 Booking ID:', {{ $booking->id }});
    console.log('🔢 Order ID:', '{{ $booking->order_id }}');
    console.log('💰 Total Price:', {{ $booking->total_price }});
    console.log('🔑 Midtrans Client Key:', '{{ config("services.midtrans.client_key") }}');
    
    // Define function BEFORE loading Midtrans script
    function initializeMidtrans() {
        console.log('✅ [DEBUG] Midtrans Snap library loaded successfully');
        
        const payButton = document.getElementById('pay-button');
        
        if (!payButton) {
            console.error('❌ [DEBUG] Pay button not found!');
            return;
        }
        
        if (typeof snap === 'undefined') {
            console.error('❌ [DEBUG] Snap is still undefined after load!');
            return;
        }
        
        payButton.onclick = function(){
            console.log('🖱️ [DEBUG] Pay button clicked');
            console.log('⏳ [DEBUG] Initiating Midtrans payment...');
            
            try {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        console.log('✅ [DEBUG] Payment SUCCESS!', result);
                        console.log('📤 [DEBUG] Sending payment status to server...');
                        console.log('🔗 [DEBUG] URL:', '/api/bookings/{{ $booking->id }}/payment-status');
                        console.log('📦 [DEBUG] Payload:', JSON.stringify(result, null, 2));
                        
                        // Update status via API
                        fetch('/api/bookings/{{ $booking->id }}/payment-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(result)
                        })
                        .then(response => {
                            console.log('📥 [DEBUG] Response status:', response.status);
                            console.log('📥 [DEBUG] Response headers:', response.headers);
                            return response.json().then(data => ({
                                status: response.status,
                                ok: response.ok,
                                data: data
                            }));
                        })
                        .then(({status, ok, data}) => {
                            console.log('✅ [DEBUG] Response received:', {status, ok, data});
                            
                            if (ok) {
                                console.log('✅ [DEBUG] Status updated successfully!');
                                alert("Payment success! Your booking has been confirmed.");
                            } else {
                                console.error('❌ [DEBUG] Server returned error:', data);
                                alert("Payment success, but status update failed. Please contact support. Error: " + (data.message || 'Unknown error'));
                            }
                            
                            console.log('🔄 [DEBUG] Reloading page...');
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('❌ [DEBUG] Error updating status:', error);
                            console.error('❌ [DEBUG] Error details:', {
                                name: error.name,
                                message: error.message,
                                stack: error.stack
                            });
                            alert("Payment success! Please refresh the page. (Error: " + error.message + ")");
                            window.location.reload();
                        });
                    },
                    onPending: function(result){
                        console.log('⏳ [DEBUG] Payment PENDING', result);
                        console.log('📤 [DEBUG] Sending pending status to server...');
                        
                        // Update status via API
                        fetch('/api/bookings/{{ $booking->id }}/payment-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(result)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('✅ [DEBUG] Pending status updated:', data);
                            alert("Payment is being processed. Please check your booking status.");
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('❌ [DEBUG] Error updating pending status:', error);
                            alert("Payment is being processed. Please refresh the page.");
                            window.location.reload();
                        });
                    },
                    onError: function(result){
                        console.error('❌ [DEBUG] Payment ERROR', result);
                        alert("Payment failed! Please try again.");
                    },
                    onClose: function(){
                        console.log('🚪 [DEBUG] Payment popup CLOSED by user');
                        alert('You closed the payment window without completing the payment');
                    }
                });
                console.log('✅ [DEBUG] Midtrans snap.pay() called successfully');
            } catch (error) {
                console.error('❌ [DEBUG] Error calling snap.pay():', error);
                alert('Error: ' + error.message);
            }
        };
        
        console.log('✅ [DEBUG] Payment button handler initialized');
    }
    
    // Fallback: Initialize after DOM loaded jika onload tidak trigger
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📄 [DEBUG] DOM Content Loaded');
        setTimeout(function() {
            if (typeof snap !== 'undefined') {
                console.log('⚠️ [DEBUG] Fallback initialization');
                initializeMidtrans();
            } else {
                console.log('⏳ [DEBUG] Waiting for Snap library...');
            }
        }, 1000);
    });
</script>
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"
        onload="initializeMidtrans()"></script>
@endpush
@endif
