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
                <p class="mb-4">{{ __('messages.total_price') }}: <span class="font-bold text-emerald-600 text-xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>

                <button id="pay-button" class="w-full py-3 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700 transition">
                    {{ __('messages.pay_now_with_midtrans') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                alert("payment success!"); console.log(result);
                window.location.href = "{{ route('my-bookings') }}"; // Redirect to my bookings
            },
            onPending: function(result){
                /* You may add your own implementation here */
                alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!"); console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
        });
    };
</script>
@endpush
