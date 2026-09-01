@extends('layouts.app')

@section('content')
<div class="py-12 flex justify-center">
    <div class="max-w-2xl w-full bg-white p-6 rounded-lg shadow-md text-center">
        <h2 class="text-2xl font-bold mb-4 text-emerald-700">Payment</h2>
        <p class="text-gray-600 mb-6">Please complete your payment for <strong>{{ $service->name }}</strong>.</p>

        <div class="bg-gray-100 p-4 rounded-md mb-6">
            <p><strong>Order ID:</strong> {{ $orderId }}</p>
            <p><strong>Amount:</strong> {{ \App\Helpers\LanguageHelper::formatPrice( \App\Helpers\LanguageHelper::getPrice($service) ) }}</p>
        </div>

        <button id="pay-button" 
            class="bg-emerald-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-emerald-700 transition">
            Pay Now
        </button>

        <p class="mt-4 text-gray-500 text-sm">You’ll be redirected after the payment is complete.</p>
    </div>
</div>

{{-- 🧾 MIDTRANS SNAP JS --}}
@push('scripts')
@php
    $isMidtransProduction = config('services.midtrans.is_production', false);
    $midtransSnapUrl = $isMidtransProduction
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp

<script type="text/javascript"
        src="{{ $midtransSnapUrl }}"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('travel-services.payment.success') }}";
            },
            onPending: function (result) {
                window.location.href = "{{ route('travel-services.payment.success') }}";
            },
            onError: function (result) {
                // Handle error silently; show server-side message on reload if needed
            },
            onClose: function () {
                // User closed the payment window
            }
        });
    });
</script>
@endsection
