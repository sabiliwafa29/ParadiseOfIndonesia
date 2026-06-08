@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-orange-50 via-white to-gray-50 py-8 sm:py-12">
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
        <div class="bg-white overflow-hidden shadow-2xl rounded-2xl">
            <!-- Activity Header with Image -->
            <div class="relative h-64 sm:h-80 md:h-96 lg:h-[500px] overflow-hidden">
                @if($activity->photo)
                    <img src="{{ asset($activity->photo) }}" 
                         alt="{{ $activity->name }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 md:p-12 text-white">
                    <!-- Featured Badge -->
                    <div class="inline-flex items-center gap-2 bg-orange-500/90 backdrop-blur-sm px-4 py-2 rounded-full mb-4 shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="font-bold text-sm">{{ __('messages.featured_activity') ?? 'Featured Activity' }}</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold drop-shadow-2xl mb-4 leading-tight">
                        {{ $activity->name }}
                    </h1>
                    
                    <!-- Quick Info Pills -->
                    <div class="flex flex-wrap items-center gap-3">
                        @if($activity->location)
                            <div class="inline-flex items-center bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white/90 text-sm sm:text-base">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-semibold">{{ $activity->location }}</span>
                            </div>
                        @endif

                        @if($activity->time)
                            <div class="inline-flex items-center bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white/90 text-sm sm:text-base">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold">{{ $activity->time }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Activity Content -->
            <div class="p-6 sm:p-8 md:p-12">
                <!-- Key Highlights Section -->
                @if($activity->location || $activity->time)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 sm:mb-12">
                        @if($activity->location)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border-2 border-blue-200 shadow-md hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-3">
                                    <div class="bg-blue-500 rounded-full p-2 mr-3">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ __('messages.location') ?? 'Location' }}</h3>
                                </div>
                                <p class="text-xl sm:text-2xl font-bold text-blue-600">
                                    {{ $activity->location }}
                                </p>
                            </div>
                        @endif

                        @if($activity->time)
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-200 shadow-md hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-3">
                                    <div class="bg-green-500 rounded-full p-2 mr-3">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ __('messages.duration') ?? 'Duration' }}</h3>
                                </div>
                                <p class="text-xl sm:text-2xl font-bold text-green-600">
                                    {{ $activity->time }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Description Section -->
                @if($activity->description)
                    <div class="mb-8 sm:mb-12 pb-8 border-b border-gray-200">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <div class="bg-orange-100 rounded-full p-2">
                                <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            {{ __('messages.about_this_activity') ?? 'About This Activity' }}
                        </h2>
                        <div class="bg-gradient-to-br from-gray-50 to-white p-6 sm:p-8 rounded-xl border border-gray-200 shadow-inner">
                            <p class="text-base sm:text-lg text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $activity->description }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-2xl p-8 sm:p-12 text-white text-center shadow-2xl">
                    <div class="max-w-3xl mx-auto">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl sm:text-4xl font-bold mb-4">
                            {{ __('messages.ready_to_experience') ?? 'Ready to Experience This?' }}
                        </h3>
                        <p class="text-white/90 mb-8 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                            {{ __('messages.book_package_cta') ?? 'Book one of our tour packages to include this amazing activity in your adventure' }}
                        </p>
                        <a href="{{ route('tour-packages.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 text-base sm:text-lg font-bold rounded-full hover:bg-gray-50 transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ __('messages.view_tour_packages') ?? 'View Tour Packages' }}
                        </a>
                    </div>
                </div>
            </div>
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