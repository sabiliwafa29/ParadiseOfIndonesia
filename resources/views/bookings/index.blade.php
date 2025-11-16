@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="py-12">

<div class="bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 relative overflow-hidden">    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">            <div class="p-6">

        <div class="text-center">                <h2 class="text-2xl font-bold mb-6">{{ __('messages.my_bookings') }}</h2>

            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">

                <span class="text-white font-medium text-sm md:text-base">📅 {{ __('messages.my_bookings') }}</span>                @if($bookings->isEmpty())

            </div>                    <div class="text-center py-8">

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.my_bookings') }}</h1>                        <i class="fas fa-calendar-alt text-4xl text-gray-400 mb-4"></i>

            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('Manage your travel bookings and reservations') }}</p>                        <p class="text-gray-500">{{ __('messages.no_bookings_yet') }}</p>

        </div>                        <a href="{{ route('tours.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">

    </div>                            {{ __('messages.browse_tours') }}

</div>                        </a>

                    </div>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">                @else

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                    <div class="space-y-6">

        @if($bookings->isEmpty())                        @foreach($bookings as $booking)

            <div class="text-center py-12">                            <div class="bg-gray-50 p-6 rounded-lg">

                <div class="inline-block p-8 bg-white rounded-3xl shadow-xl">                                <div class="flex items-center justify-between">

                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">                                    <div>

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>                                        @if($booking->package)

                    </svg>                                            <h3 class="text-lg font-semibold">{{ $booking->package->name }}</h3>

                    <p class="text-lg md:text-xl text-gray-600 mb-6">{{ __('messages.no_bookings_yet') }}</p>                                            <p class="text-gray-600">{{ __('messages.package_booking') }}</p>

                    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">                                        @else

                        {{ __('messages.browse_tours') }}                                            <h3 class="text-lg font-semibold">{{ $booking->tour->name }}</h3>

                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">                                            <p class="text-gray-600">{{ $booking->tour->destination->name }}</p>

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>                                        @endif

                        </svg>                                    </div>

                    </a>                                    <div class="text-right">

                </div>                                        <span class="px-3 py-1 rounded-full text-sm 

            </div>                                            @if($booking->status === 'confirmed')

        @else                                                bg-green-100 text-green-800

            <div class="space-y-6">                                            @elseif($booking->status === 'pending')

                @foreach($bookings as $booking)                                                bg-yellow-100 text-yellow-800

                    <div class="group bg-white rounded-3xl shadow-xl p-4 md:p-6 hover:shadow-2xl transition-all duration-500">                                            @else

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">                                                bg-red-100 text-red-800

                            <div class="mb-3 sm:mb-0">                                            @endif

                                @if($booking->package)                                        ">

                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ $booking->package->name }}</h3>                                            {{ __('messages.' . $booking->status) }}

                                    <p class="text-sm md:text-base text-gray-600">{{ __('messages.package_booking') }}</p>                                        </span>

                                @else                                    </div>

                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ $booking->tour->name }}</h3>                                </div>

                                    <p class="text-sm md:text-base text-gray-600">{{ $booking->tour->destination->name }}</p>

                                @endif                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">

                            </div>                                    <div>

                            <div>                                        <span class="text-gray-500 text-sm">{{ __('messages.date') }}</span>

                                <span class="inline-block px-4 py-2 rounded-full text-xs md:text-sm font-semibold                                        <p class="font-medium">{{ $booking->date->format('M d, Y') }}</p>

                                    @if($booking->status === 'confirmed' || $booking->payment_status === 'paid')                                    </div>

                                        bg-green-100 text-green-800                                    <div>

                                    @elseif($booking->status === 'pending')                                        <span class="text-gray-500 text-sm">{{ __('messages.guests') }}</span>

                                        bg-yellow-100 text-yellow-800                                        <p class="font-medium">{{ $booking->guests }}</p>

                                    @elseif($booking->status === 'rescheduled')                                    </div>

                                        bg-blue-100 text-blue-800                                    <div>

                                    @else                                        <span class="text-gray-500 text-sm">{{ __('messages.total_price') }}</span>

                                        bg-red-100 text-red-800                                        <p class="font-medium">{{ format_price($booking->total_price) }}</p>

                                    @endif                                    </div>

                                ">                                    <div>

                                    {{ ucfirst($booking->status) }}                                        <span class="text-gray-500 text-sm">{{ __('messages.payment_method') }}</span>

                                </span>                                        <p class="font-medium">{{ $booking->payment_method ?? __('messages.not_paid') }}</p>

                            </div>                                    </div>

                        </div>                                </div>



                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4 pb-4 border-b border-gray-100">                                <div class="mt-4">

                            <div>                                    <a href="{{ route('bookings.show', $booking) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">

                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.date') }}</span>                                        {{ __('messages.view_details') }}

                                <p class="text-sm md:text-base font-semibold text-gray-900">{{ $booking->date->format('M d, Y') }}</p>                                        <i class="fas fa-chevron-right ml-1 text-sm"></i>

                            </div>                                    </a>

                            <div>                                    

                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.guests') }}</span>                                    @if($booking->status === 'pending' && $booking->payment_status !== 'paid')

                                <p class="text-sm md:text-base font-semibold text-gray-900">{{ $booking->guests }}</p>                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Are you sure you want to cancel this pending booking?')">

                            </div>                                            @csrf

                            <div>                                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">

                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.total_price') }}</span>                                                <i class="fas fa-times-circle mr-1"></i>

                                <p class="text-sm md:text-base font-bold text-emerald-600">{{ format_price($booking->total_price) }}</p>                                                {{ __('messages.cancel') ?? 'Cancel' }}

                            </div>                                            </button>

                            <div>                                        </form>

                                <span class="text-xs md:text-sm text-gray-500 block mb-1">{{ __('messages.payment_method') }}</span>                                    @endif

                                <p class="text-sm md:text-base font-semibold text-gray-900">{{ $booking->payment_method ?? __('messages.not_paid') }}</p>                                </div>

                            </div>                            </div>

                        </div>                        @endforeach

                    </div>

                        <div class="flex flex-wrap items-center gap-3">                @endif

                            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">            </div>

                                <span class="text-sm md:text-base">{{ __('messages.view_details') }}</span>        </div>

                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">    </div>

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></div>

                                </svg>@endsection
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
