@extends('layouts.app')
@section('content')
<!-- Background Music -->
<audio id="bg-music" loop>
    <source src="{{ asset('audio/bgm.mp3') }}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const audio = document.getElementById('bg-music');
        
        // Buat tombol play music yang selalu muncul
        const btn = document.createElement('button');
        btn.innerHTML = '🔊';
        btn.id = 'music-toggle';
        Object.assign(btn.style, {
            position: 'fixed',
            bottom: '90px',
            right: '20px',
            width: '56px',
            height: '56px',
            borderRadius: '50%',
            border: 'none',
            background: '#10B981',
            color: 'white',
            fontSize: '24px',
            cursor: 'pointer',
            boxShadow: '0 4px 12px rgba(0,0,0,0.2)',
            zIndex: '9999',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            transition: 'all 0.3s ease'
        });

        let isPlaying = false;

        btn.onclick = () => {
            if (isPlaying) {
                audio.pause();
                btn.innerHTML = '🔊';
                btn.style.background = '#10B981';
            } else {
                audio.play();
                btn.innerHTML = '🔇';
                btn.style.background = '#059669';
            }
            isPlaying = !isPlaying;
        };

        btn.onmouseenter = () => {
            btn.style.transform = 'scale(1.1)';
        };

        btn.onmouseleave = () => {
            btn.style.transform = 'scale(1)';
        };

        document.body.appendChild(btn);
    });
</script>

<!-- Image Slider (Responsive Height) -->
<div class="relative overflow-hidden" x-data="{ currentSlide: 0 }" x-init="setInterval(() => { currentSlide = currentSlide === 3 ? 0 : currentSlide + 1 }, 5000)">
    <div class="relative h-[400px] md:h-[500px] lg:h-[600px]">
        <!-- Slide 1 -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 0"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <img src="{{ asset('images/slider/bali.jpg') }}" alt="Beautiful beaches and temples in Bali, Indonesia" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-3xl">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Beautiful Bali</h2>
                    <p class="text-lg md:text-xl lg:text-2xl">Experience the magic of the Island of Gods</p>
                </div>
            </div>
        </div>
        
        <!-- Slide 2 -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 1"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <img src="{{ asset('images/slider/raja-ampat.jpg') }}" alt="Stunning underwater paradise in Raja Ampat, Indonesia" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-3xl">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Raja Ampat Paradise</h2>
                    <p class="text-lg md:text-xl lg:text-2xl">Discover the underwater wonder</p>
                </div>
            </div>
        </div>
        
        <!-- Slide 3 -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 2"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <img src="{{ asset('images/slider/borobudur.jpg') }}" alt="Ancient Borobudur Temple in Yogyakarta, Indonesia" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-3xl">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Majestic Borobudur</h2>
                    <p class="text-lg md:text-xl lg:text-2xl">Journey through ancient history</p>
                </div>
            </div>
        </div>
        
        <!-- Slide 4 -->
        <div x-cloak class="absolute inset-0" x-show="currentSlide === 3"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <img src="{{ asset('images/slider/komodo.jpg') }}" alt="Komodo dragons in their natural habitat, Komodo Island Indonesia" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center px-4">
                <div class="text-center text-white max-w-3xl">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Komodo Adventure</h2>
                    <p class="text-lg md:text-xl lg:text-2xl">Meet the legendary dragons</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Slider Navigation -->
    <div class="absolute bottom-5 left-0 right-0 flex justify-center space-x-2">
        <button class="w-3 h-3 rounded-full transition" :class="currentSlide === 0 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 0"></button>
        <button class="w-3 h-3 rounded-full transition" :class="currentSlide === 1 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 1"></button>
        <button class="w-3 h-3 rounded-full transition" :class="currentSlide === 2 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 2"></button>
        <button class="w-3 h-3 rounded-full transition" :class="currentSlide === 3 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 3"></button>
    </div>
</div>

<!-- Why Choose Paradise Of Indonesia -->
<div class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ __('messages.why_choose') }}</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-500">{{ __('messages.tagline') }}</p>
        </div>

        <div class="mt-8 md:mt-12 grid grid-cols-3 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Comfort -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">{{ __('messages.comfort') }}</h3>
                <p class="mt-2 text-gray-600 text-center">{{ __('messages.comfort_desc') }}</p>
            </div>

            <!-- Complete -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">{{ __('messages.complete') }}</h3>
                <p class="mt-2 text-gray-600 text-center">{{ __('messages.complete_desc') }}</p>
            </div>

            <!-- Affordable -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">{{ __('messages.affordable') }}</h3>
                <p class="mt-2 text-gray-600 text-center">{{ __('messages.affordable_desc') }}</p>
            </div>

            <!-- Enjoy -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">{{ __('messages.enjoy') }}</h3>
                <p class="mt-2 text-gray-600 text-center">{{ __('messages.enjoy_desc') }}</p>
            </div>
            
            <!-- Happy -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">{{ __('messages.happy') }}</h3>
                <p class="mt-2 text-gray-600 text-center">{{ __('messages.happy_desc') }}</p>
            </div>

            <!-- Custom Package -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">{{ __('messages.custom') }}</h3>
                <p class="mt-2 text-gray-600 text-center">{{ __('messages.custom_desc') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Best Tour Packages -->
<div class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Paket Tour Terbaik</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-500">Jelajahi destinasi terbaik Indonesia bersama kami</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tourPackages as $package)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover">
                <div class="p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-900">{{ $package->name }}</h3>
                    <p class="mt-2 text-sm md:text-base text-gray-600">{{ $package->description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-emerald-600 font-bold text-lg md:text-xl">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        @if($package->tours->isNotEmpty())
                            <a href="{{ route('tour-packages.show', $package->id) }}" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition text-sm md:text-base">View Details</a>
                        @else
                            <span class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed text-sm md:text-base">No Tours Available</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Destinations -->
<div class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Popular Destinations</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-500">Explore Indonesia's most beloved destinations</p>
        </div>

        <div class="mt-8 md:mt-12 grid gap-6 md:gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($destinations as $destination)
            <div class="group relative">
                <div class="relative w-full h-64 md:h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 transition">
                    <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                </div>
                <h3 class="mt-4 md:mt-6 text-base md:text-lg font-semibold text-gray-900">
                    <a href="{{ route('destinations.show', $destination) }}">
                        <span class="absolute inset-0"></span>
                        {{ $destination->name }}
                    </a>
                </h3>
                <p class="text-sm md:text-base text-gray-500">{{ $destination->location }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-8 md:mt-12 text-center">
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200 transition">
                View All Destinations
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Featured Tours -->
<div class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Featured Tours</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-500">Curated experiences for unforgettable journeys</p>
        </div>

        <div class="mt-8 md:mt-12 grid gap-6 md:gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tours as $tour)
            <div class="flex flex-col rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="flex-shrink-0">
                    <img class="h-48 w-full object-cover" src="{{ asset($tour->image) }}" alt="{{ $tour->name }}">
                </div>
                <div class="flex-1 bg-white p-4 md:p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-emerald-600">
                            <a href="{{ route('destinations.show', $tour->destination) }}" class="hover:underline">
                                {{ $tour->destination->name }}
                            </a>
                        </p>
                        <a href="{{ route('tours.show', $tour) }}" class="block mt-2">
                            <p class="text-lg md:text-xl font-semibold text-gray-900">{{ $tour->name }}</p>
                            <p class="mt-2 md:mt-3 text-sm md:text-base text-gray-500">{{ Str::limit($tour->description, 100) }}</p>
                        </a>
                    </div>
                    <div class="mt-4 md:mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span class="ml-2 text-sm md:text-base text-gray-500">{{ $tour->duration }} days</span>
                        </div>
                        <div class="text-lg md:text-xl font-bold text-emerald-600">${{ number_format($tour->price, 0) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 md:mt-12 text-center">
            <a href="{{ route('tours.index') }}" class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200 transition">
                View All Tours
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection