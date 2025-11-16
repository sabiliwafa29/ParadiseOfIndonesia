@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
        <div class="text-center">
            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">
                <span class="text-white font-medium text-sm md:text-base">🌍 {{ __('messages.explore') }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.tours') }}</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('messages.discover_amazing_tours') }}</p>
        </div>
    </div>
</div>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                use App\Services\LocationService;
                $userCountry = LocationService::detectCountry();
                $isDomestic = LocationService::isIndonesia();
            @endphp
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($tours as $tour)
                    <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
                        <div class="relative h-56 overflow-hidden">
                            <a href="{{ route('tours.show', $tour) }}">
                                <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            </a>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            <div class="absolute top-4 left-4">
                                <a href="{{ route('destinations.show', $tour->destination) }}" class="inline-block px-4 py-2 bg-white/90 backdrop-blur-sm text-emerald-600 rounded-full text-sm font-bold hover:bg-white transition-colors">
                                    {{ $tour->destination->name }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="flex-1 p-4 md:p-6 flex flex-col">
                            <a href="{{ route('tours.show', $tour) }}" class="block">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors leading-tight">{{ $tour->name }}</h3>
                                <p class="text-sm md:text-base text-gray-600 leading-relaxed line-clamp-3">{{ Str::limit($tour->description, 120) }}</p>
                            </a>
                            
                            <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">
                                <div class="flex items-center text-gray-500">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm md:text-base font-medium">{{ $tour->duration }} {{ __('messages.days') }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs md:text-sm text-gray-500">{{ __('messages.from') }}</div>
                                    <div class="text-lg md:text-xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        {{ format_price(get_price($tour)) }}
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('tours.show', $tour) }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                                {{ __('messages.view_details') }}
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 md:mt-12">{{ $tours->links() }}</div>
    </div>
</div>
@endsection
