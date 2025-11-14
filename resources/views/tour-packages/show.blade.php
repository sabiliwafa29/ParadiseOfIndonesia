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
                <img src="{{ asset($tourPackage->image) }}" alt="{{ $tourPackage->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold">{{ $tourPackage->name }}</h1>
                </div>
            </div>

            <!-- Package Content -->
            <div class="p-8 md:p-12">
                <!-- Price and Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12 pb-8 border-b">
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

                    <!-- Includes -->
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
                </div>

                <!-- Tours in Package -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.tours_included') }}</h2>
                    
                    @if($package->tours->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($package->tours as $tour)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" class="w-full h-48 object-cover">
                                    <div class="p-6">
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $tour->name }}</h3>
                                        
                                        <p class="text-gray-600 mb-4">
                                            <a href="{{ route('destinations.show', $tour->destination) }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">
                                                {{ $tour->destination->name }}
                                            </a>
                                        </p>

                                        <p class="text-gray-600 mb-4">{{ Str::limit($tour->description, 120) }}</p>

                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center text-gray-500">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ $tour->duration }} days</span>
                                            </div>
                                            <span class="text-lg font-bold text-emerald-600">${{ number_format($tour->price, 0) }}</span>
                                        </div>

                                        <a href="{{ route('tours.show', $tour) }}?from=package&package_id={{ $package->id }}" class="w-full py-2 bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">
                                            {{ __('messages.view_tour_details') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                            <svg class="w-12 h-12 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M9 3h6a2 2 0 012 2v18a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                            </svg>
                            <p class="text-yellow-900 text-lg font-semibold">{{ __('messages.no_tours_in_package') }}</p>
                            <p class="text-yellow-800 mt-2">{{ __('messages.check_back_later') }}</p>
                        </div>
                    @endif
                </div>

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg p-8 text-white text-center">
                    <h3 class="text-2xl font-bold mb-4">{{ __('messages.ready_to_book') }}</h3>
                    <p class="text-emerald-50 mb-6">{{ __('messages.contact_us_today') }}</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/" class="py-3 px-8 bg-white text-emerald-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                            {{ __('messages.contact_us') }}
                        </a>
                        <a href="{{ route('tour-packages.index') }}" class="py-3 px-8 bg-emerald-700 text-white rounded-lg font-semibold hover:bg-emerald-800 transition">
                            {{ __('messages.view_more_packages') }}
                        </a>
                    </div>
                </div>
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