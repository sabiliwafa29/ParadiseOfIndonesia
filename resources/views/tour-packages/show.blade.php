@extends('layouts.app')
@php
use App\Helpers\ItineraryHelper;
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tour-packages.index') }}" 
               class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_packages') ?? 'Back to Packages' }}
            </a>
        </div>

        <!-- Main Package Card -->
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            <!-- Package Header with Image -->
            <div class="relative h-64 sm:h-80 md:h-96 overflow-hidden">
                @if($package->image)
                    @if(isset($package->image_derivatives) && $package->image_derivatives)
                        @include('components.responsive-image', [
                            'path' => $package->image,
                            'alt' => $package->name,
                            'class' => 'w-full h-full object-cover',
                            'derivatives' => $package->image_derivatives
                        ])
                    @else
                        <img src="{{ \Storage::disk('public')->exists($package->image) ? \Storage::disk('public')->url($package->image) : asset($package->image) }}" 
                             alt="{{ $package->name }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/placeholder-tour.jpg') }}'">
                    @endif
                @else
                    <img src="{{ asset('images/placeholder-tour.jpg') }}" 
                         alt="{{ $package->name }}" 
                         class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 md:p-12 text-white">
                    <div class="inline-flex items-center gap-2 bg-emerald-500/90 backdrop-blur-sm px-4 py-2 rounded-full mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="font-bold text-sm">{{ __('messages.best_seller') ?? 'Best Seller' }}</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold drop-shadow-lg">{{ $package->name }}</h1>
                </div>
            </div>

            <!-- Package Content -->
            <div class="p-6 sm:p-8 md:p-12">
                <!-- Price and Basic Info -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-12 pb-8 border-b border-gray-200">
                    <div class="lg:col-span-2">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.package_details') ?? 'Package Details' }}
                        </h2>
                        <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-xl border border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">{{ __('messages.description') ?? 'Description' }}</p>
                            <p class="text-base sm:text-lg text-gray-900 leading-relaxed">{{ $package->description }}</p>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.price') ?? 'Price' }}
                        </h2>
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 rounded-xl border-2 border-emerald-200">
                            <p class="text-sm text-gray-600 mb-2">{{ __('messages.starting_from') ?? 'Starting from' }}</p>
                            <p class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                {{ format_price(get_price($package)) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-2">{{ __('messages.per_person') ?? 'per person' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detailed Itinerary -->
                @if($package->itinerary)
                    <div class="mb-8 md:mb-12">
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4 md:mb-6">{{ __('messages.itinerary') }}</h2>
                        <div class="space-y-3 md:space-y-6" x-data="{ openDay: null }">
                            @php
                                $itinerary = ItineraryHelper::parseItinerary($package->itinerary);
                            @endphp
                            
                            {{-- DEBUG: Show raw itinerary data (remove this after debugging) --}}
                            @if(config('app.debug'))
                                <div class="bg-yellow-100 border-2 border-yellow-500 p-4 rounded-lg mb-4">
                                    <h3 class="font-bold text-yellow-800 mb-2">🐛 DEBUG INFO (Remove in production)</h3>
                                    <div class="text-xs text-gray-800 space-y-2">
                                        <div><strong>Package:</strong> {{ $package->name }}</div>
                                        <div><strong>Itinerary Type:</strong> {{ gettype($package->itinerary) }}</div>
                                        <div><strong>Days Count:</strong> {{ count($itinerary) }}</div>
                                    </div>
                                </div>
                            @endif
                            
                            @foreach($itinerary as $dayIndex => $dayData)
                                @php
                                    $day = ItineraryHelper::parseDayData($dayData, $dayIndex);
                                    
                                    // Skip if no activities
                                    if (empty($day['activities'])) {
                                        continue;
                                    }
                                @endphp
                                
                                {{-- DEBUG: Show day data (remove after debugging) --}}
                                @if(config('app.debug'))
                                    <details class="bg-blue-100 border border-blue-300 p-2 rounded text-xs mb-2">
                                        <summary class="cursor-pointer font-bold">DEBUG: {{ $day['title'] }} ({{ count($day['activities']) }} activities)</summary>
                                        <pre class="mt-2 text-xs overflow-auto">{{ json_encode($dayData, JSON_PRETTY_PRINT) }}</pre>
                                    </details>
                                @endif
                                
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
                                        @foreach($day['activities'] as $activityIndex => $activity)
                                            @php
                                                $parsed = ItineraryHelper::parseActivity($activity);
                                                
                                                // Skip if description is empty
                                                if (empty($parsed['description'])) {
                                                    continue;
                                                }
                                            @endphp
                                            
                                            {{-- DEBUG: Show parsed activity (remove after debugging) --}}
                                            @if(config('app.debug'))
                                                <div class="bg-green-100 border border-green-300 p-2 rounded text-xs mb-2">
                                                    <div><strong>Activity {{ $activityIndex }}:</strong></div>
                                                    <div><strong>Time:</strong> "{{ $parsed['time'] }}" (empty: {{ empty($parsed['time']) ? 'YES' : 'NO' }})</div>
                                                    <div><strong>Description:</strong> {{ Str::limit($parsed['description'], 100) }}</div>
                                                    <details class="mt-1">
                                                        <summary class="cursor-pointer">Raw data</summary>
                                                        <pre class="text-xs mt-1">{{ json_encode($activity, JSON_PRETTY_PRINT) }}</pre>
                                                    </details>
                                                </div>
                                            @endif
                                            
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

                <!-- Additional Includes -->
                @if(!empty($package->includes))
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.whats_included') ?? "What's Included" }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @php
                                try {
                                    $includes = $package->includes;
                                    
                                    if (empty($includes)) {
                                        $includes = [];
                                    } elseif (is_string($includes)) {
                                        // Try JSON decode first
                                        $decoded = json_decode($includes, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $includes = $decoded;
                                        } else {
                                            // Fallback to line split
                                            $includes = array_filter(explode("\n", $includes));
                                        }
                                    } elseif (!is_array($includes)) {
                                        $includes = [$includes];
                                    }
                                    
                                    // Filter empty values
                                    $includes = array_filter($includes, function($item) {
                                        return !empty($item);
                                    });
                                } catch (\Exception $e) {
                                    $includes = [];
                                }
                            @endphp

                            @foreach($includes as $item)
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
                                            
                                            // Jika masih kosong, coba ambil first value
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
                                    <div class="flex items-start p-3 sm:p-4 bg-green-50 border border-green-100 rounded-lg hover:bg-green-100 transition-colors">
                                        <svg class="w-5 h-5 text-emerald-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm sm:text-base text-gray-900">{{ $label }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Excludes -->
                @if(!empty($package->excludes))
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.whats_not_included') ?? "What's Not Included" }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @php
                                try {
                                    $excludes = $package->excludes;
                                    
                                    if (empty($excludes)) {
                                        $excludes = [];
                                    } elseif (is_string($excludes)) {
                                        // Try JSON decode first
                                        $decoded = json_decode($excludes, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $excludes = $decoded;
                                        } else {
                                            // Fallback to line split
                                            $excludes = array_filter(explode("\n", $excludes));
                                        }
                                    } elseif (!is_array($excludes)) {
                                        $excludes = [$excludes];
                                    }
                                    
                                    // Filter empty values
                                    $excludes = array_filter($excludes, function($item) {
                                        return !empty($item);
                                    });
                                } catch (\Exception $e) {
                                    $excludes = [];
                                }
                            @endphp

                            @foreach($excludes as $item)
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
                                            
                                            // Jika masih kosong, coba ambil first value
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
                                    <div class="flex items-start p-3 sm:p-4 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-colors">
                                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-sm sm:text-base text-gray-900">{{ $label }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Book Now Button -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center sm:justify-end gap-4 mb-8 sm:mb-12">
                    <a href="{{ route('bookings.package', $package) }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-base sm:text-lg font-bold rounded-full hover:from-emerald-700 hover:to-teal-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('messages.book_now') ?? 'Book Now' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Packages -->
        @php
            $relatedPackages = \App\Models\TourPackage::where('id', '!=', $package->id)->limit(3)->get();
        @endphp
        
        @if($relatedPackages->isNotEmpty())
            <div class="mt-12 sm:mt-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8 flex items-center gap-2">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ __('messages.other_package_options') ?? 'Other Package Options' }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedPackages as $relatedPackage)
                        <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative h-48 overflow-hidden">
                                @if($relatedPackage->image)
                                    @if(isset($relatedPackage->image_derivatives) && $relatedPackage->image_derivatives)
                                        @include('components.responsive-image', [
                                            'path' => $relatedPackage->image,
                                            'alt' => $relatedPackage->name,
                                            'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500',
                                            'derivatives' => $relatedPackage->image_derivatives
                                        ])
                                    @else
                                        <img src="{{ \Storage::disk('public')->exists($relatedPackage->image) ? \Storage::disk('public')->url($relatedPackage->image) : asset($relatedPackage->image) }}" 
                                             alt="{{ $relatedPackage->name }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                             onerror="this.src='{{ asset('images/placeholder-tour.jpg') }}'">
                                    @endif
                                @else
                                    <img src="{{ asset('images/placeholder-tour.jpg') }}" 
                                         alt="{{ $relatedPackage->name }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            </div>
                            <div class="p-5 sm:p-6">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">
                                    {{ $relatedPackage->name }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($relatedPackage->description, 80) }}
                                </p>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        {{ format_price(get_price($relatedPackage)) }}
                                    </span>
                                    <a href="{{ route('tour-packages.show', $relatedPackage->id) }}" 
                                       class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold group-hover:gap-2 transition-all">
                                        <span class="text-sm">{{ __('messages.view') ?? 'View' }}</span>
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function toggleDay(button) {
    const itineraryItem = button.closest('.itinerary-item');
    const content = itineraryItem.querySelector('.activities-content');
    const chevron = button.querySelector('.chevron');
    
    // Toggle hidden class
    content.classList.toggle('hidden');
    
    // Rotate chevron
    if (content.classList.contains('hidden')) {
        chevron.classList.remove('rotate-180');
        chevron.classList.add('rotate-0');
    } else {
        chevron.classList.remove('rotate-0');
        chevron.classList.add('rotate-180');
    }
}

// Open first day by default
document.addEventListener('DOMContentLoaded', function() {
    const firstItem = document.querySelector('.itinerary-item');
    if (firstItem) {
        const firstButton = firstItem.querySelector('button');
        if (firstButton) {
            toggleDay(firstButton);
        }
    }
});
</script>
@endsection