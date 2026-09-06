@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-amber-600 via-orange-600 to-red-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-24 relative">
        <div class="text-center">
            <div class="inline-block px-4 sm:px-6 py-2 sm:py-3 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4 sm:mb-6">
                <span class="text-white font-medium text-sm sm:text-base md:text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    {{ __('messages.travel_services') }}
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-3 sm:mb-4 drop-shadow-lg">
                {{ __('messages.travel_services') }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto px-4">
                {{ __('messages.choose_travel_companion') ?? 'Choose your perfect travel companion for your journey' }}
            </p>
        </div>
    </div>
</div>

<!-- Services Section -->
<div class="py-8 sm:py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse ($services as $service)
            <div class="group bg-white rounded-2xl sm:rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-500 transform hover:-translate-y-2">
                <!-- Image Section -->
                <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden">
                    <img src="{{ $service->image_url }}" 
                         alt="{{ $service->name }}" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    
                    <!-- Type Badge -->
                    <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                        <span class="inline-flex items-center gap-1 bg-amber-500 text-white text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full uppercase font-bold tracking-wide shadow-lg">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                            {{ $service->type }}
                        </span>
                    </div>

                    <!-- Capacity Badge -->
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4">
                        <div class="flex items-center gap-1.5 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-md">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-xs sm:text-sm font-semibold text-gray-700">
                                {{ $service->capacity ?? 'N/A' }} {{ __('messages.seats') ?? 'seats' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                        {{ $service->name }}
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed line-clamp-2 mb-4">
                        {{ $service->description }}
                    </p>

                    <!-- Features -->
                    @if(!empty($service->features))
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice(explode(',', $service->features ?? ''), 0, 3) as $feature)
                        <span class="inline-flex items-center text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ trim($feature) }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    <!-- Price & CTA -->
                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100">
                        <div>
                            <span class="text-xs sm:text-sm text-gray-500 block mb-1">{{ __('messages.starting_from') ?? 'Starting from' }}</span>
                            <span class="text-xl sm:text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                {{ \App\Helpers\LanguageHelper::formatPrice( \App\Helpers\LanguageHelper::getPrice($service) ) }}
                            </span>
                        </div>
                        <a href="{{ route('travel-services.booking', $service) }}" 
                           class="inline-flex items-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-amber-500/50 transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                            <span>{{ __('messages.select') ?? 'Select' }}</span>
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-12 sm:py-16">
                <div class="inline-block p-6 sm:p-8 bg-white rounded-2xl shadow-lg">
                    <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ __('messages.no_services_found') ?? 'No Travel Services Found' }}</h3>
                    <p class="text-sm sm:text-base text-gray-500">{{ __('messages.check_back_soon') ?? 'Check back soon for available travel services' }}</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
        <div class="mt-8 sm:mt-12">
            <div class="bg-white rounded-xl shadow-md p-4">
                {{ $services->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
