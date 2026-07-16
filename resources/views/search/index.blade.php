@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
        <div class="text-center">
            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">
                <span class="text-white font-medium text-sm md:text-base">🔍 {{ __('messages.search') ?? 'Search' }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">
                @if($query !== '')
                    "{{ $query }}"
                @else
                    {{ __('messages.search') ?? 'Search' }}
                @endif
            </h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
                {{ __('messages.search_results') ?? 'Search results for tours, packages and destinations' }}
            </p>
        </div>
    </div>
</div>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($query === '')
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ __('messages.enter_search_query') ?? 'Type something in the search box to find tours, packages and destinations.' }}</p>
            </div>
        @else
            @php
                $total = $tours->total() + $packages->total() + $destinations->total();
            @endphp

            <p class="text-gray-600 mb-8">
                {{ __('messages.found_results', ['count' => $total]) ?? $total . ' results found' }}
            </p>

            {{-- Tours --}}
            @if($tours->isNotEmpty())
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.tours') ?? 'Tours' }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @foreach($tours as $tour)
                        <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
                            <div class="relative h-56 overflow-hidden">
                                <a href="{{ route('tours.show', $tour) }}">
                                    @if($tour->image)
                                        @include('components.responsive-image', [
                                            'path' => $tour->image,
                                            'alt' => $tour->name ?? '',
                                            'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700',
                                            'derivatives' => $tour->image_derivatives
                                        ])
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                                @if($tour->destination)
                                    <div class="absolute top-4 left-4">
                                        <a href="{{ route('destinations.show', $tour->destination) }}" class="inline-block px-4 py-2 bg-white/90 backdrop-blur-sm text-emerald-600 rounded-full text-sm font-bold hover:bg-white transition-colors">
                                            {{ $tour->destination->name }}
                                        </a>
                                    </div>
                                @endif
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
                                        <span class="text-sm md:text-base font-medium">{{ $tour->duration }} {{ __('messages.days') ?? 'days' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs md:text-sm text-gray-500">{{ __('messages.from') ?? 'From' }}</div>
                                        <div class="text-lg md:text-xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                            {{ format_price(get_price($tour)) }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('tours.show', $tour) }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                                    {{ __('messages.view_details') ?? 'View Details' }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-12">{{ $tours->links() }}</div>
            @endif

            {{-- Packages --}}
            @if($packages->isNotEmpty())
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.tour_packages') ?? 'Tour Packages' }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @foreach($packages as $package)
                        <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
                            <div class="relative h-56 overflow-hidden">
                                <a href="{{ route('tour-packages.show', $package) }}">
                                    @if($package->image)
                                        @include('components.responsive-image', [
                                            'path' => $package->image,
                                            'alt' => $package->name ?? '',
                                            'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700',
                                            'derivatives' => $package->image_derivatives ?? null
                                        ])
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="flex-1 p-4 md:p-6 flex flex-col">
                                <a href="{{ route('tour-packages.show', $package) }}" class="block">
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors leading-tight">{{ $package->name }}</h3>
                                </a>
                                <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">
                                    <div class="text-right">
                                        <div class="text-xs md:text-sm text-gray-500">{{ __('messages.from') ?? 'From' }}</div>
                                        <div class="text-lg md:text-xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                            {{ format_price(get_price($package)) }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('tour-packages.show', $package) }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                                    {{ __('messages.view_details') ?? 'View Details' }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-12">{{ $packages->links() }}</div>
            @endif

            {{-- Destinations --}}
            @if($destinations->isNotEmpty())
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.destinations') ?? 'Destinations' }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
                    @foreach($destinations as $destination)
                        <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
                            <div class="relative h-56 overflow-hidden">
                                <a href="{{ route('destinations.show', $destination) }}">
                                    @if($destination->image)
                                        @include('components.responsive-image', [
                                            'path' => $destination->image,
                                            'alt' => $destination->name ?? '',
                                            'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700',
                                            'derivatives' => $destination->image_derivatives ?? null
                                        ])
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="flex-1 p-4 md:p-6 flex flex-col">
                                <a href="{{ route('destinations.show', $destination) }}" class="block">
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors leading-tight">{{ $destination->name }}</h3>
                                    <p class="text-sm md:text-base text-gray-600 leading-relaxed line-clamp-3">{{ Str::limit($destination->description, 120) }}</p>
                                </a>
                                <a href="{{ route('destinations.show', $destination) }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                                    {{ __('messages.view_details') ?? 'View Details' }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-12">{{ $destinations->links() }}</div>
            @endif

            {{-- No results --}}
            @if($total === 0)
                <div class="text-center py-12 sm:py-16">
                    <div class="inline-block p-6 sm:p-8 bg-white rounded-2xl shadow-lg">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ __('messages.no_results') ?? 'No results found' }}</h3>
                        <p class="text-sm sm:text-base text-gray-500">{{ __('messages.try_different_keyword') ?? 'Try a different keyword or browse our tours and destinations.' }}</p>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
