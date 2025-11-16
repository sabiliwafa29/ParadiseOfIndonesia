@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <!-- Hero Image Section -->
    <div class="relative h-64 sm:h-80 md:h-96 lg:h-[500px] overflow-hidden">
        <img src="{{ asset($destination->image) }}" 
             alt="{{ $destination->name }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        
        <!-- Breadcrumb & Title Overlay -->
        <div class="absolute inset-0 flex items-end">
            <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 sm:pb-12 md:pb-16">
                <!-- Breadcrumb -->
                <nav class="mb-4">
                    <ol class="flex items-center space-x-2 text-sm text-white/90">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </li>
                        <li>
                            <a href="{{ route('destinations.index') }}" class="hover:text-white transition-colors">
                                {{ __('messages.destinations') ?? 'Destinations' }}
                            </a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </li>
                        <li class="text-white font-medium">{{ $destination->name }}</li>
                    </ol>
                </nav>

                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-3 sm:mb-4 drop-shadow-lg">
                    {{ $destination->name }}
                </h1>
                
                <!-- Location Badge -->
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-white font-medium text-sm sm:text-base">{{ $destination->location }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Description Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 md:p-10 mb-8 sm:mb-12">
            <div class="flex items-center gap-3 mb-6">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.about_destination') ?? 'About This Destination' }}</h2>
            </div>
            <div class="prose prose-sm sm:prose-base lg:prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed text-sm sm:text-base md:text-lg whitespace-pre-line">{{ $destination->description }}</p>
            </div>
        </div>

        <!-- Tours Section -->
        <div class="mb-8 sm:mb-12">
            <div class="flex items-center justify-between mb-6 sm:mb-8">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">
                        {{ __('messages.tours_in') ?? 'Tours in' }} {{ $destination->name }}
                    </h2>
                </div>
                <span class="hidden sm:inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    {{ $tours->total() }} {{ __('messages.tours') ?? 'Tours' }}
                </span>
            </div>

            @if($tours->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($tours as $tour)
                <div class="group bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-500 transform hover:-translate-y-2">
                    <!-- Tour Card Content -->
                    <div class="p-5 sm:p-6">
                        <a href="{{ route('tours.show', $tour) }}" class="block">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors duration-300 line-clamp-2">
                                {{ $tour->name }}
                            </h3>
                        </a>
                        
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed line-clamp-3 mb-4">
                            {{ $tour->description }}
                        </p>

                        <!-- Features/Info -->
                        <div class="flex flex-wrap gap-2 mb-4 pb-4 border-b border-gray-100">
                            @if($tour->duration)
                            <span class="inline-flex items-center text-xs bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full font-medium">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $tour->duration }}
                            </span>
                            @endif

                            @if($tour->difficulty)
                            <span class="inline-flex items-center text-xs bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full font-medium">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                {{ $tour->difficulty }}
                            </span>
                            @endif
                        </div>

                        <!-- Price & CTA -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">{{ __('messages.from') ?? 'From' }}</p>
                                <p class="text-xl sm:text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    ${{ number_format($tour->price, 0) }}
                                </p>
                            </div>
                            <a href="{{ route('tours.show', $tour) }}" 
                               class="inline-flex items-center px-4 sm:px-5 py-2 sm:py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300 text-sm">
                                <span>{{ __('messages.view') ?? 'View' }}</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($tours->hasPages())
            <div class="mt-8 sm:mt-12">
                <div class="bg-white rounded-xl shadow-md p-4">
                    {{ $tours->links() }}
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="text-center py-12 sm:py-16">
                <div class="inline-block p-6 sm:p-8 bg-white rounded-2xl shadow-lg">
                    <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ __('messages.no_tours_available') ?? 'No Tours Available' }}</h3>
                    <p class="text-sm sm:text-base text-gray-500">{{ __('messages.check_back_soon') ?? 'Check back soon for new tours to this destination' }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="flex justify-center sm:justify-start">
            <a href="{{ route('destinations.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-emerald-300 group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_destinations') ?? 'Back to Destinations' }}
            </a>
        </div>
    </div>
</div>
@endsection
