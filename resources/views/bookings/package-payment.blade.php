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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
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
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('messages.package') ?? 'Package' }}</p>
                        <p class="font-semibold text-gray-900">{{ $booking->package->name }}</p>
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
                        <p class="font-semibold text-gray-900 truncate">{{ $booking->email }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-4 border-2 border-emerald-200">
                        <p class="text-xs text-emerald-600 uppercase tracking-wide mb-1 font-semibold">{{ __('messages.total_price') ?? 'Total Price' }}</p>
                        <p class="font-bold text-emerald-600 text-2xl">{{ format_price($booking->total_price) }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Button or Success Message -->
            @if($booking->payment_status !== 'paid')
                @php
                    $currency = \App\Helpers\LanguageHelper::getCurrentCurrency();
                @endphp

                {{-- If currency is IDR -> Midtrans, otherwise show PayPal button (USD/CNY) --}}
                @if($currency === 'IDR' && $snapToken)
                    <button id="pay-button" 
                            class="w-full py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-bold text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        {{ __('messages.pay_now') ?? 'Pay Now' }}
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-3">{{ __('messages.powered_by_midtrans') ?? 'Secure payment powered by Midtrans' }}</p>
                @elseif(in_array($currency, ['USD', 'CNY']))
                    <div id="paypal-button-container" class="w-full"></div>
                    <p class="text-center text-sm text-gray-500 mt-3">{{ __('messages.powered_by_paypal') ?? 'Secure payment powered by PayPal' }}</p>
                @else
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-bold">{{ __('messages.error') ?? 'Error' }}</p>
                                <p>{{ __('messages.payment_error') ?? 'Failed to create payment transaction. Please contact admin.' }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tour-packages.show', $booking->package) }}" 
                       class="inline-block w-full py-3 bg-gray-600 text-white text-center rounded-lg font-semibold hover:bg-gray-700 transition">
                        {{ __('messages.back_to_package') ?? 'Back to Package' }}
                    </a>
                @endif
            @else
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6 mb-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-green-800 font-bold text-lg">{{ __('messages.thank_you') ?? 'Thank you for your payment!' }}</p>
                            <p class="text-green-700 text-sm mt-1">{{ __('messages.confirmation_sent') ?? 'A confirmation email has been sent to' }} <strong>{{ $booking->email }}</strong></p>
                        </div>
                    </div>
                </div>
                
                @auth
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('my-bookings') }}" 
                           class="flex-1 py-3 bg-emerald-600 text-white text-center rounded-lg font-semibold hover:bg-emerald-700 transition shadow-md hover:shadow-lg">
                            {{ __('messages.view_my_bookings') ?? 'View My Bookings' }}
                        </a>
                        <a href="{{ route('bookings.show', $booking) }}" 
                           class="flex-1 py-3 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                            {{ __('messages.view_details') ?? 'View Details' }}
                        </a>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register') }}" 
                           class="flex-1 py-3 bg-emerald-600 text-white text-center rounded-lg font-semibold hover:bg-emerald-700 transition shadow-md hover:shadow-lg">
                            {{ __('messages.register_to_manage') ?? 'Register to Manage' }}
                        </a>
                        <a href="{{ route('tour-packages.index') }}" 
                           class="flex-1 py-3 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                            {{ __('messages.browse_packages') ?? 'Browse More Packages' }}
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
                        @auth
                            {{ __('messages.booking_linked') ?? 'This booking is linked to your account. You can view and manage it from' }} 
                            <a href="{{ route('my-bookings') }}" class="underline font-semibold hover:text-blue-900">{{ __('messages.my_bookings') ?? 'My Bookings' }}</a>.
                        @else
                            {{ __('messages.booking_email') ?? 'This booking is linked to your email' }} <strong>{{ $booking->email }}</strong>. 
                            <a href="{{ route('register') }}" class="underline font-semibold hover:text-blue-900">{{ __('messages.register') ?? 'Register' }}</a> {{ __('messages.with_email') ?? 'with this email to manage your bookings' }}.
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
    // Define initializeMidtrans function BEFORE loading Midtrans script
    window.initializeMidtrans = function() {
        const payButton = document.getElementById('pay-button');

        if (!payButton) {
            return;
        }

        if (typeof snap === 'undefined') {
            return;
        }

        payButton.onclick = function() {
            try {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // Update payment status via API
                        fetch('/api/bookings/{{ $booking->id }}/payment-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(result)
                        })
                        .then(response => response.json())
                        .then(data => {
                            window.location.reload();
                        })
                        .catch(error => {
                            window.location.reload();
                        });
                    },
                    onPending: function(result) {
                        // Update payment status via API
                        fetch('/api/bookings/{{ $booking->id }}/payment-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(result)
                        })
                        .then(response => response.json())
                        .then(data => {
                            window.location.reload();
                        })
                        .catch(error => {
                            window.location.reload();
                        });
                    },
                    onError: function(result) {
                        alert('{{ __("messages.payment_failed") ?? "Payment failed! Please try again." }}');
                    },
                    onClose: function() {
                        // User closed the payment popup
                    }
                });
            } catch (error) {
                alert('Error: ' + error.message);
            }
        };
    };

    // Fallback: Initialize after DOM loaded if onload doesn't trigger
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for Snap to be available
        let attempts = 0;
        const maxAttempts = 10;

        const checkSnap = setInterval(function() {
            attempts++;

            if (typeof snap !== 'undefined') {
                clearInterval(checkSnap);
                window.initializeMidtrans();
            } else if (attempts >= maxAttempts) {
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

    @push('scripts')
    @if(in_array(\App\Helpers\LanguageHelper::getCurrentCurrency(), ['USD','CNY']))
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency={{ \App\Helpers\LanguageHelper::getCurrentCurrency() }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingId = {{ $booking->id }};
            const currency = '{{ \App\Helpers\LanguageHelper::getCurrentCurrency() }}';

            paypal.Buttons({
                createOrder: function(data, actions) {
                    return fetch('/api/paypal/' + bookingId + '/create-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ currency: currency })
                    }).then(function(res) {
                        return res.json();
                    }).then(function(orderData) {
                        if (!orderData || !orderData.id) {
                            throw new Error('Failed to create PayPal order');
                        }
                        return orderData.id;
                    });
                },
                onApprove: function(data, actions) {
                    return fetch('/api/paypal/' + bookingId + '/capture-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ orderID: data.orderID })
                    }).then(function(res) { return res.json(); })
                    .then(function(captureData) {
                        console.log('PayPal capture:', captureData);
                        window.location.reload();
                    }).catch(function(err) {
                        console.error('Capture error', err);
                        alert('Payment failed, please try again.');
                    });
                },
                onError: function(err) {
                    console.error('PayPal error', err);
                    alert('Payment failed, please try again.');
                }
            }).render('#paypal-button-container');
        });
    </script>
    @endif
    @endpush
@endpush
@endif