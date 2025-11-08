<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo-paradise.ico') }}">
    <title>Login - {{ config('app.name', 'Paradise Of Indonesia') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Tropical Background with Image */
        .tropical-bg {
            background-image: url('{{ asset('images/dark-leaf-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }
        
        .tropical-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 81, 50, 0.4);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        
        /* Glassmorphism Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        }
        
        /* Input Styling */
        .tropical-input {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(15, 81, 50, 0.2);
            transition: all 0.3s ease;
        }
        
        .tropical-input:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #0f5132;
            box-shadow: 0 0 0 3px rgba(15, 81, 50, 0.1);
        }
        
        /* Social Icons */
        .social-icon {
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen tropical-bg flex">
        <!-- Left Side - Welcome Section -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12 relative z-10">
            <div class="max-w-md text-white">
                <h1 class="text-5xl font-bold mb-6 leading-tight">
                    Let's Get Started
                </h1>
                <p class="text-lg text-white/90 leading-relaxed mb-8">
                    Welcome to Paradise of Indonesia! Sign in to explore breathtaking destinations, 
                    discover amazing tours, and create unforgettable memories across the beautiful 
                    archipelago. Your journey of a lifetime awaits.
                </p>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full glass-effect flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Paradise of Indonesia</p>
                        <p class="text-sm text-white/80">Your Journey Starts Here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12 relative z-10">
            <div class="w-full max-w-md">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Card -->
                <div class="glass-card rounded-2xl p-8 lg:p-10">
                    <!-- Mobile Logo (only on mobile) -->
                    <div class="lg:hidden text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Let's Get Started</h1>
                        <p class="text-gray-600 text-sm">Sign in to continue your journey</p>
                    </div>

                    <!-- Desktop Title -->
                    <div class="hidden lg:block mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                        <p class="text-gray-600">Sign in to your account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="tropical-input w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Enter your email"
                            />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-5">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="tropical-input w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Enter your password"
                            />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label for="remember_me" class="inline-flex items-center">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    name="remember" 
                                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                                />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Sign In Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                        >
                            Sign In
                        </button>
                    </form>

                    <!-- Social Login Divider -->
                    <div class="mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Or continue with</span>
                            </div>
                        </div>

                        <!-- Social Login Icons -->
                        <div class="mt-6 flex justify-center space-x-4">
                            <!-- Google -->
                            <a 
                                href="{{ route('google.login', ['return_to' => request('return_to')]) }}" 
                                class="social-icon w-12 h-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center hover:border-emerald-500 transition-all duration-200"
                                title="Sign in with Google"
                            >
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064 5.963 5.963 0 014.116 1.62l2.867-2.867A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                                </svg>
                            </a>

                            <!-- Facebook -->
                            <a 
                                href="#" 
                                class="social-icon w-12 h-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center hover:border-blue-500 transition-all duration-200"
                                title="Sign in with Facebook"
                                onclick="event.preventDefault(); alert('Facebook login coming soon!');"
                            >
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>

                            <!-- Twitter -->
                            <a 
                                href="#" 
                                class="social-icon w-12 h-12 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center hover:border-sky-500 transition-all duration-200"
                                title="Sign in with Twitter"
                                onclick="event.preventDefault(); alert('Twitter login coming soon!');"
                            >
                                <svg class="w-6 h-6 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-800">
                                Sign up here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
