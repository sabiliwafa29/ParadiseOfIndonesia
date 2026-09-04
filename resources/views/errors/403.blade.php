<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-pnbtravel.jpeg') }}">
    
    <title>403 - Forbidden | {{ config('app.name', 'PNB Travel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center">
            {{-- Animated Illustration --}}
            <div class="mb-8 relative">
                <div class="inline-block relative">
                    {{-- Background Circle --}}
                    <div class="absolute inset-0 bg-amber-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                    
                    {{-- Main SVG --}}
                    <svg class="w-64 h-64 mx-auto relative z-10" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        {{-- Lock --}}
                        <rect x="75" y="90" width="50" height="60" rx="5" fill="#F59E0B" opacity="0.3"/>
                        <rect x="75" y="90" width="50" height="60" rx="5" stroke="#D97706" stroke-width="3" fill="none"/>
                        
                        {{-- Lock Shackle --}}
                        <path d="M85 90 V70 A15 15 0 0 1 115 70 V90" stroke="#D97706" stroke-width="3" fill="none" stroke-linecap="round"/>
                        
                        {{-- Keyhole --}}
                        <circle cx="100" cy="115" r="8" fill="#D97706"/>
                        <rect x="98" y="115" width="4" height="20" rx="2" fill="#D97706"/>
                        
                        {{-- 403 Text --}}
                        <text x="100" y="175" font-family="Arial" font-size="20" font-weight="bold" fill="#D97706" text-anchor="middle">403</text>
                        
                        {{-- Warning Lines --}}
                        <path d="M40 100 L60 100" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
                        <path d="M140 100 L160 100" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
                        <path d="M40 120 L55 120" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
                        <path d="M145 120 L160 120" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            {{-- Content --}}
            <div class="space-y-6">
                <div>
                    <h1 class="text-6xl font-extrabold text-gray-900 mb-2">
                        403
                    </h1>
                    <h2 class="text-3xl font-bold text-gray-700 mb-4">
                        Access Forbidden
                    </h2>
                    <p class="text-lg text-gray-600 max-w-md mx-auto">
                        You don't have permission to access this page. This area is restricted.
                    </p>
                </div>

                {{-- Info Box --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 max-w-md mx-auto">
                    <p class="text-sm font-semibold text-gray-700 mb-4">Why am I seeing this?</p>
                    <div class="space-y-3 text-left">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">You may not be logged in to the correct account</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">Your account doesn't have the required permissions</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">This content is restricted to authorized users only</p>
                        </div>
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

                @guest
                {{-- Login Prompt --}}
                <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <p class="text-sm text-blue-800">
                        Need access? 
                        <a href="{{ route('login') }}" class="font-semibold underline hover:text-blue-600">
                            Sign in to your account
                        </a>
                    </p>
                </div>
                @endguest
            </div>

            {{-- Footer Note --}}
            <p class="mt-12 text-sm text-gray-500">
                Error Code: 403 | {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>
</html>
