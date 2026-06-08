<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-paradise.ico') }}">
    
    <title>500 - Server Error | {{ config('app.name', 'Paradise Of Indonesia') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center">
            {{-- Animated Illustration --}}
            <div class="mb-8 relative">
                <div class="inline-block relative">
                    {{-- Background Circle --}}
                    <div class="absolute inset-0 bg-red-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                    
                    {{-- Main SVG --}}
                    <svg class="w-64 h-64 mx-auto relative z-10" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        {{-- Server/Computer --}}
                        <rect x="50" y="60" width="100" height="80" rx="8" fill="#EF4444" opacity="0.2"/>
                        <rect x="50" y="60" width="100" height="80" rx="8" stroke="#DC2626" stroke-width="3" fill="none"/>
                        
                        {{-- Screen --}}
                        <rect x="60" y="70" width="80" height="50" rx="4" fill="white"/>
                        
                        {{-- Error Symbol (X) --}}
                        <path d="M85 85 L115 105" stroke="#DC2626" stroke-width="4" stroke-linecap="round"/>
                        <path d="M115 85 L85 105" stroke="#DC2626" stroke-width="4" stroke-linecap="round"/>
                        
                        {{-- 500 Text --}}
                        <text x="100" y="145" font-family="Arial" font-size="20" font-weight="bold" fill="#DC2626" text-anchor="middle">500</text>
                        
                        {{-- Warning Signs --}}
                        <circle cx="40" cy="50" r="8" fill="#FDE047" stroke="#EAB308" stroke-width="2"/>
                        <text x="40" y="54" font-family="Arial" font-size="10" font-weight="bold" fill="#854D0E" text-anchor="middle">!</text>
                        
                        <circle cx="160" cy="50" r="8" fill="#FDE047" stroke="#EAB308" stroke-width="2"/>
                        <text x="160" y="54" font-family="Arial" font-size="10" font-weight="bold" fill="#854D0E" text-anchor="middle">!</text>
                    </svg>
                </div>
            </div>

            {{-- Content --}}
            <div class="space-y-6">
                <div>
                    <h1 class="text-6xl font-extrabold text-gray-900 mb-2">
                        500
                    </h1>
                    <h2 class="text-3xl font-bold text-gray-700 mb-4">
                        Server Error
                    </h2>
                    <p class="text-lg text-gray-600 max-w-md mx-auto">
                        Oops! Something went wrong on our end. Our team has been notified and we're working to fix the issue.
                    </p>
                </div>

                {{-- What to do --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 max-w-md mx-auto">
                    <p class="text-sm font-semibold text-gray-700 mb-4">What you can do:</p>
                    <div class="space-y-3 text-left">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">Try refreshing the page</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">Wait a few minutes and try again</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">Go back to the homepage</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-gray-600">Contact support if the problem persists</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <button onclick="window.location.reload()" 
                            class="inline-flex items-center px-6 py-3 bg-white border-2 border-emerald-500 text-emerald-600 font-semibold rounded-full hover:bg-emerald-50 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh Page
                    </button>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:from-emerald-600 hover:to-teal-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Back to Home
                    </a>
                </div>

                {{-- Contact Support --}}
                <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <p class="text-sm text-blue-800">
                        <strong>Need immediate help?</strong> Contact our support team via 
                        <a href="https://wa.me/6281585333325" target="_blank" class="font-semibold underline hover:text-blue-600">
                            WhatsApp
                        </a>
                    </p>
                </div>
            </div>

            {{-- Footer Note --}}
            <p class="mt-12 text-sm text-gray-500">
                Error Code: 500 | {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>
</html>
