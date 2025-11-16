@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-emerald-50 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-3">
                {{ __('messages.tour_sessions') }}
            </h1>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto">
                {{ __('messages.explore_upcoming_sessions') ?? 'Explore our upcoming tour sessions and find your perfect adventure' }}
            </p>
        </div>

        <!-- Sessions Grid -->
        @forelse ($sessions as $session)
            <div class="mb-6 sm:mb-8 group">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
                    <div class="p-6 sm:p-8 lg:p-10">
                        <!-- Header with gradient background -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div class="flex-1">
                                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">
                                        {{ $session->name }}
                                    </h2>
                                    <div class="flex items-center text-gray-600 mt-2">
                                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm sm:text-base font-medium">{{ $session->location }}</span>
                                    </div>
                                </div>
                                
                                <!-- Date Badge -->
                                <div class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-emerald-500 to-blue-500 text-white rounded-lg shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="text-sm sm:text-base font-semibold">
                                        {{ \Carbon\Carbon::parse($session->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                                {{ $session->description }}
                            </p>
                        </div>

                        <!-- Package Info & Action -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            @if($session->tourPackage)
                                <!-- Package Badge -->
                                <div class="flex items-center bg-blue-50 rounded-lg px-4 py-3 flex-1">
                                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-600 mb-1">{{ __('messages.associated_package') }}</p>
                                        <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $session->tourPackage->name }}</p>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
                                <a href="{{ route('tour-packages.show', $session->tourPackage) }}" 
                                   class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ __('messages.book_now') }}
                                </a>
                            @else
                                <!-- No Package Available -->
                                <div class="flex items-center justify-center w-full bg-gray-100 rounded-lg px-6 py-4">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-semibold text-gray-500 text-sm sm:text-base">{{ __('messages.no_package_available') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="text-center py-16 sm:py-20">
                <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-12 max-w-md mx-auto">
                    <svg class="w-20 h-20 sm:w-24 sm:h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">{{ __('messages.no_tour_sessions') }}</h3>
                    <p class="text-gray-600 text-sm sm:text-base">{{ __('messages.check_back_later') ?? 'Check back later for upcoming sessions' }}</p>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($sessions->hasPages())
            <div class="mt-8 sm:mt-12">
                <div class="bg-white rounded-xl shadow-md p-4">
                    {{ $sessions->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
