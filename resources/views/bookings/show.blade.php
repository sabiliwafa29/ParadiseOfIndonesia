@extends('layouts.app')

@section('content')
<div class="py-12" x-data="{ 
    showRescheduleModal: false, 
    showCancelModal: false,
    rescheduleDate: '{{ $booking->date->format('Y-m-d') }}'
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('my-bookings') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to My Bookings
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-4 md:p-6 lg:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl md:text-2xl lg:text-3xl font-bold">Booking Details</h2>
                    <span class="px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold
                        {{ $booking->status === 'confirmed' || $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $booking->status === 'rescheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left: Tour/Package Info -->
                    <div>
                        @if($booking->tour)
                            <div class="bg-gray-50 rounded-lg overflow-hidden">
                                <img src="{{ asset($booking->tour->image) }}" alt="{{ $booking->tour->name }}" class="w-full h-48 md:h-56 lg:h-64 object-cover">
                                <div class="p-4 md:p-6">
                                    <h3 class="text-lg md:text-xl lg:text-2xl font-semibold mb-2">{{ $booking->tour->name }}</h3>
                                    <p class="text-sm md:text-base text-gray-600 mb-4">{{ $booking->tour->destination->name }}</p>
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm md:text-base text-gray-600">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $booking->tour->duration }} days</span>
                                        </div>
                                        <div class="flex items-center text-sm md:text-base text-gray-600">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $booking->tour->destination->location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($booking->package)
                            <div class="bg-gray-50 rounded-lg overflow-hidden">
                                <img src="{{ asset($booking->package->image) }}" alt="{{ $booking->package->name }}" class="w-full h-64 object-cover">
                                <div class="p-6">
                                    <h3 class="text-2xl font-semibold mb-2">{{ $booking->package->name }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $booking->package->description }}</p>
                                    @if($booking->route_option)
                                        <div class="bg-blue-50 px-3 py-2 rounded-md">
                                            <span class="text-sm font-semibold text-blue-800">Route: {{ ucfirst($booking->route_option) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right: Booking Details -->
                    <div>
                        <div class="bg-gray-50 rounded-lg p-4 md:p-6 space-y-4 md:space-y-6">
                            <div>
                                <h3 class="text-lg md:text-xl font-semibold mb-3 md:mb-4">Booking Information</h3>
                                <div class="space-y-3 md:space-y-4">
                                    <div>
                                        <p class="text-xs md:text-sm text-gray-600">Order ID</p>
                                        <p class="font-mono text-xs md:text-sm">{{ $booking->order_id }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-xs md:text-sm text-gray-600">Travel Date</p>
                                        <p class="font-semibold text-base md:text-lg">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-xs md:text-sm text-gray-600">Number of Guests</p>
                                        <p class="font-semibold text-sm md:text-base">{{ $booking->guests }} {{ $booking->guests > 1 ? 'people' : 'person' }}</p>
                                    </div>

                                    @if($booking->full_name)
                                        <div>
                                            <p class="text-xs md:text-sm text-gray-600">Contact Name</p>
                                            <p class="font-semibold text-sm md:text-base">{{ $booking->full_name }}</p>
                                        </div>
                                    @endif

                                    @if($booking->email)
                                        <div>
                                            <p class="text-xs md:text-sm text-gray-600">Email</p>
                                            <p class="font-semibold text-sm md:text-base">{{ $booking->email }}</p>
                                        </div>
                                    @endif

                                    @if($booking->contact_handle)
                                        <div>
                                            <p class="text-xs md:text-sm text-gray-600">Contact</p>
                                            <p class="font-semibold text-sm md:text-base">{{ $booking->contact_handle }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="border-t pt-3 md:pt-4">
                                        <p class="text-xs md:text-sm text-gray-600">Total Price</p>
                                        <p class="font-bold text-emerald-600 text-xl md:text-2xl">{{ format_price($booking->total_price) }}</p>
                                    </div>

                                    @if($booking->payment_status === 'paid')
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 md:p-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-semibold text-sm md:text-base text-green-800">Payment Complete</p>
                                                    <p class="text-xs md:text-sm text-green-600">{{ $booking->payment_method ?? 'Midtrans' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="border-t pt-4 md:pt-6">
                                @if($booking->payment_status === 'paid' && $booking->status !== 'cancelled')
                                    <!-- Reschedule & Cancel Buttons -->
                                    <div class="space-y-2 md:space-y-3">
                                        <button @click="showRescheduleModal = true" 
                                                class="w-full py-2 md:py-3 text-sm md:text-base bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Reschedule Booking
                                        </button>
                                        
                                        <button @click="showCancelModal = true" 
                                                class="w-full py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Cancel Booking
                                        </button>
                                    </div>
                                @elseif($booking->status === 'pending' && $snapToken)
                                    <!-- Complete Payment Button -->
                                    <button id="pay-button" class="w-full py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                                        Complete Payment
                                    </button>
                                @elseif($booking->status === 'cancelled')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                        <p class="text-red-800 font-semibold">This booking has been cancelled</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reschedule Modal -->
    <div x-show="showRescheduleModal" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
         @click.self="showRescheduleModal = false">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold">Reschedule Booking</h3>
                <button @click="showRescheduleModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('bookings.reschedule', $booking) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Date</label>
                    <input type="text" 
                           value="{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}" 
                           disabled
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Date</label>
                    <input type="date" 
                           name="date" 
                           x-model="rescheduleDate"
                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex space-x-3">
                    <button type="button" 
                            @click="showRescheduleModal = false"
                            class="flex-1 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Confirm Reschedule
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div x-show="showCancelModal" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
         @click.self="showCancelModal = false">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-red-600">Cancel Booking</h3>
                <button @click="showCancelModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <svg class="w-12 h-12 text-red-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <p class="text-center text-red-800 font-semibold">Are you sure you want to cancel this booking?</p>
                    <p class="text-center text-red-600 text-sm mt-2">This action cannot be undone.</p>
                </div>

                <div class="text-sm text-gray-600 space-y-1">
                    <p><strong>Package:</strong> {{ $booking->package->name ?? $booking->tour->name }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                    <p><strong>Total:</strong> {{ format_price($booking->total_price) }}</p>
                </div>
            </div>

            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                @csrf
                <div class="flex space-x-3">
                    <button type="button" 
                            @click="showCancelModal = false"
                            class="flex-1 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                        No, Keep Booking
                    </button>
                    <button type="submit"
                            class="flex-1 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Yes, Cancel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($booking->status === 'pending' && $snapToken)
@push('scripts')
<script type="text/javascript"
        src="https://app.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.querySelector('#pay-button');
    if (payButton) {
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Payment success!");
                    window.location.href = "{{ route('my-bookings') }}";
                },
                onPending: function(result){
                    alert("Waiting for your payment!");
                },
                onError: function(result){
                    alert("Payment failed!");
                },
                onClose: function(){
                    alert('You closed the popup without finishing the payment');
                }
            });
        });
    }
</script>
@endpush
@endif

<style>
    [x-cloak] { display: none !important; }
</style>

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection
