@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tour-sessions.index') }}" 
               class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_sessions') ?? 'Back to Sessions' }}
            </a>
        </div>

        <!-- Main Session Card -->
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            <!-- Session Header -->
            <div class="relative bg-gradient-to-r from-emerald-600 to-blue-600 p-8 sm:p-12 text-white">
                <div class="absolute top-4 right-4 inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-sm">{{ __('messages.active_session') ?? 'Active Session' }}</span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">
                    {{ $session->name }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-white/90">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-semibold">{{ $session->location }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-semibold">
                            {{ \Carbon\Carbon::parse($session->start_date)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Session Content -->
            <div class="p-6 sm:p-8 md:p-12">
                <!-- Description Section -->
                <div class="mb-8 sm:mb-12 pb-8 border-b border-gray-200">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('messages.session_description') ?? 'Session Description' }}
                    </h2>
                    <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-xl border border-gray-200">
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            {{ $session->description }}
                        </p>
                    </div>
                </div>

                <!-- Associated Tour Package -->
                @if($session->tourPackage)
                    <div class="mb-8 sm:mb-12">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ __('messages.tour_package_details') ?? 'Tour Package Details' }}
                        </h2>

                        <div class="bg-gradient-to-br from-blue-50 to-emerald-50 rounded-xl overflow-hidden border border-blue-200">
                            <div class="p-6 sm:p-8">
                                <!-- Package Image -->
                                @if($session->tourPackage->image)
                                    <div class="relative h-48 sm:h-64 rounded-lg overflow-hidden mb-6 shadow-lg">
                                        <img src="{{ asset($session->tourPackage->image) }}" 
                                             alt="{{ $session->tourPackage->name }}" 
                                             class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <h3 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-lg">
                                                {{ $session->tourPackage->name }}
                                            </h3>
                                        </div>
                                    </div>
                                @else
                                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
                                        {{ $session->tourPackage->name }}
                                    </h3>
                                @endif

                                <!-- Package Description -->
                                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $session->tourPackage->description }}
                                    </p>
                                </div>

                                <!-- Package Price -->
                                <div class="bg-white p-6 rounded-lg shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-600 mb-1">{{ __('messages.package_price') ?? 'Package Price' }}</p>
                                            <p class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                                {{ format_price(get_price($session->tourPackage)) }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">{{ __('messages.per_person') ?? 'per person' }}</p>
                                        </div>
                                        
                                        <a href="{{ route('tour-packages.show', $session->tourPackage) }}" 
                                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg">
                                            {{ __('messages.view_full_package') ?? 'View Full Package' }}
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Session Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 sm:mb-12">
                    <!-- Start Date -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 rounded-xl border border-emerald-200">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="font-bold text-gray-900">{{ __('messages.start_date') ?? 'Start Date' }}</h3>
                        </div>
                        <p class="text-2xl font-bold text-emerald-600">
                            {{ \Carbon\Carbon::parse($session->start_date)->format('d F Y') }}
                        </p>
                    </div>

                    <!-- End Date -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="font-bold text-gray-900">{{ __('messages.end_date') ?? 'End Date' }}</h3>
                        </div>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ \Carbon\Carbon::parse($session->end_date)->format('d F Y') }}
                        </p>
                    </div>
                </div>

                <!-- Book Now Button -->
                @if($session->tourPackage)
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center sm:justify-end gap-4">
                        <a href="{{ route('bookings.session', $session) }}"
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-base sm:text-lg font-bold rounded-full hover:from-emerald-700 hover:to-teal-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('messages.book_this_session') ?? 'Book This Session' }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Other Available Sessions -->
        @php
            $otherSessions = \App\Models\TourSession::where('id', '!=', $session->id)
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->limit(3)
                ->get();
        @endphp
        
        @if($otherSessions->isNotEmpty())
            <div class="mt-12 sm:mt-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8 flex items-center gap-2">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('messages.other_available_sessions') ?? 'Other Available Sessions' }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($otherSessions as $otherSession)
                        <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                            <div class="p-6">
                                <div class="mb-4">
                                    <div class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold mb-3">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($otherSession->start_date)->format('d M Y') }}
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">
                                        {{ $otherSession->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $otherSession->location }}
                                    </p>
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ Str::limit($otherSession->description, 80) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    @if($otherSession->tourPackage)
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ format_price(get_price($otherSession->tourPackage)) }}
                                        </span>
                                    @endif
                                    <a href="{{ route('tour-sessions.show', $otherSession) }}" 
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