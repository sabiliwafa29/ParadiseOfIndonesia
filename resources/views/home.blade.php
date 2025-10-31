@extends('layouts.app')

@section('hero')
<!-- <div class="relative bg-gray-900 text-white"> -->
    <!-- Hero background image -->
    <!-- <div class="absolute inset-0">
        <img src="{{ asset('images/ranu-kumbolo.jpg') }}" alt="Beautiful Indonesia" class="w-full h-full object-cover opacity-50">
    </div> -->

    <!-- Hero content -->
    <!-- <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Discover Paradise in Indonesia</h1>
        <p class="mt-6 text-xl text-gray-300 max-w-3xl">Experience the beauty, culture, and adventure across thousands of islands. From pristine beaches to ancient temples, your dream vacation awaits.</p>
        <div class="mt-10">
            <a href="{{ route('tours.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                Explore Tours
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div> -->
<!-- </div> -->
@endsection

@section('content')
<!-- Image Slider -->
<div class="relative overflow-hidden" x-data="{ currentSlide: 0 }" x-init="setInterval(() => { currentSlide = currentSlide === 3 ? 0 : currentSlide + 1 }, 3000)">
    <div class="relative h-[600px]">
        <!-- Slide 1 -->
            <div x-cloak class="absolute inset-0" x-show="currentSlide === 0"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
            <img src="{{ asset('images/slider/bali.jpg') }}" alt="Bali" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-bold mb-4">Beautiful Bali</h2>
                    <p class="text-xl">Experience the magic of the Island of Gods</p>
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
            <img src="{{ asset('images/slider/raja-ampat.jpg') }}" alt="Raja Ampat" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-bold mb-4">Raja Ampat Paradise</h2>
                    <p class="text-xl">Discover the underwater wonder</p>
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
            <img src="{{ asset('images/slider/borobudur.jpg') }}" alt="Borobudur" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-bold mb-4">Majestic Borobudur</h2>
                    <p class="text-xl">Journey through ancient history</p>
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
            <img src="{{ asset('images/slider/komodo.jpg') }}" alt="Komodo Island" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-bold mb-4">Komodo Adventure</h2>
                    <p class="text-xl">Meet the legendary dragons</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Slider Navigation -->
    <div class="absolute bottom-5 left-0 right-0 flex justify-center space-x-2">
        <button class="w-3 h-3 rounded-full" :class="currentSlide === 0 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 0"></button>
        <button class="w-3 h-3 rounded-full" :class="currentSlide === 1 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 1"></button>
        <button class="w-3 h-3 rounded-full" :class="currentSlide === 2 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 2"></button>
        <button class="w-3 h-3 rounded-full" :class="currentSlide === 3 ? 'bg-white' : 'bg-white/50'" @click="currentSlide = 3"></button>
    </div>
</div>

<!-- Why Choose Paradise Of Indonesia -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Kenapa Memilih Paradise Of Indonesia?</h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">One click, Heaven in your hands</p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Kenyamanan -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">Kenyamanan</h3>
                <p class="mt-2 text-gray-600 text-center">Pelayanan prima dan fasilitas terbaik untuk kenyamanan perjalanan Anda</p>
            </div>

            <!-- Keamanan -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">Keamanan</h3>
                <p class="mt-2 text-gray-600 text-center">Jaminan keamanan dan asuransi perjalanan untuk ketenangan Anda</p>
            </div>

            <!-- Affordable -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">Affordable</h3>
                <p class="mt-2 text-gray-600 text-center">Harga terjangkau dengan kualitas layanan terbaik</p>
            </div>

            <!-- Enjoy -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-center text-gray-900">Enjoy</h3>
                <p class="mt-2 text-gray-600 text-center">Nikmati setiap momen perjalanan dengan pengalaman tak terlupakan</p>
            </div>
        </div>
    </div>
</div>

<!-- Best Tour Packages -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Paket Tour Terbaik</h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Jelajahi destinasi terbaik Indonesia bersama kami</p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tourPackages as $package)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $package->name }}</h3>
                    <p class="mt-2 text-gray-600">{{ $package->description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-emerald-600 font-bold text-xl">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        @if($package->tours->isNotEmpty())
                            <form action="{{ route('bookings.store', $package->tours->first()->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">Book Now</button>
                            </form>
                        @else
                            <a href="{{ route('tour-packages.show', $package->id) }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">No Tours Available</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Destinations -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Popular Destinations</h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Explore Indonesia's most beloved destinations</p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($destinations as $destination)
            <div class="group relative">
                <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1 lg:aspect-h-1">
                    <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                </div>
                <h3 class="mt-6 text-lg font-semibold text-gray-900">
                    <a href="{{ route('destinations.show', $destination) }}">
                        <span class="absolute inset-0"></span>
                        {{ $destination->name }}
                    </a>
                </h3>
                <p class="text-gray-500">{{ $destination->location }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200">
                View All Destinations
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Featured Tours -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Featured Tours</h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Curated experiences for unforgettable journeys</p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tours as $tour)
            <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                <div class="flex-shrink-0">
                    <img class="h-48 w-full object-cover" src="{{ asset($tour->image) }}" alt="{{ $tour->name }}">
                </div>
                <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-emerald-600">
                            <a href="{{ route('destinations.show', $tour->destination) }}" class="hover:underline">
                                {{ $tour->destination->name }}
                            </a>
                        </p>
                        <a href="{{ route('tours.show', $tour) }}" class="block mt-2">
                            <p class="text-xl font-semibold text-gray-900">{{ $tour->name }}</p>
                            <p class="mt-3 text-base text-gray-500">{{ Str::limit($tour->description, 100) }}</p>
                        </a>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span class="ml-2 text-gray-500">{{ $tour->duration }} days</span>
                        </div>
                        <div class="text-xl font-bold text-emerald-600">${{ number_format($tour->price, 0) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('tours.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200">
                View All Tours
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Why Choose Us</h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Experience the best of Indonesian travel with our expert guidance</p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mx-auto">
                    <i class="fas fa-map-marked-alt text-xl"></i>
                </div>
                <h3 class="mt-6 text-lg font-medium text-gray-900">Local Expertise</h3>
                <p class="mt-2 text-base text-gray-500">Deep knowledge of Indonesian culture and hidden gems</p>
            </div>

            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mx-auto">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <h3 class="mt-6 text-lg font-medium text-gray-900">Safe Travel</h3>
                <p class="mt-2 text-base text-gray-500">Your safety and comfort are our top priorities</p>
            </div>

            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mx-auto">
                    <i class="fas fa-hand-holding-heart text-xl"></i>
                </div>
                <h3 class="mt-6 text-lg font-medium text-gray-900">Personalized Service</h3>
                <p class="mt-2 text-base text-gray-500">Customized experiences tailored to your preferences</p>
            </div>

            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mx-auto">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <h3 class="mt-6 text-lg font-medium text-gray-900">Best Value</h3>
                <p class="mt-2 text-base text-gray-500">Competitive prices without compromising quality</p>
            </div>
        </div>
    </div>
</div>
@endsection
