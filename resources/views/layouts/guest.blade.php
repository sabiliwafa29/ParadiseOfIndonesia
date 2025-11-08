<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('logo-paradise.ico') }}">

        <title>{{ config('app.name', 'Paradise Of Indonesia') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background with gradient -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-emerald-50 via-white to-emerald-50">
            <!-- Logo and Brand -->
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center group">
                    <div class="w-20 h-20 mb-3 bg-emerald-600 rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-emerald-700">Paradise of Indonesia</h1>
                    <p class="text-sm text-gray-600 mt-1">Your Journey Starts Here</p>
                </a>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-emerald-100">
                {{ $slot }}
            </div>

            <!-- Footer Text -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Paradise of Indonesia. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
