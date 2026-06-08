@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ij48L3BhdGg+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-24 relative">
        <div class="text-center">
            <div class="inline-block px-4 sm:px-6 py-2 sm:py-3 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4 sm:mb-6">
                <span class="text-white font-medium text-sm sm:text-base md:text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ __('messages.best_packages_label') ?? 'Best Packages' }}
                </span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-3 sm:mb-4 drop-shadow-lg">
                {{ __('messages.tour_packages') }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto px-4">
                {{ __('messages.best_packages_desc') ?? 'Discover our carefully curated tour packages designed for unforgettable experiences' }}
            </p>
        </div>
    </div>
</div>

<!-- Packages Section -->
<div class="py-8 sm:py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse ($packages as $package)
            <div class="group relative bg-white rounded-2xl sm:rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-500 transform hover:-translate-y-2">
                <!-- Image Section -->
                <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden">
                    @if($package->image)
                        @if(isset($package->image_derivatives) && $package->image_derivatives)
                            @include('components.responsive-image', [
                                'path' => $package->image,
                                'alt' => $package->name,
                                'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700',
                                'derivatives' => $package->image_derivatives
                            ])
                        @else
                            <img src="{{ \Storage::disk('public')->exists($package->image) ? \Storage::disk('public')->url($package->image) : asset($package->image) }}" 
                                 alt="{{ $package->name }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                 onerror="this.src='{{ asset('images/placeholder-tour.jpg') }}'">
                        @endif
                    @else
                        <img src="{{ asset('images/placeholder-tour.jpg') }}" 
                             alt="{{ $package->name }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    
                    <!-- Best Seller Badge -->
                    <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                        <span class="inline-flex items-center gap-1 bg-emerald-500 text-white text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full font-bold shadow-lg">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ __('messages.best_seller') ?? 'Best Seller' }}
                        </span>
                    </div>

                    <!-- Price Badge -->
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4">
                        <div class="bg-white/95 backdrop-blur-sm px-3 sm:px-4 py-2 rounded-full shadow-lg">
                            <p class="text-xs text-gray-600 mb-0.5">{{ __('messages.from') ?? 'From' }}</p>
                            <p class="text-lg sm:text-xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                {{ format_price(get_price($package)) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                        {{ $package->name }}
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed line-clamp-3 mb-4">
                        {{ $package->description }}
                    </p>

                    <!-- Includes/Features -->
                    @if($package->includes_guide || $package->includes_transport)
                    <div class="flex flex-wrap gap-2 mb-4 pb-4 border-b border-gray-100">
                        @if($package->includes_guide)
                        <span class="inline-flex items-center text-xs bg-blue-50 text-blue-700 px-2.5 py-1.5 rounded-full font-medium">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('messages.tour_guide') ?? 'Tour Guide' }}
                        </span>
                        @endif

                        @if($package->includes_transport)
                        <span class="inline-flex items-center text-xs bg-green-50 text-green-700 px-2.5 py-1.5 rounded-full font-medium">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            {{ __('messages.transport') ?? 'Transport' }}
                        </span>
                        @endif
                    </div>
                    @endif

                    <!-- CTA Button -->
                    <div class="mt-4">
                        @if($package->tours->isNotEmpty())
                        <a href="{{ route('tour-packages.show', $package->id) }}" 
                           class="w-full inline-flex items-center justify-center px-5 sm:px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                            <span>{{ __('messages.view_details') ?? 'View Details' }}</span>
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        @else
                        <button disabled class="w-full inline-flex items-center justify-center px-5 sm:px-6 py-3 bg-gray-300 text-gray-600 font-semibold rounded-full cursor-not-allowed text-sm sm:text-base">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('messages.no_tours_available') ?? 'No Tours Available' }}
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-12 sm:py-16">
                <div class="inline-block p-6 sm:p-8 bg-white rounded-2xl shadow-lg">
                    <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ __('messages.no_tour_packages') ?? 'No Tour Packages Available' }}</h3>
                    <p class="text-sm sm:text-base text-gray-500">{{ __('messages.check_back_soon') ?? 'Check back soon for exciting tour packages' }}</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($packages->hasPages())
        <div class="mt-8 sm:mt-12">
            <div class="bg-white rounded-xl shadow-md p-4">
                {{ $packages->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
