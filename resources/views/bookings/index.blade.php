@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
        <div class="text-center">
            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">
                <span class="text-white font-medium text-sm md:text-base">📅 {{ __('messages.my_bookings') }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.my_bookings') }}</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('Manage your travel bookings and reservations') }}</p>
        </div>
    </div>
</div>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($bookings->isEmpty())
            <div class="text-center py-12">
                <div class="inline-block p-8 bg-white rounded-3xl shadow-xl">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg md:text-xl text-gray-600 mb-6">{{ __('messages.no_bookings_yet') }}</p>
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                        {{ __('messages.browse_tours') }}
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="group bg-white rounded-3xl shadow-xl p-4 md:p-6 hover:shadow-2xl transition-all duration-500">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
                            <div class="mb-3 sm:mb-0">
                                @if($booking->package)
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ $booking->package->name }}</h3>
                                    <p class="text-sm md:text-base text-gray-600">{{ __('messages.package_booking') }}</p>
                                @else
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ $booking->tour->name }}</h3>
                                    <p class="text-sm md:text-base text-gray-600">{{ $booking->tour->destination->name }}</p>
                                @endif
                            </div>
                            <div>
                                <span class="inline-block px-4 py-2 rounded-full text-xs md:text-sm font-semibold
                                    @if($booking->status === 'confirmed' || $booking->payment_status === 'paid')
                                        bg-green-100 text-green-800
                                    @elseif($booking->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'rescheduled')
                                        bg-blue-100 text-blue-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4 pb-4 border-b border-gray-100">
                            <div>
                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.date') }}</span>
                                <p class="text-sm md:text-base font-semibold text-gray-900">{{ $booking->date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.guests') }}</span>
                                <p class="text-sm md:text-base font-semibold text-gray-900">{{ $booking->guests }}</p>
                            </div>
                            <div>
                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.total_price') }}</span>
                                <p class="text-sm md:text-base font-bold text-emerald-600">{{ format_price_by_currency($booking->total_price, $booking->currency ?? current_currency()) }}</p>
                            </div>
                            <div>
                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.payment_method') }}</span>
                                <p class="text-sm md:text-base font-semibold text-gray-900">{{ $booking->payment_method ?? __('messages.not_paid') }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                                <span class="text-sm md:text-base">{{ __('messages.view_details') }}</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            @if($booking->status === 'pending' && $booking->payment_status !== 'paid')
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to cancel this pending booking?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-100 text-red-700 font-semibold rounded-full hover:bg-red-200 transition-all duration-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-sm md:text-base">{{ __('messages.cancel') ?? 'Cancel' }}</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
