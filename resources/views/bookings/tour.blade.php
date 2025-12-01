@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8 sm:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tours.show', $tour) }}" 
               class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('messages.back_to_tour') ?? 'Back to Tour' }}
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Left Column - Tour Info -->
            <div class="lg:col-span-1">
                <!-- Tour Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-6">
                    <div class="relative h-48">
                        @if($tour->image)
                            @include('components.responsive-image', [
                                'path' => $tour->image,
                                'alt' => $tour->name,
                                'class' => 'w-full h-full object-cover',
                                'derivatives' => $tour->image_derivatives ?? null
                            ])
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h2 class="text-xl font-bold drop-shadow-lg">{{ $tour->name }}</h2>
                            <p class="text-sm text-white/90 mt-1">{{ $tour->destination->name }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Price -->
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-1">{{ __('messages.tour_price') ?? 'Tour Price' }}</p>
                            <p class="text-3xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                {{ format_price(get_price($tour)) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ __('messages.per_person') ?? 'per person' }}</p>
                        </div>

                        <!-- Tour Info Badges -->
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm font-semibold text-gray-700 mb-3">{{ __('messages.tour_details') ?? 'Tour Details' }}</p>
                            <div class="space-y-3">
                                <div class="flex items-center text-gray-700">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">{{ __('messages.duration') ?? 'Duration' }}</p>
                                        <p class="font-semibold text-sm">{{ $tour->duration }} {{ __('messages.days') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">{{ __('messages.location') ?? 'Location' }}</p>
                                        <p class="font-semibold text-sm">{{ $tour->destination->location }}</p>
                                    </div>
                                </div>
                                @if(($tour->min_guests ?? 1) > 1)
                                <div class="flex items-center text-gray-700">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">{{ __('messages.min_guests') ?? 'Min. Guests' }}</p>
                                        <p class="font-semibold text-sm">{{ $tour->min_guests }} {{ __('messages.persons') ?? 'persons' }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                            {{ __('messages.book_this_tour') ?? 'Book This Tour' }}
                        </h1>
                        <p class="text-gray-600">{{ __('messages.fill_booking_details') ?? 'Fill in your details to complete your booking' }}</p>
                    </div>

                    <!-- Alert Messages -->
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-red-800">{{ __('messages.error') ?? 'Error' }}</p>
                                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-blue-700 text-sm">{{ session('info') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Booking Form -->
                    <form action="{{ route('bookings.store-tour', $tour) }}" method="POST" class="space-y-6" id="booking-form">
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('messages.personal_information') ?? 'Personal Information' }}
                            </h3>

                            @guest
                                <!-- Full Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('messages.full_name') ?? 'Full Name' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                           placeholder="John Doe">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('messages.email') ?? 'Email Address' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                           placeholder="john@example.com">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('messages.phone') ?? 'WhatsApp / Phone Number' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                           placeholder="+62 812 3456 7890">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            @else
                                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm text-emerald-600 mb-0.5">{{ __('messages.booking_as') ?? 'Booking as' }}</p>
                                            <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                            <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endguest
                        </div>

                        <!-- Booking Details Section -->
                        <div class="space-y-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('messages.booking_details') ?? 'Booking Details' }}
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Tour Date -->
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('messages.select_date') ?? 'Select Date' }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           id="date" 
                                           name="date" 
                                           value="{{ old('date') }}" 
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('date') border-red-500 @enderror">
                                    @error('date')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Number of Guests -->
                                <div>
                                    <label for="guests" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('messages.number_of_guests') ?? 'Number of Guests' }} <span class="text-red-500">*</span>
                                    </label>
                                    @php
                                        $minGuests = $tour->min_guests ?? 1;
                                    @endphp
                                    <select id="guests" 
                                            name="guests"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('guests') border-red-500 @enderror"
                                            required>
                                        @for($i = $minGuests; $i <= 50; $i++)
                                            <option value="{{ $i }}" {{ old('guests', $minGuests) == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i == 1 ? (__('messages.guest') ?? 'Guest') : (__('messages.guests') ?? 'Guests') }}
                                            </option>
                                        @endfor
                                    </select>
                                    @if($minGuests > 1)
                                        <p class="mt-1 text-sm text-gray-500">{{ __('messages.min_guests_required', ['min' => $minGuests]) ?? 'Minimum ' . $minGuests . ' guests required for this tour' }}</p>
                                    @endif
                                    @error('guests')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Special Requests Section -->
                        <div class="space-y-4 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                {{ __('messages.special_requests') ?? 'Special Requests' }} 
                                <span class="ml-2 text-sm font-normal text-gray-500">({{ __('messages.optional') ?? 'Optional' }})</span>
                            </h3>
                            <textarea id="special_requests" 
                                      name="special_requests" 
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('special_requests') border-red-500 @enderror"
                                      placeholder="{{ __('messages.enter_special_requests') ?? 'Any dietary requirements, accessibility needs, or other special requests...' }}">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Price Summary -->
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border-2 border-emerald-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('messages.price_summary') ?? 'Price Summary' }}
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-gray-700">
                                    <span>{{ __('messages.base_price') ?? 'Base Price' }} <span class="text-gray-500">×</span> <span id="guest-count">{{ $tour->min_guests ?? 1 }}</span></span>
                                    <span id="base-price" class="font-semibold">{{ format_price(get_price($tour) * ($tour->min_guests ?? 1)) }}</span>
                                </div>
                                <div class="border-t border-emerald-200 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">{{ __('messages.total') ?? 'Total' }}</span>
                                        <span id="total-price" class="text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                            {{ format_price(get_price($tour) * ($tour->min_guests ?? 1)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="pt-4">
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" 
                                       name="terms" 
                                       required
                                       class="mt-1 w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                                <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 transition">
                                    {{ __('messages.i_agree_to') ?? 'I agree to the' }} 
                                    <a href="#" class="text-emerald-600 hover:text-emerald-700 font-semibold underline">{{ __('messages.terms_and_conditions') ?? 'Terms and Conditions' }}</a>
                                </span>
                            </label>
                            @error('terms')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="button"
                                    onclick="window.history.back()"
                                    class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                                {{ __('messages.cancel') ?? 'Cancel' }}
                            </button>
                            <button type="submit" 
                                    id="submit-booking" 
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg font-bold hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                <span id="button-text" class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('messages.proceed_to_payment') ?? 'Proceed to Payment' }}
                                </span>
                                <span id="button-loading" class="hidden flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('messages.processing') ?? 'Processing...' }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const guestsSelect = document.getElementById('guests');
    const bookingForm = document.getElementById('booking-form');
    const submitButton = document.getElementById('submit-booking');
    const buttonText = document.getElementById('button-text');
    const buttonLoading = document.getElementById('button-loading');
    const guestCountSpan = document.getElementById('guest-count');
    
    // Get price based on current locale/currency
    const basePrice = {{ get_price($tour) }};
    const currencySymbol = '{{ currency_symbol() }}';
    const locale = '{{ app()->getLocale() }}';
    const minGuests = {{ $tour->min_guests ?? 1 }};

    // Format number based on locale
    function formatPrice(amount) {
        if (locale === 'id') {
            return currencySymbol + ' ' + Math.round(amount).toLocaleString('id-ID');
        } else if (locale === 'zh') {
            return currencySymbol + amount.toLocaleString('zh-CN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        } else {
            return currencySymbol + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }

    function updatePrice() {
        const guests = parseInt(guestsSelect?.value) || minGuests;
        const total = basePrice * guests;

        if (guestCountSpan) {
            guestCountSpan.textContent = guests;
        }
        
        document.getElementById('base-price').textContent = formatPrice(total);
        document.getElementById('total-price').textContent = formatPrice(total);
    }

    if (guestsSelect) {
        guestsSelect.addEventListener('change', updatePrice);
    }

    // Initialize price
    updatePrice();

    // Form submission handler
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            // Show loading state
            if (submitButton && buttonText && buttonLoading) {
                submitButton.disabled = true;
                buttonText.classList.add('hidden');
                buttonLoading.classList.remove('hidden');
            }
        });
    }
});
</script>
@endsection
