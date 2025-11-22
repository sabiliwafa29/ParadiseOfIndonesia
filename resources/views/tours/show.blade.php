@extends('layouts.app')
@php
use App\Helpers\ItineraryHelper;
@endphp

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            @if(request('from') === 'package')
                <!-- Kembali ke Package Detail jika dari Package -->
                <a href="{{ route('tour-packages.show', request('package_id')) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {{ __('messages.back_to_package') }}
                </a>
            @else
                <!-- Kembali ke Tours Index jika langsung dari Tours -->
                <a href="{{ route('tours.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {{ __('messages.back_to_tours') }}
                </a>
            @endif
        </div>

        <!-- Main Tour Card -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            
            <!-- Tour Header with Image -->
            <div class="relative h-96">
                @if($tour->image)
                    @include('components.responsive-image', [
                        'path' => $tour->image,
                        'alt' => $tour->name,
                        'class' => 'w-full h-full object-cover',
                        'derivatives' => $tour->image_derivatives ?? null
                    ])
                @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold">{{ $tour->name }}</h1>
                    <p class="text-xl mt-2 text-gray-200">
                        <a href="{{ route('destinations.show', $tour->destination) }}" class="hover:text-white">
                            {{ $tour->destination->name }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Tour Content -->
            <div class="p-8 md:p-12">
                
                <!-- Price and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 pb-8 border-b">

                    @php
                        use App\Services\LocationService;
                        $userMarket = LocationService::getUserMarket();
                        $userCurrency = LocationService::isIndonesia() ? 'IDR' : 'CNY';
                    @endphp

                    <div>
                        <p class="text-gray-600 text-sm">{{ __('messages.price') }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ $tour->getFormattedPrice($userCurrency) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">{{ __('messages.duration') }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ $tour->duration }} {{ __('messages.days') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">{{ __('messages.location') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $tour->destination->location }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.about_this_tour') }}</h2>
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $tour->description }}</p>
                </div>

                <!-- Itinerary -->
                @if($tour->itinerary)
                    <div class="mb-8 md:mb-12">
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4 md:mb-6">{{ __('messages.itinerary') }}</h2>
                        <div class="space-y-3 md:space-y-6" x-data="{ openDay: null }">
                            @php
                                $itinerary = ItineraryHelper::parseItinerary($tour->itinerary);
                            @endphp
                            
                            @foreach($itinerary as $dayIndex => $dayData)
                                @php
                                    $day = ItineraryHelper::parseDayData($dayData, $dayIndex);
                                    
                                    // Skip if no activities
                                    if (empty($day['activities'])) {
                                        continue;
                                    }
                                @endphp
                                
                                <div class="bg-white border-l-4 border-emerald-500 rounded-lg shadow-sm hover:shadow-md transition">
                                    <!-- Day Header - Clickable -->
                                    <button 
                                        @click="openDay = openDay === {{ $dayIndex }} ? null : {{ $dayIndex }}"
                                        class="w-full text-left p-4 md:p-6 flex justify-between items-center focus:outline-none">
                                        <h3 class="text-base md:text-lg font-bold text-emerald-600">{{ $day['title'] }}</h3>
                                        <svg 
                                            class="w-5 h-5 md:w-6 md:h-6 text-emerald-600 transform transition-transform duration-200"
                                            :class="{ 'rotate-180': openDay === {{ $dayIndex }} }"
                                            fill="none" 
                                            stroke="currentColor" 
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    
                                    <!-- Activities - Collapsible -->
                                    <div 
                                        x-show="openDay === {{ $dayIndex }}"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="px-4 pb-4 md:px-6 md:pb-6 space-y-2 md:space-y-3 ml-2 md:ml-4">
                                        @foreach($day['activities'] as $activity)
                                            @php
                                                $parsed = ItineraryHelper::parseActivity($activity);
                                                
                                                // Skip if description is empty
                                                if (empty($parsed['description'])) {
                                                    continue;
                                                }
                                            @endphp
                                            
                                            <div class="flex gap-2 md:gap-3">
                                                @if($parsed['time'])
                                                    <div class="flex-shrink-0">
                                                        <span class="inline-block px-2 py-1 md:px-3 md:py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs md:text-sm font-semibold">
                                                            {{ $parsed['time'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 mt-1">
                                                        <svg class="w-3 h-3 md:w-4 md:h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                
                                                <div class="flex-1">
                                                    <p class="text-sm md:text-base text-gray-700 leading-relaxed">{{ $parsed['description'] }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Facilities Included -->
                @if(!empty($tour->includes))
                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.whats_included') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $locale = app()->getLocale();
                                
                                try {
                                    $includes = $tour->includes;
                                    
                                    if (empty($includes)) {
                                        $includes = [];
                                    } elseif (is_string($includes)) {
                                        $decoded = json_decode($includes, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $includes = $decoded;
                                        } else {
                                            $includes = array_filter(explode("\n", $includes));
                                        }
                                    } elseif (!is_array($includes)) {
                                        $includes = [$includes];
                                    }
                                    
                                    $includes = array_filter($includes, function($item) {
                                        return !empty($item);
                                    });
                                } catch (\Exception $e) {
                                    $includes = [];
                                }
                            @endphp
                            
                            @forelse($includes as $item)
                                @php
                                    try {
                                        $label = '';
                                        
                                        if (is_array($item)) {
                                            // Multi-language format
                                            $label = $item['name_'.$locale]
                                                ?? $item['name_en']
                                                ?? $item['name_id']
                                                ?? $item['name']
                                                ?? $item['label']
                                                ?? '';
                                            
                                            if (empty($label) && !empty($item)) {
                                                $label = reset($item);
                                            }
                                        } else {
                                            // Simple string format
                                            $label = trim(strval($item));
                                        }
                                    } catch (\Exception $e) {
                                        $label = '';
                                    }
                                @endphp
                                
                                @if(!empty($label))
                                    <div class="flex items-start p-4 bg-green-50 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-900">{{ $label }}</span>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-600 col-span-2">{{ __('messages.no_facilities_info') }}</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Excludes -->
                @if(!empty($tour->excludes))
                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.whats_not_included') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $locale = app()->getLocale();

                                try {
                                    $excludes = $tour->excludes;
                                    
                                    if (empty($excludes)) {
                                        $excludes = [];
                                    } elseif (is_string($excludes)) {
                                        $decoded = json_decode($excludes, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $excludes = $decoded;
                                        } else {
                                            $excludes = array_filter(explode("\n", $excludes));
                                        }
                                    } elseif (!is_array($excludes)) {
                                        $excludes = [$excludes];
                                    }
                                    
                                    $excludes = array_filter($excludes, function($item) {
                                        return !empty($item);
                                    });
                                } catch (\Exception $e) {
                                    $excludes = [];
                                }
                            @endphp
                            @forelse($excludes as $item)
                                @php
                                    try {
                                        $label = '';
                                        if (is_array($item)) {
                                            $locale = app()->getLocale();
                                            $label = $item['name_'.$locale]
                                                ?? $item['name_en']
                                                ?? $item['name']
                                                ?? $item['label']
                                                ?? '';
                                            if (empty($label) && !empty($item)) {
                                                $label = reset($item);
                                            }
                                        } else {
                                            $label = trim(strval($item));
                                        }
                                    } catch (\Exception $e) {
                                        $label = '';
                                    }
                                @endphp
                                
                                @if(!empty($label))
                                    <div class="flex items-start p-4 bg-red-50 rounded-lg">
                                        <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-900">{{ $label }}</span>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-600 col-span-2">{{ __('messages.no_exclusions') }}</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- CTA Section - Hanya tampil jika TIDAK dari Package -->
                @if(request('from') !== 'package')
                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg p-8 text-white text-center">
                        <h3 class="text-2xl font-bold mb-4">{{ __('messages.ready_for_adventure') }}</h3>
                        <p class="text-emerald-50 mb-6">{{ __('messages.book_now_create_memories') }}</p>
                        <a href="{{ route('bookings.tour', $tour) }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-emerald-600 text-lg font-bold rounded-full hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('messages.book_now') }}
                        </a>
                    </div>
                @else
                    <!-- Info message jika dari Package -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-blue-900 font-semibold">{{ __('messages.tour_part_of_package') }}</p>
                        <p class="text-blue-800 text-sm mt-2">{{ __('messages.book_entire_package') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Tours -->
        @php
            $relatedTours = \App\Models\Tour::where('destination_id', $tour->destination_id)
                ->where('id', '!=', $tour->id)
                ->limit(3)
                ->get();
        @endphp

        @if($relatedTours->isNotEmpty())
            <div class="mt-16">
                <h2 class="mt-8 text-2xl font-semibold">{{ __('messages.other_tours_in') }} {{ $tour->destination->name }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedTours as $relatedTour)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="w-full h-48 overflow-hidden">
                                @if($relatedTour->image)
                                    @include('components.responsive-image', [
                                        'path' => $relatedTour->image,
                                        'alt' => $relatedTour->name,
                                        'class' => 'w-full h-full object-cover',
                                        'derivatives' => $relatedTour->image_derivatives ?? null
                                    ])
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $relatedTour->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($relatedTour->description, 80) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-emerald-600">{{ __('messages.from') }} {{ format_price(get_price($relatedTour)) }}</span>
<a href="{{ route('tours.show', $relatedTour) }}" class="...">{{ __('messages.view') }} →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection