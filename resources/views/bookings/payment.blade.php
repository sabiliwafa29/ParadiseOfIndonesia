@extends('layouts.app')

@section('content')
<div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Info Message if Duplicate Detected -->
        @if(session('info'))
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 px-6 py-4 rounded-lg mb-6 shadow-md" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('info') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Payment Status Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-10 mb-6">
            <!-- Status Icon & Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full mb-6 shadow-lg
                    {{ $booking->payment_status === 'paid' ? 'bg-gradient-to-br from-green-400 to-green-600' : 'bg-gradient-to-br from-yellow-400 to-orange-500' }}">
                    @if($booking->payment_status === 'paid')
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                
                <h2 class="text-3xl sm:text-4xl font-bold mb-3
                    {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-orange-600' }}">
                    {{ $booking->payment_status === 'paid' ? __('messages.payment_complete') ?? 'Payment Complete' : __('messages.payment_pending') ?? 'Payment Pending' }}
                </h2>
                
                <p class="text-gray-600 text-base sm:text-lg">
                    {{ $booking->payment_status === 'paid' 
                        ? __('messages.payment_complete_desc') ?? 'Your booking has been confirmed!' 
                        : __('messages.payment_pending_desc') ?? 'Please complete your payment to confirm booking' }}
                </p>
            </div>

            <!-- Booking Details -->
            <div class="border-t border-b border-gray-200 py-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.booking_details') ?? 'Booking Details' }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('messages.tour') ?? 'Tour' }}</p>
                        <p class="font-semibold text-gray-900">{{ $booking->tour ? $booking->tour->name : 'Tour Not Found' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('messages.order_id') ?? 'Order ID' }}</p>
                        <p class="font-mono text-sm text-gray-900">{{ $booking->order_id }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('messages.date') ?? 'Date' }}</p>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('messages.guests') ?? 'Guests' }}</p>
                        <p class="font-semibold text-gray-900">{{ $booking->guests }} {{ $booking->guests > 1 ? __('messages.people') ?? 'people' : __('messages.person') ?? 'person' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('messages.contact') ?? 'Contact' }}</p>
                        <p class="font-semibold text-gray-900 truncate">{{ $booking->email ?? ($booking->user ? $booking->user->email : 'N/A') }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-4 border-2 border-emerald-200">
                        <p class="text-xs text-emerald-600 uppercase tracking-wide mb-1 font-semibold">{{ __('messages.total_price') ?? 'Total Price' }}</p>
                        <p class="font-bold text-emerald-600 text-2xl">{{ format_price($booking->total_price) }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Button or Success Message -->
            @if($booking->payment_status !== 'paid')
                @if(isset($snapToken) && $snapToken)
                    <button id="pay-button" 
                            class="w-full py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-bold text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        {{ __('messages.pay_now') ?? 'Pay Now' }}
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-3">{{ __('messages.powered_by_midtrans') ?? 'Secure payment powered by Midtrans' }}</p>
                @else
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-bold mb-1">{{ __('messages.payment_token_error') ?? 'Payment Token Not Available' }}</p>
                                <p class="text-sm">{{ __('messages.payment_token_error_desc') ?? 'There was an error generating the payment token. Please try booking again.' }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tours.show', $booking->tour) }}" 
                       class="w-full inline-flex items-center justify-center py-4 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-bold text-lg hover:from-gray-700 hover:to-gray-800 transition-all shadow-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('messages.back_to_tour') ?? 'Back to Tour' }}
                    </a>
                @endif
            @else
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6 mb-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-bold text-green-800 mb-1">{{ __('messages.payment_successful') ?? 'Payment Successful!' }}</p>
                            <p class="text-green-700 text-sm">{{ __('messages.payment_successful_desc') ?? 'Your payment has been processed successfully. Thank you for booking with us!' }}</p>
                        </div>
                    </div>
                </div>
                
                @auth
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('my-bookings') }}" 
                           class="flex-1 inline-flex items-center justify-center py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-bold text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('messages.view_my_bookings') ?? 'View My Bookings' }}
                        </a>
                        <a href="{{ route('tours.index') }}" 
                           class="flex-1 inline-flex items-center justify-center py-4 border-2 border-gray-300 text-gray-700 rounded-xl font-bold text-lg hover:bg-gray-50 transition-all">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.browse_more_tours') ?? 'Browse More Tours' }}
                        </a>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('home') }}" 
                           class="flex-1 inline-flex items-center justify-center py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-bold text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ __('messages.back_to_home') ?? 'Back to Home' }}
                        </a>
                        <a href="{{ route('tours.index') }}" 
                           class="flex-1 inline-flex items-center justify-center py-4 border-2 border-gray-300 text-gray-700 rounded-xl font-bold text-lg hover:bg-gray-50 transition-all">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.browse_more_tours') ?? 'Browse More Tours' }}
                        </a>
                    </div>
                @endauth
            @endif
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6 shadow-md">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-blue-900 font-bold mb-1">{{ __('messages.important_info') ?? 'Important Information' }}</p>
                    <p class="text-blue-800 text-sm leading-relaxed">
                        {{ __('messages.payment_info_desc') ?? 'After successful payment, you will receive a confirmation email with your booking details. Please keep your order ID for reference. If you have any questions, feel free to contact our support team.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if(isset($snapToken) && $snapToken)
@push('scripts')
<script type="text/javascript">
    // Define initializeMidtrans function BEFORE loading Midtrans script
    window.initializeMidtrans = function() {
        console.log('Initializing Midtrans...');
        
        const payButton = document.getElementById('pay-button');
        
        if (!payButton) {
            console.error('Pay button not found');
            return;
        }
        
        if (typeof snap === 'undefined') {
            console.error('Snap is undefined');
            return;
        }
        
        console.log('Midtrans initialized successfully');
        
        payButton.onclick = function() {
            console.log('Pay button clicked');
            
            try {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        alert('{{ __("messages.payment_success") ?? "Payment successful! Thank you for your booking." }}');
                        window.location.href = "{{ route('my-bookings') }}";
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        alert('{{ __("messages.payment_pending") ?? "Waiting for your payment!" }}');
                    },
                    onError: function(result) {
                        console.error('Payment error:', result);
                        alert('{{ __("messages.payment_failed") ?? "Payment failed! Please try again." }}');
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                        alert('{{ __("messages.payment_closed") ?? "You closed the payment popup. Please complete your payment to confirm your booking." }}');
                    }
                });
                
            } catch (error) {
                console.error('Error calling snap.pay():', error);
                alert('Error: ' + error.message);
            }
        };
    };
    
    // Fallback: Initialize after DOM loaded if onload doesn't trigger
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        
        // Wait for Snap to be available
        let attempts = 0;
        const maxAttempts = 10;
        
        const checkSnap = setInterval(function() {
            attempts++;
            
            if (typeof snap !== 'undefined') {
                console.log('Snap found, initializing...');
                clearInterval(checkSnap);
                window.initializeMidtrans();
            } else if (attempts >= maxAttempts) {
                console.error('Snap not found after', maxAttempts, 'attempts');
                clearInterval(checkSnap);
            }
        }, 500);
    });
</script>

<!-- Load Midtrans Snap.js -->
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"
        onload="window.initializeMidtrans()"></script>
@endpush
@endif