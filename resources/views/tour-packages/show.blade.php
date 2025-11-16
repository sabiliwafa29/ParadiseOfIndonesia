@extends('layouts.app')

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
                <img src="{{ asset($package->image) }}" 
                     alt="{{ $package->name }}" 
                     class="w-full h-full object-cover">
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
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            {{ __('messages.itinerary') ?? 'Itinerary' }}
                        </h2>
                        <div class="space-y-4 sm:space-y-6" x-data="{ openDay: 0 }">
                            @php
                                $itinerary = $package->itinerary;

                                // Jika string JSON, decode
                                if (is_string($itinerary)) {
                                    $decoded = json_decode($itinerary, true);
                                    $itinerary = is_array($decoded) ? $decoded : explode("\n", $itinerary);
                                }

                                // Pastikan array
                                if (!is_array($itinerary)) {
                                    $itinerary = [$itinerary];
                                }
                            @endphp

                            @foreach($itinerary as $dayIndex => $dayData)
                                @php
                                    // Struktur array dengan key 'day' dan 'activities'
                                    if (is_array($dayData) && isset($dayData['day'])) {
                                        $locale = app()->getLocale();
                                        $dayField = $dayData['day'];

                                        // dayField bisa string atau array multilanguage
                                        if (is_array($dayField)) {
                                            $dayTitle = $dayField[$locale]
                                                ?? $dayField['en']
                                                ?? reset($dayField)
                                                ?? ('Day ' . ($dayIndex + 1));
                                        } else {
                                            $dayTitle = (string) $dayField;
                                        }

                                        $activities = is_array($dayData['activities'] ?? null)
                                            ? $dayData['activities']
                                            : (isset($dayData['activities']) ? [$dayData['activities']] : []);
                                    } else {
                                        // Fallback: string biasa
                                        $text = is_array($dayData) ? ($dayData['description'] ?? (string)$dayData) : (string)$dayData;
                                        $dayTitle = 'Day ' . ($dayIndex + 1);
                                        $activities = [$text];
                                    }
                                @endphp

                                @if(!empty(array_filter($activities)))
                                    <div class="bg-white border-l-4 border-emerald-500 rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                                        <!-- Day Header - Clickable -->
                                        <button 
                                            @click="openDay = openDay === {{ $dayIndex }} ? null : {{ $dayIndex }}"
                                            class="w-full text-left p-4 sm:p-6 flex justify-between items-center focus:outline-none hover:bg-gray-50 transition-colors">
                                            <span class="text-base sm:text-lg md:text-xl font-bold text-emerald-600 flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $dayTitle }}
                                            </span>
                                            <svg 
                                                class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-600 transform transition-transform duration-200"
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
                                            class="px-4 pb-4 sm:px-6 sm:pb-6 space-y-3 sm:space-y-4 bg-gray-50">
                                            @foreach($activities as $activity)
                                                @php
                                                    $time = '';
                                                    $description = '';

                                                    if (is_array($activity)) {
                                                        $time = $activity['time'] ?? '';
                                                        $locale = app()->getLocale();
                                                        $description = $activity['description_'.$locale]
                                                            ?? $activity['description_en']
                                                            ?? $activity['description']
                                                            ?? '';
                                                    } else {
                                                        $description = trim((string)$activity);
                                                    }
                                                @endphp

                                                @if($description)
                                                    <div class="flex gap-2 sm:gap-3 bg-white p-3 sm:p-4 rounded-lg">
                                                        @if($time)
                                                            <div class="flex-shrink-0">
                                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-xs sm:text-sm font-semibold">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                    {{ $time }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="flex-shrink-0 mt-1">
                                                                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                        @endif

                                                        <div class="flex-1">
                                                            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">{{ $description }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            {{-- NOTE per hari (opsional, multilanguage) --}}
                                            @php
                                                $noteText = null;

                                                if (is_array($dayData) && isset($dayData['note'])) {
                                                    $note = $dayData['note'];

                                                    if (is_array($note)) {
                                                        $locale = app()->getLocale();
                                                        $noteText = $note['description_'.$locale]
                                                            ?? $note['description_en']
                                                            ?? $note['description']
                                                            ?? reset($note);
                                                    } else {
                                                        $noteText = trim((string) $note);
                                                    }
                                                }
                                            @endphp

                                            @if(!empty($noteText))
                                                <div class="mt-4 border-t border-gray-200 pt-3 bg-amber-50 p-3 sm:p-4 rounded-lg">
                                                    <p class="text-xs uppercase tracking-wide text-amber-600 font-semibold mb-1 flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ __('messages.note') ?? 'Note' }}
                                                    </p>
                                                    <p class="text-gray-700 text-sm leading-relaxed">
                                                        {{ $noteText }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Additional Includes -->
                @if($package->includes)
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.whats_included') ?? "What's Included" }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @php
                                $includes = $package->includes;
                                if (is_string($includes)) {
                                    $decoded = json_decode($includes, true);
                                    $includes = is_array($decoded) ? $decoded : explode("\n", $includes);
                                }
                                if (!is_array($includes)) {
                                    $includes = [$includes];
                                }
                            @endphp

                            @foreach($includes as $item)
                                @php
                                    if (is_array($item)) {
                                        $locale = app()->getLocale();
                                        $label = $item['name_'.$locale]
                                            ?? $item['name_en']
                                            ?? $item['name']
                                            ?? '';
                                    } else {
                                        $label = trim((string)$item);
                                    }
                                @endphp

                                @if($label)
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
                @if($package->excludes)
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.whats_not_included') ?? "What's Not Included" }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @php
                                $excludes = $package->excludes;
                                if (is_string($excludes)) {
                                    $decoded = json_decode($excludes, true);
                                    $excludes = is_array($decoded) ? $decoded : explode("\n", $excludes);
                                }
                                if (!is_array($excludes)) {
                                    $excludes = [$excludes];
                                }
                            @endphp

                            @foreach($excludes as $item)
                                @php
                                    if (is_array($item)) {
                                        $locale = app()->getLocale();
                                        $label = $item['name_'.$locale]
                                            ?? $item['name_en']
                                            ?? $item['name']
                                            ?? '';
                                    } else {
                                        $label = trim((string)$item);
                                    }
                                @endphp

                                @if($label)
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
                                <img src="{{ asset($relatedPackage->image) }}" 
                                     alt="{{ $relatedPackage->name }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
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
@endsection
                            @php
                                $itinerary = $package->itinerary;

                                // Jika string JSON, decode
                                if (is_string($itinerary)) {
                                    $decoded = json_decode($itinerary, true);
                                    $itinerary = is_array($decoded) ? $decoded : explode("\n", $itinerary);
                                }

                                // Pastikan array
                                if (!is_array($itinerary)) {
                                    $itinerary = [$itinerary];
                                }
                            @endphp

                            @foreach($itinerary as $dayIndex => $dayData)
                                @php
                                    // Struktur array dengan key 'day' dan 'activities'
                                    if (is_array($dayData) && isset($dayData['day'])) {
                                        $locale = app()->getLocale();
                                        $dayField = $dayData['day'];

                                        // dayField bisa string atau array multilanguage
                                        if (is_array($dayField)) {
                                            $dayTitle = $dayField[$locale]
                                                ?? $dayField['en']
                                                ?? reset($dayField)       // ambil elemen pertama kalau tidak ada key
                                                ?? ('Day ' . ($dayIndex + 1));
                                        } else {
                                            $dayTitle = (string) $dayField;
                                        }

                                        $activities = is_array($dayData['activities'] ?? null)
                                            ? $dayData['activities']
                                            : (isset($dayData['activities']) ? [$dayData['activities']] : []);
                                    } else {
                                        // Fallback: string biasa
                                        $text = is_array($dayData) ? ($dayData['description'] ?? (string)$dayData) : (string)$dayData;
                                        $dayTitle = 'Day ' . ($dayIndex + 1);
                                        $activities = [$text];
                                    }
                                @endphp

                                @if(!empty(array_filter($activities)))
                                    <div class="bg-white border-l-4 border-emerald-500 rounded-lg shadow-sm hover:shadow-md transition">
                                        <!-- Day Header - Clickable -->
                                        <button 
                                            @click="openDay = openDay === {{ $dayIndex }} ? null : {{ $dayIndex }}"
                                            class="w-full text-left p-4 md:p-6 flex justify-between items-center focus:outline-none">
                                            <span class="text-base md:text-lg font-semibold text-emerald-600">{{ $dayTitle }}</span>
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
                                            class="px-4 pb-4 md:px-6 md:pb-6 space-y-2 md:space-y-3">
                                            @foreach($activities as $activity)
                                                @php
                                                    $time = '';
                                                    $description = '';

                                                    if (is_array($activity)) {
                                                        // format { time, description_en, description_id, description_zh, ... }
                                                        $time = $activity['time'] ?? '';

                                                        $locale = app()->getLocale();
                                                        $description = $activity['description_'.$locale]
                                                            ?? $activity['description_en']
                                                            ?? $activity['description']
                                                            ?? '';
                                                    } else {
                                                        $description = trim((string)$activity);
                                                    }
                                                @endphp

                                                @if($description)
                                                    <div class="flex gap-2 md:gap-3">
                                                        @if($time)
                                                            <div class="flex-shrink-0">
                                                                <span class="inline-block px-2 py-1 md:px-3 md:py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs md:text-sm font-semibold">
                                                                    {{ $time }}
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
                                                            <p class="text-sm md:text-base text-gray-700 leading-relaxed">{{ $description }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        {{-- NOTE per hari (opsional, multilanguage) --}}
                                        @php
                                            $noteText = null;

                                            if (is_array($dayData) && isset($dayData['note'])) {
                                                $note = $dayData['note'];

                                                if (is_array($note)) {
                                                    $locale = app()->getLocale();
                                                    $noteText = $note['description_'.$locale]
                                                        ?? $note['description_en']
                                                        ?? $note['description']
                                                        ?? reset($note);
                                                } else {
                                                    $noteText = trim((string) $note);
                                                }
                                            }
                                        @endphp

                                        @if(!empty($noteText))
                                            <div class="mt-4 border-t border-gray-100 pt-3">
                                                <p class="text-xs uppercase tracking-wide text-gray-400 mb-1">
                                                    {{ __('messages.note') ?? 'Note' }}
                                                </p>
                                                <p class="text-gray-600 text-sm leading-relaxed">
                                                    {{ $noteText }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Additional Includes (supports JSON or plain text) -->
                @if($package->includes)
                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.whats_included') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $includes = $package->includes;
                                if (is_string($includes)) {
                                    $decoded = json_decode($includes, true);
                                    $includes = is_array($decoded) ? $decoded : explode("\n", $includes);
                                }
                                if (!is_array($includes)) {
                                    $includes = [$includes];
                                }
                            @endphp

                            @foreach($includes as $item)
                                @php
                                    if (is_array($item)) {
                                        $locale = app()->getLocale();
                                        $label = $item['name_'.$locale]
                                            ?? $item['name_en']
                                            ?? $item['name']
                                            ?? '';
                                    } else {
                                        $label = trim((string)$item);
                                    }
                                @endphp

                                @if($label)
                                    <div class="flex items-start p-4 bg-green-50 rounded-lg">
                                        <svg class="w-5 h-5 text-emerald-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-900">{{ $label }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Excludes (supports JSON or plain text) -->
                @if($package->excludes)
                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.whats_not_included') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $excludes = $package->excludes;
                                if (is_string($excludes)) {
                                    $decoded = json_decode($excludes, true);
                                    $excludes = is_array($decoded) ? $decoded : explode("\n", $excludes);
                                }
                                if (!is_array($excludes)) {
                                    $excludes = [$excludes];
                                }
                            @endphp

                            @foreach($excludes as $item)
                                @php
                                    if (is_array($item)) {
                                        $locale = app()->getLocale();
                                        $label = $item['name_'.$locale]
                                            ?? $item['name_en']
                                            ?? $item['name']
                                            ?? '';
                                    } else {
                                        $label = trim((string)$item);
                                    }
                                @endphp

                                @if($label)
                                    <div class="flex items-start p-4 bg-red-50 rounded-lg">
                                        <svg class="w-5 h-5 text-red-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-gray-900">{{ $label }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Book Now Button (no login required) -->
                <div class="flex items-center justify-center md:justify-end">
                    <a href="{{ route('bookings.package', $package) }}"
                       class="inline-flex items-center px-8 py-4 bg-emerald-600 text-white text-lg font-semibold rounded-lg hover:bg-emerald-700 transition duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11M9 11h6"></path>
                        </svg>
                        {{ __('messages.book_now') }}
                    </a>
                </div>

                <!-- CTA Section -->
                <!-- <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg p-8 text-white text-center">
                    <h3 class="text-2xl font-bold mb-4">{{ __('messages.ready_to_book') }}</h3>
                    <p class="text-emerald-50 mb-6">{{ __('messages.contact_us_today') }}</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/" class="py-3 px-8 bg-white text-emerald-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                            {{ __('messages.book_now') }}
                        </a>
                        <a href="{{ route('tour-packages.index') }}" class="py-3 px-8 bg-emerald-700 text-white rounded-lg font-semibold hover:bg-emerald-800 transition">
                            {{ __('messages.view_more_packages') }}
                        </a>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Related Packages -->
        @php
            $relatedPackages = \App\Models\TourPackage::where('id', '!=', $package->id)->limit(3)->get();
        @endphp
        
        @if($relatedPackages->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('messages.other_package_options') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedPackages as $relatedPackage)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <img src="{{ asset($relatedPackage->image) }}" alt="{{ $relatedPackage->name }}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $relatedPackage->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($relatedPackage->description, 80) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-emerald-600">{{ format_price(get_price($relatedPackage)) }}</span>
                                    <a href="{{ route('tour-packages.show', $relatedPackage->id) }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">
                                        →
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
@endsection