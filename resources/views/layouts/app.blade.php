<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('logo-pnbtravel.jpeg') }}">

        <title>@yield('title', config('app.name', 'PNB Travel'))</title>

        {{-- Primary SEO meta (per-page overrides available via @section) --}}
        <meta name="description" content="@yield('meta_description', 'Explore tours, packages and travel services in Indonesia. Find curated experiences across Bali, Bromo, and beyond with PNB Travel.')">
        <meta name="keywords" content="@yield('meta_keywords', 'Indonesia tour, Bali tour, Bromo, travel, tour packages, PNB Travel')">
        <meta name="robots" content="@yield('meta_robots', 'index,follow')">
        <link rel="canonical" href="@yield('canonical', url()->current())">

        {{-- Hreflang / locale hints (adjust per-site routing if you have localized URLs) --}}
        <link rel="alternate" hreflang="en" href="{{ url('/') }}">
        <link rel="alternate" hreflang="id" href="{{ url('/') }}">
        <link rel="alternate" hreflang="zh" href="{{ url('/') }}">
        <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

        {{-- OpenGraph / Twitter Card defaults (per-page overrides via sections) --}}
        @php
            $ogTitle = trim($__env->yieldContent('og_title') ?: $__env->yieldContent('title') ?: config('app.name','PNB Travel'));
            $metaDescription = trim($__env->yieldContent('og_description') ?: $__env->yieldContent('meta_description') ?: 'Explore tours, packages and travel services in Indonesia with PNB Travel.');
            $ogUrl = trim($__env->yieldContent('og_url') ?: url()->current());
            $ogImage = trim($__env->yieldContent('og_image') ?: asset('images/og-default.jpg'));
            $twitterTitle = trim($__env->yieldContent('twitter_title') ?: $ogTitle);
            $twitterDesc = trim($__env->yieldContent('twitter_description') ?: $metaDescription);
            $twitterImage = trim($__env->yieldContent('twitter_image') ?: $ogImage);
        @endphp

        <meta property="og:site_name" content="{{ config('app.name', 'PNB Travel') }}">
        <meta property="og:title" content="{{ $ogTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:url" content="{{ $ogUrl }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $twitterTitle }}">
        <meta name="twitter:description" content="{{ $twitterDesc }}">
        <meta name="twitter:image" content="{{ $twitterImage }}">

    {{-- Search console verifications (set via config/services.php -> search_console) --}}
    <meta name="google-site-verification" content="{{ config('services.search_console.google_verification', '') }}">
    <meta name="baidu-site-verification" content="{{ config('services.search_console.baidu_verification', '') ?: $__env->yieldContent('baidu_site_verification') }}">
        <meta name="renderer" content="webkit">

        {{-- JSON-LD structured data: Organization + WebSite (basic) --}}
        <script type="application/ld+json">
            {
                "@@context": "https://schema.org",
                "@@type": "Organization",
                "name": "{{ config('app.name', 'PNB Travel') }}",
                "url": "{{ url('/') }}",
                "logo": "{{ asset('logo-pnbtravel.jpeg') }}",
                "sameAs": []
            }
        </script>

    <!-- Performance: preconnect & preload hints. Pages can push additional hints to the `preload` stack -->
    @php
        // Determine an asset host to preconnect to (ASSET_URL or APP_URL)
        $assetUrl = config('app.asset_url') ?: env('ASSET_URL') ?: config('app.url');
        $assetUrl = $assetUrl ? rtrim($assetUrl, '/') : null;
    @endphp
    @if($assetUrl)
        <link rel="preconnect" href="{{ $assetUrl }}" crossorigin>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    @stack('preload') {{-- allow pages to @push('preload') their critical assets (fonts/images) --}}
    <!-- Fonts (prefer system fonts to avoid external CSS where possible) -->

        <!-- Alpine.js x-cloak fix -->
        <style>
            [x-cloak] { 
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    <!-- SweetAlert2 CSS (self-hosted to comply with CSP) -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2.min.css') }}">
    </head>
    
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Hero (optional) -->
            @hasSection('hero')
                <section class="pt-20">
                    @yield('hero')
                </section>
            @endif

            <!-- Page Heading (optional) -->
            @if (isset($header))
                <header class="bg-white shadow mt-20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pt-20">
                {{-- support both sections used across the project --}}
                @yield('content')
                @yield('main')
            </main>

            <!-- Footer -->
            @include('layouts.footer')
            
            <!-- WhatsApp Button -->
            <a href="https://wa.me/6281585333325?text=Halo,%20saya%20tertarik%20dengan%20paket%20wisata%20di%20PNB%20Travel"
                target="_blank"
                class="fixed bottom-6 right-6 bg-[#25D366] text-white rounded-full p-4 flex items-center gap-2 shadow-lg hover:bg-[#128C7E] transition-all duration-300 group z-50">
                <!-- WhatsApp Icon -->
                <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                </svg>
                <span class="font-medium hidden group-hover:inline-block transition-all duration-300">Chat with Us</span>
            </a>

            @stack('scripts')
        </div>
        
        <!-- Loading Overlay -->
        <x-loading-overlay />
        
        <!-- Login Success Popup -->
        <x-login-success-popup />

    <!-- SweetAlert2 JS (self-hosted to comply with CSP) -->
    <script src="{{ asset('vendor/sweetalert2.all.min.js') }}"></script>

        <!-- Notifikasi Script - PINDAHKAN KE SINI -->
        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        @endif

        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#10b981',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
        @endif

        <!-- Browser Geolocation Detection -->
        <script>
            (function() {
                // Check if we already have location stored
                const locationStored = localStorage.getItem('poi_location_stored');
                const locationTimestamp = localStorage.getItem('poi_location_timestamp');
                const oneDay = 24 * 60 * 60 * 1000; // 24 hours in ms
                
                // Only request location if not stored or older than 24 hours
                if (!locationStored || !locationTimestamp || (Date.now() - parseInt(locationTimestamp)) > oneDay) {
                    if ('geolocation' in navigator) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                // Success - send to server
                                fetch('/api/user-location', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        latitude: position.coords.latitude,
                                        longitude: position.coords.longitude
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        console.log('Location detected:', data.country_code, '(' + data.market + ')');
                                        localStorage.setItem('poi_location_stored', data.country_code);
                                        localStorage.setItem('poi_location_timestamp', Date.now().toString());
                                        localStorage.setItem('poi_market', data.market);
                                        
                                        // Reload page if market changed to refresh tour list
                                        const previousMarket = localStorage.getItem('poi_previous_market');
                                        if (previousMarket && previousMarket !== data.market) {
                                            window.location.reload();
                                        }
                                        localStorage.setItem('poi_previous_market', data.market);
                                    }
                                })
                                .catch(error => console.log('Location API error:', error));
                            },
                            function(error) {
                                // Error or denied - use IP-based fallback (handled server-side)
                                console.log('Geolocation denied or unavailable, using IP detection');
                            },
                            {
                                enableHighAccuracy: false,
                                timeout: 10000,
                                maximumAge: 86400000 // 24 hours cache
                            }
                        );
                    }
                }
            })();
        </script>

    </body>
</html>
