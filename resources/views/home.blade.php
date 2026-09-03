@extends('layouts.app')
@section('content')

<!-- Hero Section - PNB Travel Slideshow -->
<section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center overflow-hidden" id="hero-section">

    <!-- Slideshow Background -->
    <div class="absolute inset-0 hero-slideshow" id="heroSlideshow">
        <!-- Slide 1: Hiace -->
        <div class="hero-slide active" style="background-image: url('/images/hero/slideshow/hiace.jpg');">
            <div class="slide-caption">{{ __('messages.hero_slide_hiace') }}</div>
        </div>
        <!-- Slide 2: Xenia -->
        <div class="hero-slide" style="background-image: url('/images/hero/slideshow/xenia.jpg');">
            <div class="slide-caption">{{ __('messages.hero_slide_xenia') }}</div>
        </div>
        <!-- Slide 3: Avanza -->
        <div class="hero-slide" style="background-image: url('/images/hero/slideshow/avanza.jpg');">
            <div class="slide-caption">{{ __('messages.hero_slide_avanza') }}</div>
        </div>
        <!-- Slide 4: Bus -->
        <div class="hero-slide" style="background-image: url('/images/hero/slideshow/bus.jpg');">
            <div class="slide-caption">{{ __('messages.hero_slide_bus') }}</div>
        </div>
        <!-- Slide 5: Travel Van -->
        <div class="hero-slide" style="background-image: url('/images/hero/slideshow/travel-van.jpg');">
            <div class="slide-caption">{{ __('messages.hero_slide_van') }}</div>
        </div>
    </div>

    <!-- Dark Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70 z-10"></div>

    <!-- Subtle blue light effect -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[500px] h-[300px] bg-blue-500/15 rounded-full blur-3xl z-10"></div>

    <!-- Main Content -->
    <div class="relative z-20 max-w-5xl mx-auto px-4 text-center">
        <!-- Brand Badge -->
        <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
            <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <span class="text-yellow-200 font-bold text-sm tracking-widest uppercase">{{ __('messages.hero_brand') }}</span>
        </div>

        <!-- Main Heading -->
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-4 leading-tight drop-shadow-2xl">
            {{ __('messages.hero_welcome') }}
        </h1>

        <!-- Description Text -->
        <p class="text-base md:text-lg lg:text-xl text-white/85 max-w-3xl mx-auto mb-10 leading-relaxed drop-shadow-lg font-light">
            {{ __('messages.hero_description') }}
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#services" class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-900 font-bold rounded-full shadow-2xl hover:shadow-white/20 transform hover:scale-105 transition-all duration-300 text-lg">
                {{ __('messages.view_all') }} {{ __('messages.travel_services') }}
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
            <a href="https://wa.me/6281585333325?text=Halo,%20saya%20tertarik%20dengan%20layanan%20PNB%20Travel" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white/30 text-white font-bold rounded-full hover:bg-white/10 transform hover:scale-105 transition-all duration-300 text-lg">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                {{ __('messages.contact_us') }}
            </a>
        </div>

        <!-- Trust Badges -->
        <div class="mt-14 flex flex-wrap justify-center gap-8 text-blue-200/60">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="text-sm font-medium">Licensed & Official</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">24/7 Support</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm font-medium">1000+ Partners</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">All Indonesia</span>
            </div>
        </div>
    </div>

    <!-- Slide Indicators (Dots) -->
    <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 z-20 flex gap-2" id="slideIndicators">
        <button class="slide-dot active" data-index="0" aria-label="Slide 1"></button>
        <button class="slide-dot" data-index="1" aria-label="Slide 2"></button>
        <button class="slide-dot" data-index="2" aria-label="Slide 3"></button>
        <button class="slide-dot" data-index="3" aria-label="Slide 4"></button>
        <button class="slide-dot" data-index="4" aria-label="Slide 5"></button>
    </div>

    <!-- Navigation Arrows -->
    <button class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-200 border border-white/20" id="heroPrev" aria-label="Previous slide">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-200 border border-white/20" id="heroNext" aria-label="Next slide">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<style>
/* Hero Slideshow Styles */
.hero-slideshow {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.hero-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
}
.hero-slide.active {
    opacity: 1;
}
.slide-caption {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(8px);
    color: rgba(255,255,255,0.85);
    font-size: 0.75rem;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.15);
    letter-spacing: 0.03em;
    z-index: 5;
}
.slide-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}
.slide-dot.active {
    background: white;
    transform: scale(1.3);
}
.slide-dot:hover {
    background: rgba(255,255,255,0.7);
}
</style>

<script>
(function() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slide-dot');
    let currentIndex = 0;
    let autoplayInterval;

    function goToSlide(index) {
        slides[currentIndex].classList.remove('active');
        dots[currentIndex].classList.remove('active');
        currentIndex = (index + slides.length) % slides.length;
        slides[currentIndex].classList.add('active');
        dots[currentIndex].classList.add('active');
    }

    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 2000);
    }

    function resetAutoplay() {
        clearInterval(autoplayInterval);
        startAutoplay();
    }

    // Dot click handlers
    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            goToSlide(parseInt(this.dataset.index));
            resetAutoplay();
        });
    });

    // Arrow click handlers
    var prevBtn = document.getElementById('heroPrev');
    var nextBtn = document.getElementById('heroNext');
    if (prevBtn) prevBtn.addEventListener('click', function() { prevSlide(); resetAutoplay(); });
    if (nextBtn) nextBtn.addEventListener('click', function() { nextSlide(); resetAutoplay(); });

    // Pause on hover
    var heroSection = document.getElementById('hero-section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', function() { clearInterval(autoplayInterval); });
        heroSection.addEventListener('mouseleave', function() { startAutoplay(); });
    }

    // Start autoplay
    startAutoplay();
})();
</script>


<!-- Travel Services Section - Main Content -->
<section id="services" class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 md:mb-20">
            <span class="inline-block px-5 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold mb-6 uppercase tracking-wider">{{ __('messages.travel_services') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6">{{ __('messages.our_travel_services') }}</h2>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">{{ __('messages.travel_services_desc') }}</p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            @foreach($travelServices as $service)
            <div class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 flex flex-col">
                <!-- Image -->
                <div class="relative h-56 overflow-hidden">
                    @if($service->image)
                        <img src="{{ asset($service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    @endif
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <!-- Type Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-block px-4 py-1.5 bg-blue-600 text-white rounded-full text-xs font-bold shadow-lg uppercase tracking-wide">{{ $service->type }}</span>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="flex-1 p-6 md:p-8 flex flex-col">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors leading-tight">{{ $service->name }}</h3>
                    <p class="text-gray-600 leading-relaxed line-clamp-3 mb-6">{{ Str::limit($service->description, 150) }}</p>
                    
                    <!-- Price & CTA -->
                    <div class="mt-auto pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-sm text-gray-500 block">{{ __('messages.starting_from') }}</span>
                                <span class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    {{ format_price($service->price) }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('travel-services.show', $service) }}" class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.view_details') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 md:py-28 bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 relative overflow-hidden">
    <!-- Gradient Orbs -->
    <div class="absolute top-10 right-20 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 left-20 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-5 py-2 bg-white/10 text-blue-300 rounded-full text-sm font-bold mb-6 uppercase tracking-wider border border-white/10">{{ __('messages.why_choose') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-6">{{ __('messages.tagline') }}</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
            $features = [
                ['icon' => 'M5 13l4 4L19 7', 'name' => __('messages.comfort'), 'desc' => __('messages.comfort_desc'), 'color' => 'emerald'],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => __('messages.complete'), 'desc' => __('messages.complete_desc'), 'color' => 'blue'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => __('messages.affordable'), 'desc' => __('messages.affordable_desc'), 'color' => 'amber'],
                ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => __('messages.enjoy'), 'desc' => __('messages.enjoy_desc'), 'color' => 'purple'],
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'name' => __('messages.happy'), 'desc' => __('messages.happy_desc'), 'color' => 'pink'],
                ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'name' => __('messages.custom'), 'desc' => __('messages.custom_desc'), 'color' => 'indigo'],
            ];
            @endphp

            @foreach($features as $feature)
            <div class="group text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-{{ $feature['color'] }}-400 to-{{ $feature['color'] }}-600 rounded-2xl flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-all duration-300 shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="text-white font-bold mb-2">{{ $feature['name'] }}</h3>
                <p class="text-blue-200/60 text-sm hidden md:block">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 md:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-10 md:p-16 border border-blue-100">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-6">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ __('messages.stay_updated') }}</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">{{ __('messages.subscribe_newsletter') }}</p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email" placeholder="{{ __('messages.enter_email') }}" class="flex-1 px-6 py-4 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 border border-gray-200 shadow-sm">
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transform hover:scale-105 transition-all duration-300">
                    {{ __('messages.subscribe') }}
                </button>
            </form>
            
            <p class="mt-6 text-gray-400 text-sm">{{ __('messages.privacy_notice') }}</p>
        </div>
    </div>
</section>

@endsection
