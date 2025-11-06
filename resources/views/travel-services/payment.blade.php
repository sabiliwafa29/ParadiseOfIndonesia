@extends('layouts.app')

@section('content')
<div class="py-12 flex justify-center">
    <div class="max-w-2xl w-full bg-white p-6 rounded-lg shadow-md text-center">
        <h2 class="text-2xl font-bold mb-4 text-emerald-700">Payment</h2>
        <p class="text-gray-600 mb-6">Please complete your payment for <strong>{{ $service->name }}</strong>.</p>

        <div class="bg-gray-100 p-4 rounded-md mb-6">
            <p><strong>Order ID:</strong> {{ $orderId }}</p>
            <p><strong>Amount:</strong> Rp {{ number_format($service->price, 0, ',', '.') }}</p>
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
<script type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                console.log(result);
                alert('Payment successful!');
                window.location.href = "{{ route('travel-services.payment.success') }}";
            },
            onPending: function (result) {
                console.log(result);
                alert('Payment pending.');
                window.location.href = "{{ route('travel-services.payment.success') }}";
            },
            onError: function (result) {
                console.error(result);
                alert('Payment failed. Please try again.');
            },
            onClose: function () {
                alert('You closed the payment window without completing the payment.');
            }
        });
    });
</script>
@endsection
