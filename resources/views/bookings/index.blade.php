@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">My Bookings</h2>

                @if($bookings->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-alt text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">You haven't made any bookings yet.</p>
                        <a href="{{ route('tours.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">
                            Browse Tours
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($bookings as $booking)
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $booking->tour->name }}</h3>
                                        <p class="text-gray-600">{{ $booking->tour->destination->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 rounded-full text-sm 
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
                                </div>

                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                                    <div>
                                        <span class="text-gray-500 text-sm">Date</span>
                                        <p class="font-medium">{{ $booking->date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Guests</span>
                                        <p class="font-medium">{{ $booking->guests }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Total Price</span>
                                        <p class="font-medium">${{ number_format($booking->total_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Payment Method</span>
                                        <p class="font-medium">{{ $booking->payment_method ?? 'Not paid' }}</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('bookings.show', $booking) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                                        View Details
                                        <i class="fas fa-chevron-right ml-1 text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection