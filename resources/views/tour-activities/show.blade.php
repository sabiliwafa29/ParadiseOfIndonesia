@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tour-activities.index') }}" 
               class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold transition-colors group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_activities') ?? 'Back to Activities' }}
            </a>
        </div>

        <!-- Main Activity Card -->
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            <!-- Activity Header with Image -->
            <div class="relative h-64 sm:h-80 md:h-96 lg:h-[500px] overflow-hidden">
                <img src="{{ asset($activity->photo) }}" 
                     alt="{{ $activity->name }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 md:p-12 text-white">
                    <!-- Featured Badge -->
                    <div class="inline-flex items-center gap-2 bg-orange-500/90 backdrop-blur-sm px-4 py-2 rounded-full mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="font-bold text-sm">{{ __('messages.featured_activity') ?? 'Featured Activity' }}</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold drop-shadow-lg mb-4">
                        {{ $activity->name }}
                    </h1>
                    
                    <!-- Location Info -->
                    <div class="flex items-center text-white/90 text-base sm:text-lg">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-semibold">{{ $activity->location }}</span>
                    </div>
                </div>
            </div>

            <!-- Activity Content -->
            <div class="p-6 sm:p-8 md:p-12">
                <!-- Location Info -->
                <div class="mb-8 sm:mb-12 pb-8 border-b border-gray-200">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border-2 border-blue-200">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <h3 class="font-bold text-gray-900">{{ __('messages.location') ?? 'Location' }}</h3>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-blue-600">
                            {{ $activity->location }}
                        </p>
                    </div>
                </div>

                <!-- Description Section -->
                @if($activity->description)
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.about_this_activity') ?? 'About This Activity' }}
                        </h2>
                        <div class="bg-gradient-to-br from-gray-50 to-white p-6 sm:p-8 rounded-xl border border-gray-200">
                            <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                                {{ $activity->description }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-8 sm:p-10 text-white text-center">
                    <h3 class="text-2xl sm:text-3xl font-bold mb-4">
                        {{ __('messages.ready_to_experience') ?? 'Ready to Experience This?' }}
                    </h3>
                    <p class="text-white/90 mb-6 text-base sm:text-lg max-w-2xl mx-auto">
                        {{ __('messages.book_package_cta') ?? 'Book one of our tour packages to include this amazing activity in your adventure' }}
                    </p>
                    <a href="{{ route('tour-packages.index') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 text-base sm:text-lg font-bold rounded-full hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        {{ __('messages.view_tour_packages') ?? 'View Tour Packages' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Other Activities -->
        @php
            $otherActivities = \App\Models\TourActivity::where('id', '!=', $activity->id)
                ->limit(3)
                ->get();
        @endphp
        
        @if($otherActivities->isNotEmpty())
            <div class="mt-12 sm:mt-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8 flex items-center gap-2">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                    </svg>
                    {{ __('messages.other_activities') ?? 'Other Activities' }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($otherActivities as $otherActivity)
                        <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ asset($otherActivity->photo) }}" 
                                     alt="{{ $otherActivity->name }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                <div class="absolute bottom-3 left-3 right-3">
                                    <p class="text-white text-xs flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $otherActivity->location }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-5 sm:p-6">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">
                                    {{ $otherActivity->name }}
                                </h3>
                                @if($otherActivity->description)
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {{ Str::limit($otherActivity->description, 100) }}
                                    </p>
                                @endif
                                <div class="flex justify-end items-center pt-4 border-t border-gray-100">
                                    <a href="{{ route('tour-activities.show', $otherActivity->slug ?? $otherActivity->id) }}" 
                                       class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold group-hover:gap-2 transition-all">
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