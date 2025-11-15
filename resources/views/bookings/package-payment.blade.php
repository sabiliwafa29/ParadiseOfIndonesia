@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-2xl font-bold mb-4">{{ __('messages.complete_your_package_booking') }}</h3>
                <p class="mb-2">{{ __('messages.package') }}: <span class="font-semibold">{{ $booking->package->name }}</span></p>
                <p class="mb-2">{{ __('messages.date') }}: <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</span></p>
                <p class="mb-2">{{ __('messages.guests') }}: <span class="font-semibold">{{ $booking->guests }}</span></p>
                <p class="mb-2"><strong>Order ID:</strong> <span class="font-mono text-sm">{{ $booking->order_id }}</span></p>
                <p class="mb-4">{{ __('messages.total_price') }}: <span class="font-bold text-emerald-600 text-xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>

                @if($snapToken)
                    <button id="pay-button" class="w-full py-3 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700 transition">
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
            </div>
        </div>
    </div>
</div>
@endsection

@if($snapToken)
@push('scripts')
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"
        onload="initializeMidtrans()"></script>
<script type="text/javascript">
    console.log('💳 [DEBUG] Payment Page Loaded');
    console.log('🎫 Snap Token:', '{{ $snapToken }}');
    console.log('📦 Booking ID:', {{ $booking->id }});
    console.log('🔢 Order ID:', '{{ $booking->order_id }}');
    console.log('💰 Total Price:', {{ $booking->total_price }});
    console.log('🔑 Midtrans Client Key:', '{{ config("services.midtrans.client_key") }}');
    
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
                        alert("Payment success!"); 
                        window.location.href = "{{ route('my-bookings') }}";
                    },
                    onPending: function(result){
                        console.log('⏳ [DEBUG] Payment PENDING', result);
                        alert("Waiting for your payment!");
                        window.location.href = "{{ route('my-bookings') }}";
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
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📄 [DEBUG] DOM Content Loaded');
            setTimeout(function() {
                if (typeof snap !== 'undefined' && !document.getElementById('pay-button').onclick) {
                    console.log('⚠️ [DEBUG] Fallback initialization');
                    initializeMidtrans();
                }
            }, 1000);
        });
    } else {
        console.log('📄 [DEBUG] DOM already loaded');
        setTimeout(function() {
            if (typeof snap !== 'undefined' && !document.getElementById('pay-button').onclick) {
                console.log('⚠️ [DEBUG] Fallback initialization');
                initializeMidtrans();
            }
        }, 1000);
    }
</script>
@endpush
@endif
