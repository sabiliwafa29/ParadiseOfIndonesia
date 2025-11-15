@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tour-packages.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_packages') }}
            </a>
        </div>

    <!-- Main Package Card -->
    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <!-- Package Header with Image -->
            <div class="relative h-96">
                <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold">{{ $package->name }}</h1>
                </div>
            </div>

            <!-- Package Content -->
            <div class="p-8 md:p-12">
                <!-- Price and Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 pb-8 border-b">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.package_details') }}</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-gray-600 text-sm">{{ __('messages.price') }}</p>
                                <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">{{ __('messages.description') }}</p>
                                <p class="text-gray-900 text-lg mt-2">{{ $package->description }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('messages.whats_included') }}</h2>
                        <div class="space-y-3">
                            @if($package->includes_guide)
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-blue-900 font-semibold">{{ __('messages.professional_tour_guide') }}</span>
                                </div>
                            @endif

                            @if($package->includes_transport)
                                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-900 font-semibold">{{ __('messages.private_transport') }}</span>
                                </div>
                            @endif

                            @if(!$package->includes_guide && !$package->includes_transport)
                                <p class="text-gray-600">{{ __('messages.no_special_inclusions') }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Book Now Button -->
                    <div class="flex items-center justify-center md:justify-end">
                        @auth
                            <a href="{{ route('bookings.package', $package) }}" class="inline-flex items-center px-8 py-4 bg-emerald-600 text-white text-lg font-semibold rounded-lg hover:bg-emerald-700 transition duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a2 2 0 002 2h4a2 2 0 002-2V11M9 11h6"></path>
                                </svg>
                                {{ __('messages.book_now') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-gray-600 text-white text-lg font-semibold rounded-lg hover:bg-gray-700 transition duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('messages.login_to_book') }}
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Detailed Itinerary (supports JSON or plain text) -->
                @if($package->itinerary)
                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.itinerary') }}</h2>
                        <div class="space-y-6">
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
                                    <div class="bg-white border-l-4 border-emerald-500 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                                        <div class="mb-2">
                                            <span class="font-semibold text-emerald-600">{{ $dayTitle }}</span>
                                        </div>

                                        <div class="space-y-3">
                                            @foreach($activities as $activity)
                                                @php
                                                    $time = '';
                                                    $description = '';

                                                    if (is_array($activity)) {
                                                        // format { time, description_en, description_id, ... }
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
                                                    <div class="flex gap-3">
                                                        @if($time)
                                                            <div class="flex-shrink-0">
                                                                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
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
                                                            <p class="text-gray-700 leading-relaxed">{{ $description }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
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
                                    <span class="text-xl font-bold text-emerald-600">Rp {{ number_format($relatedPackage->price, 0, ',', '.') }}</span>
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