@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Booking Details</h2>
                    <a href="{{ route('my-bookings') }}" class="text-emerald-600 hover:text-emerald-700">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Bookings
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Tour Information -->
                    <div>
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <img src="{{ asset($booking->tour->image) }}" alt="{{ $booking->tour->name }}" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold">{{ $booking->tour->name }}</h3>
                                <p class="text-gray-600">{{ $booking->tour->destination->name }}</p>
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-clock w-6"></i>
                                        <span>{{ $booking->tour->duration }} days</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker-alt w-6"></i>
                                        <span>{{ $booking->tour->destination->location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Information -->
                    <div>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Booking Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-gray-500">Status</span>
                                    <span class="ml-2 px-3 py-1 rounded-full text-sm 
                                        @if($booking->status === 'confirmed')
                                            bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending')
                                            bg-yellow-100 text-yellow-800
                                        @else
                                            bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500">Booking Date</span>
                                    <p class="font-medium">{{ $booking->date->format('F d, Y') }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500">Number of Guests</span>
                                    <p class="font-medium">{{ $booking->guests }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500">Total Price</span>
                                    <p class="font-medium">${{ number_format($booking->total_price, 2) }}</p>
                                </div>

                                @if($booking->payment_method)
                                <div>
                                    <span class="text-gray-500">Payment Method</span>
                                    <p class="font-medium">{{ $booking->payment_method }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500">Payment Status</span>
                                    <p class="font-medium">{{ ucfirst($booking->payment_status) }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-500">Payment ID</span>
                                    <p class="font-medium">{{ $booking->payment_id }}</p>
                                </div>
                                @endif
                            </div>

                            @if($booking->status === 'pending')
                            <div class="mt-6">
                                <button id="pay-button" class="w-full bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">
                                    Complete Payment
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($booking->status === 'pending')
@push('scripts')
<script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.querySelector('#pay-button');

    if (payButton) {
        payButton.addEventListener('click', function(e) {
            // Untuk saat ini, kita tidak memiliki snapToken di sini.
            // Jika Anda ingin mengaktifkan pembayaran dari halaman ini,
            // Anda perlu mengambil snapToken dari backend melalui AJAX
            // atau meneruskannya dari controller jika booking masih pending.
            alert('Fitur pembayaran dari halaman ini belum diimplementasikan. Silakan lakukan pembayaran dari halaman konfirmasi awal.');
        });
    }
</script>
@endpush
@endif
@endsection
