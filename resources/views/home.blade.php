@extends('layouts.app')
@section('content')

<!-- Background Music -->
<audio id="bg-music" loop>
    <source src="{{ asset('audio/bgm.mp3') }}" type="audio/mpeg">
</audio>

<!-- Modern Music Toggle Button -->
<button id="music-toggle" class="fixed bottom-20 right-4 md:right-6 w-14 h-14 md:w-16 md:h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-2xl hover:shadow-emerald-500/50 hover:scale-110 transition-all duration-300 flex items-center justify-center z-50 group">
    <svg id="music-icon" class="w-6 h-6 md:w-7 md:h-7 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
    </svg>
    <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse hidden" id="music-pulse"></span>
</button>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const audio = document.getElementById('bg-music');
        const btn = document.getElementById('music-toggle');
        const icon = document.getElementById('music-icon');
        const pulse = document.getElementById('music-pulse');
        let isPlaying = false;

        btn.onclick = () => {
            if (isPlaying) {
                audio.pause();
                pulse.classList.add('hidden');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>';
            } else {
                audio.play();
                pulse.classList.remove('hidden');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>';
            }
            isPlaying = !isPlaying;
        };
    });
</script>

<!-- Hero Slider with Modern Design -->
<div class="relative overflow-hidden bg-gradient-to-b from-gray-900 to-gray-800" x-data="{ currentSlide: 0 }" x-init="setInterval(() => { currentSlide = currentSlide === 3 ? 0 : currentSlide + 1 }, 5000)">
    <div class="relative h-[500px] md:h-[600px] lg:h-[700px]">
        
        <!-- Slide 1 - Bali -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 0"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/bali.jpg') }}" alt="Beautiful Bali" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-emerald-500/20 backdrop-blur-sm rounded-full border border-emerald-500/30 mb-4">
                        <span class="text-emerald-300 font-medium text-sm md:text-base">🌴 Island Paradise</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        Beautiful <span class="text-emerald-400">Bali</span>
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">Experience the magic of the Island of Gods</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                            Explore Now
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 2 - Raja Ampat -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 1"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/raja-ampat.jpg') }}" alt="Raja Ampat Paradise" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-blue-500/20 backdrop-blur-sm rounded-full border border-blue-500/30 mb-4">
                        <span class="text-blue-300 font-medium text-sm md:text-base">🌊 Underwater Wonder</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        Raja Ampat <span class="text-blue-400">Paradise</span>
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">Discover the world's best diving destination</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-blue-500/50 transform hover:scale-105 transition-all duration-300">
                            Explore Now
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 3 - Borobudur -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 2"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/borobudur.jpg') }}" alt="Borobudur Temple" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-amber-500/20 backdrop-blur-sm rounded-full border border-amber-500/30 mb-4">
                        <span class="text-amber-300 font-medium text-sm md:text-base">🏛️ Ancient Heritage</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        Majestic <span class="text-amber-400">Borobudur</span>
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">Journey through ancient Buddhist architecture</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-amber-500/50 transform hover:scale-105 transition-all duration-300">
                            Explore Now
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 4 - Komodo -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 3"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/komodo.jpg') }}" alt="Komodo Island" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-red-500/20 backdrop-blur-sm rounded-full border border-red-500/30 mb-4">
                        <span class="text-red-300 font-medium text-sm md:text-base">🦎 Wildlife Adventure</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        Komodo <span class="text-red-400">Adventure</span>
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">Meet the legendary dragons in their natural habitat</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-red-500/50 transform hover:scale-105 transition-all duration-300">
                            Explore Now
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modern Slider Navigation -->
    <div class="absolute bottom-8 left-0 right-0 flex justify-center items-center space-x-3">
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 0 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 0"></button>
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 1 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 1"></button>
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 2 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 2"></button>
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 3 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 3"></button>
    </div>
</div>

<!-- Why Choose Section - Modern Cards with Hover Effects -->
<div class="py-16 md:py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold mb-4">WHY CHOOSE US</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">{{ __('messages.why_choose') }}</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">{{ __('messages.tagline') }}</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Comfort -->
            <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-center text-gray-900 group-hover:text-emerald-600 transition-colors">{{ __('messages.comfort') }}</h3>
                    <p class="mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.comfort_desc') }}</p>
                </div>
            </div>

            <!-- Security -->
            <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-center text-gray-900 group-hover:text-blue-600 transition-colors">{{ __('messages.security') }}</h3>
                    <p class="mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.security_desc') }}</p>
                </div>
            </div>

            <!-- Affordable -->
            <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-center text-gray-900 group-hover:text-amber-600 transition-colors">{{ __('messages.affordable') }}</h3>
                    <p class="mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.affordable_desc') }}</p>
                </div>
            </div>

            <!-- Enjoy -->
            <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-center text-gray-900 group-hover:text-purple-600 transition-colors">{{ __('messages.enjoy') }}</h3>
                    <p class="mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.enjoy_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Best Tour Packages - Premium Design -->
<div class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold mb-4">BEST PACKAGES</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Paket Tour Terbaik</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">Jelajahi destinasi terbaik Indonesia bersama kami</p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tourPackages as $package)
            <div class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 right-4 bg-emerald-500 text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg">
                        Best Seller
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors">{{ $package->name }}</h3>
                    <p class="text-gray-600 mb-6 line-clamp-2 leading-relaxed">{{ $package->description }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-sm text-gray-500 block">Starting from</span>
                            <span class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($package->tours->isNotEmpty())
                            <a href="{{ route('tour-packages.show', $package->id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                                <span>View</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="px-6 py-3 bg-gray-300 text-gray-600 rounded-full font-semibold cursor-not-allowed">Sold Out</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Destinations - Magazine Style -->
<div class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">DESTINATIONS</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Popular Destinations</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">Explore Indonesia's most beloved destinations</p>
        </div>

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($destinations as $destination)
            <a href="{{ route('destinations.show', $destination) }}" class="group block relative overflow-hidden rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                    <div class="flex items-center text-white/80 text-sm mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $destination->location }}
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $destination->name }}</h3>
                    <div class="flex items-center text-white/90">
                        <span class="text-sm font-medium">Explore Destination</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-12 md:mt-16 text-center">
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-full shadow-xl hover:shadow-2xl hover:shadow-blue-500/50 transform hover:scale-105 transition-all duration-300">
                View All Destinations
                <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Featured Tours - Card Grid with Enhanced Design -->
<div class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">FEATURED TOURS</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Featured Tours</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">Curated experiences for unforgettable journeys</p>
        </div>

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tours as $tour)
            <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
                <div class="relative h-56 overflow-hidden">
                    <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" src="{{ asset($tour->image) }}" alt="{{ $tour->name }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <a href="{{ route('destinations.show', $tour->destination) }}" class="inline-block px-4 py-2 bg-white/90 backdrop-blur-sm text-emerald-600 rounded-full text-sm font-bold hover:bg-white transition-colors">
                            {{ $tour->destination->name }}
                        </a>
                    </div>
                </div>
                
                <div class="flex-1 p-6 md:p-8 flex flex-col">
                    <a href="{{ route('tours.show', $tour) }}" class="block">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors leading-tight">{{ $tour->name }}</h3>
                        <p class="text-gray-600 leading-relaxed line-clamp-3">{{ Str::limit($tour->description, 120) }}</p>
                    </a>
                    
                    <div class="mt-auto pt-6 flex items-center justify-between border-t border-gray-100">
                        <div class="flex items-center text-gray-500">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ $tour->duration }} days</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">From</div>
                            <div class="text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                ${{ number_format($tour->price, 0) }}
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('tours.show', $tour) }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                        View Details
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 md:mt-16 text-center">
            <a href="{{ route('tours.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-bold rounded-full shadow-xl hover:shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300">
                View All Tours
                <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Newsletter Section - Modern Design -->
<div class="py-16 md:py-24 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-block p-3 bg-white/20 backdrop-blur-sm rounded-2xl mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">Stay Updated!</h2>
            <p class="text-lg md:text-xl text-white/90 mb-8">Subscribe to our newsletter and get exclusive deals and travel tips</p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-4 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-white/50 shadow-xl">
                <button type="submit" class="px-8 py-4 bg-white text-emerald-600 font-bold rounded-full hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    Subscribe
                </button>
            </form>
            
            <p class="mt-6 text-white/70 text-sm">We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </div>
</div>

<!-- Custom Animations CSS -->
<style>
    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #10b981, #14b8a6);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #059669, #0d9488);
    }
</style>

@endsection