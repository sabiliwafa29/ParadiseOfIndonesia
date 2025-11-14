@extends('layouts.app')
@section('content')

<!-- Background Music -->
<audio id="bg-music" autoplay loop>
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
    let autoplayAttempted = false;

    // Function to update button state
    function updateButtonState(playing) {
        isPlaying = playing;
        if (playing) {
            pulse.classList.remove('hidden');
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>';
        } else {
            pulse.classList.add('hidden');
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>';
        }
    }

    // Function to attempt autoplay (only for logged-in users)
    function attemptAutoplay() {
        // Check if user is logged in (you can pass this from Laravel)
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

        if (isLoggedIn && !autoplayAttempted) {
            autoplayAttempted = true;
            audio.play().then(() => {
                updateButtonState(true);
            }).catch(() => {
                // Autoplay failed, keep button in stopped state
                updateButtonState(false);
            });
        } else {
            // For guests or if autoplay already attempted, just show stopped state
            updateButtonState(false);
        }
    }

    // Try autoplay on page load (only for logged-in users)
    attemptAutoplay();

    // Handle manual play/pause
    btn.onclick = () => {
        if (isPlaying) {
            audio.pause();
            updateButtonState(false);
        } else {
            audio.play().then(() => {
                updateButtonState(true);
            }).catch(() => {
                // If play fails, keep in stopped state
                updateButtonState(false);
            });
        }
    };

    // Handle audio end
    audio.addEventListener('ended', () => {
        updateButtonState(false);
    });

    // Handle page visibility change (pause when tab is hidden)
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && isPlaying) {
            audio.pause();
            updateButtonState(false);
        }
    });
});

</script>

<!-- Hero Slider with Modern Design - 8 Slides -->
<div class="relative overflow-hidden bg-gradient-to-b from-gray-900 to-gray-800" x-data="{ currentSlide: 0 }" x-init="setInterval(() => { currentSlide = currentSlide === 7 ? 0 : currentSlide + 1 }, 5000)">
    <div class="relative h-[500px] md:h-[600px] lg:h-[700px]">
        
        <!-- Slide 1 - Bali -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 0"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/bali.jpg') }}" alt="{{ __('messages.slide_title1') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-emerald-500/20 backdrop-blur-sm rounded-full border border-emerald-500/30 mb-4">
                        <span class="text-emerald-300 font-medium text-sm md:text-base">🌴 {{ __('messages.island_paradise') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title1') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc1') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
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
            <img src="{{ asset('images/slider/raja-ampat.jpg') }}" alt="{{ __('messages.slide_title2') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-blue-500/20 backdrop-blur-sm rounded-full border border-blue-500/30 mb-4">
                        <span class="text-blue-300 font-medium text-sm md:text-base">🌊 {{ __('messages.underwater_wonder') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title2') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc2') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-blue-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
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
            <img src="{{ asset('images/slider/borobudur.jpg') }}" alt="{{ __('messages.slide_title3') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-amber-500/20 backdrop-blur-sm rounded-full border border-amber-500/30 mb-4">
                        <span class="text-amber-300 font-medium text-sm md:text-base">🏛️ {{ __('messages.ancient_heritage') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title3') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc3') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-amber-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
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
            <img src="{{ asset('images/slider/komodo.jpg') }}" alt="{{ __('messages.slide_title4') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-red-500/20 backdrop-blur-sm rounded-full border border-red-500/30 mb-4">
                        <span class="text-red-300 font-medium text-sm md:text-base">🦎 {{ __('messages.wildlife_adventure') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title4') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc4') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-red-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 5 - Kawah Ijen -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 4"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/bluefire-ijen.jpg') }}" alt="{{ __('messages.slide_title5') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-cyan-500/20 backdrop-blur-sm rounded-full border border-cyan-500/30 mb-4">
                        <span class="text-cyan-300 font-medium text-sm md:text-base">🔥 {{ __('messages.blue_fire_phenomenon') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title5') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc5') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-cyan-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 6 - Dieng -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 5"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/dieng-sunrise.jpg') }}" alt="{{ __('messages.slide_title6') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-purple-500/20 backdrop-blur-sm rounded-full border border-purple-500/30 mb-4">
                        <span class="text-purple-300 font-medium text-sm md:text-base">⛰️ {{ __('messages.volcanic_landscape') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title6') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc6') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 7 - Dieng-Culture -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 6"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/dieng-culture.jpg') }}" alt="{{ __('messages.slide_title7') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-orange-500/20 backdrop-blur-sm rounded-full border border-orange-500/30 mb-4">
                        <span class="text-orange-300 font-medium text-sm md:text-base">🏡 {{ __('messages.cultural_experience') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title7') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc7') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-orange-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 8 - Traditional Dance -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 7"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <img src="{{ asset('images/slider/traditional-dance.jpg') }}" alt="{{ __('messages.slide_title8') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-4xl space-y-6 animate-fade-in-up">
                    <div class="inline-block px-4 py-2 bg-pink-500/20 backdrop-blur-sm rounded-full border border-pink-500/30 mb-4">
                        <span class="text-pink-300 font-medium text-sm md:text-base">💃 {{ __('messages.living_heritage') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                        {{ __('messages.slide_title8') }}
                    </h2>
                    <p class="text-lg md:text-2xl lg:text-3xl text-gray-200 font-light">{{ __('messages.slide_desc8') }}</p>
                    <div class="pt-4">
                        <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 md:px-8 py-3 md:py-4 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-pink-500/50 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.explore_now') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modern Slider Navigation - 8 Dots -->
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
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 4 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 4"></button>
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 5 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 5"></button>
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 6 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 6"></button>
        <button class="w-12 h-1.5 rounded-full transition-all duration-300" 
                :class="currentSlide === 7 ? 'bg-white w-16' : 'bg-white/40 hover:bg-white/60'" 
                @click="currentSlide = 7"></button>
    </div>
</div>

<!-- Why Choose Section - Mobile Optimized: 2 rows x 3 columns -->
<div class="py-16 md:py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold mb-4">{{ strtoupper(__('messages.why_choose')) }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">{{ __('messages.why_choose') }}</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">{{ __('messages.tagline') }}</p>
        </div>

        <!-- Mobile: 2 rows x 3 columns, Desktop: 1 row x 3 columns -->
        <div class="grid grid-cols-3 gap-4 md:gap-8 lg:grid-cols-3">
            
            <!-- 1. Comfort -->
            <div class="group relative bg-white p-4 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 md:mt-6 text-sm md:text-xl font-bold text-center text-gray-900 group-hover:text-emerald-600 transition-colors">{{ __('messages.comfort') }}</h3>
                    <!-- Description hidden on mobile, shown on desktop -->
                    <p class="hidden md:block mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.comfort_desc') }}</p>
                </div>
            </div>

            <!-- 2. Complete -->
            <div class="group relative bg-white p-4 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 md:mt-6 text-sm md:text-xl font-bold text-center text-gray-900 group-hover:text-blue-600 transition-colors">{{ __('messages.complete') }}</h3>
                    <p class="hidden md:block mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.complete_desc') }}</p>
                </div>
            </div>

            <!-- 3. Affordable -->
            <div class="group relative bg-white p-4 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 md:mt-6 text-sm md:text-xl font-bold text-center text-gray-900 group-hover:text-amber-600 transition-colors">{{ __('messages.affordable') }}</h3>
                    <p class="hidden md:block mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.affordable_desc') }}</p>
                </div>
            </div>

            <!-- 4. Enjoy -->
            <div class="group relative bg-white p-4 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 md:mt-6 text-sm md:text-xl font-bold text-center text-gray-900 group-hover:text-purple-600 transition-colors">{{ __('messages.enjoy') }}</h3>
                    <p class="hidden md:block mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.enjoy_desc') }}</p>
                </div>
            </div>

            <!-- 5. Happy -->
            <div class="group relative bg-white p-4 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 md:mt-6 text-sm md:text-xl font-bold text-center text-gray-900 group-hover:text-pink-600 transition-colors">{{ __('messages.happy') }}</h3>
                    <p class="hidden md:block mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.happy_desc') }}</p>
                </div>
            </div>

            <!-- 6. Custom -->
            <div class="group relative bg-white p-4 md:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl md:rounded-2xl flex items-center justify-center mx-auto transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="mt-3 md:mt-6 text-sm md:text-xl font-bold text-center text-gray-900 group-hover:text-indigo-600 transition-colors">{{ __('messages.custom') }}</h3>
                    <p class="hidden md:block mt-3 text-gray-600 text-center leading-relaxed">{{ __('messages.custom_desc') }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Best Tour Packages - Premium Design -->
<div class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold mb-4">{{ __('messages.best_packages_label') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">{{ __('messages.best_packages') }}</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">{{ __('messages.best_packages_desc') }}</p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tourPackages as $package)
            <div class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 right-4 bg-emerald-500 text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg">
                        {{ __('messages.best_seller') }}
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors">{{ $package->name }}</h3>
                    <p class="text-gray-600 mb-6 line-clamp-2 leading-relaxed">{{ $package->description }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-sm text-gray-500 block">{{ __('messages.starting_from') }}</span>
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
                            <span class="px-6 py-3 bg-gray-300 text-gray-600 rounded-full font-semibold cursor-not-allowed">{{ __('messages.sold_out') }}</span>
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
            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">{{ __('messages.destinations_label') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">{{ __('messages.popular_destinations') }}</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">{{ __('messages.popular_destinations_desc') }}</p>
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
                        <span class="text-sm font-medium">{{ __('messages.explore_destination') }}</span>
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
                {{ __('messages.view_all_destinations') }}
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
            <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">{{ __('messages.featured_tours_label') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">{{ __('messages.featured_tours') }}</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-600">{{ __('messages.featured_tours_desc') }}</p>
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
                            <span class="font-medium">{{ $tour->duration }} {{ __('messages.days') }}</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">{{ __('messages.from') }}</div>
                            <div class="text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                ${{ number_format($tour->price, 0) }}
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('tours.show', $tour) }}" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">
                        {{ __('messages.view_details') }}
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
                {{ __('messages.view_all_tours') }}
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
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.stay_updated') }}</h2>
            <p class="text-lg md:text-xl text-white/90 mb-8">{{ __('messages.subscribe_newsletter') }}</p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-4 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-white/50 shadow-xl">
                <button type="submit" class="px-8 py-4 bg-white text-emerald-600 font-bold rounded-full hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    Subscribe
                </button>
            </form>
            
            <p class="mt-6 text-white/70 text-sm">{{ __('messages.privacy_notice') }}</p>
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