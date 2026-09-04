<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-pnbtravel.jpeg') }}">
    
    <title>404 - Page Not Found | {{ config('app.name', 'PNB Travel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center">
            {{-- Animated Illustration --}}
            <div class="mb-8 relative">
                <div class="inline-block relative">
                    {{-- Background Circle --}}
                    <div class="absolute inset-0 bg-emerald-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                    
                    {{-- Main SVG --}}
                    <svg class="w-64 h-64 mx-auto relative z-10" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        {{-- Island --}}
                        <ellipse cx="100" cy="150" rx="80" ry="30" fill="#10B981" opacity="0.3"/>
                        <ellipse cx="100" cy="145" rx="70" ry="25" fill="#059669"/>
                        
                        {{-- Palm Tree --}}
                        <rect x="95" y="100" width="10" height="50" rx="5" fill="#92400E"/>
                        <path d="M85 100 Q70 80, 75 70 L100 95 Z" fill="#059669"/>
                        <path d="M100 95 L125 70 Q130 80, 115 100 Z" fill="#047857"/>
                        <path d="M90 90 Q85 75, 90 65 L100 95 Z" fill="#10B981"/>
                        <path d="M100 95 L110 65 Q115 75, 110 90 Z" fill="#10B981"/>
                        
                        {{-- Compass (404) --}}
                        <circle cx="100" cy="45" r="35" fill="white" stroke="#10B981" stroke-width="3"/>
                        <text x="100" y="55" font-family="Arial" font-size="24" font-weight="bold" fill="#059669" text-anchor="middle">404</text>
                        
                        {{-- Compass Points --}}
                        <path d="M100 15 L105 25 L100 23 L95 25 Z" fill="#EF4444"/>
                        <circle cx="100" cy="45" r="5" fill="#10B981"/>
                    </svg>
                </div>
            </div>

            {{-- Content --}}
            <div class="space-y-6">
                <div>
                    <h1 class="text-6xl font-extrabold text-gray-900 mb-2">
                        Oops!
                    </h1>
                    <h2 class="text-3xl font-bold text-gray-700 mb-4">
                        Page Not Found
                    </h2>
                    <p class="text-lg text-gray-600 max-w-md mx-auto">
                        It seems you've wandered off the beaten path. The page you're looking for doesn't exist or has been moved.
                    </p>
                </div>

                {{-- Search Suggestions --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 max-w-md mx-auto">
                    <p class="text-sm font-semibold text-gray-700 mb-4">Looking for something? Try these:</p>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition group">
                            <span class="text-gray-700 group-hover:text-emerald-600 font-medium">Home Page</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ route('tours.index') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition group">
                            <span class="text-gray-700 group-hover:text-emerald-600 font-medium">Browse Tours</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ route('destinations.index') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition group">
                            <span class="text-gray-700 group-hover:text-emerald-600 font-medium">Explore Destinations</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <button onclick="window.history.back()" 
                            class="inline-flex items-center px-6 py-3 bg-white border-2 border-emerald-500 text-emerald-600 font-semibold rounded-full hover:bg-emerald-50 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Go Back
                    </button>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:from-emerald-600 hover:to-teal-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>

            {{-- Footer Note --}}
            <p class="mt-12 text-sm text-gray-500">
                Error Code: 404 | {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>
</html>
