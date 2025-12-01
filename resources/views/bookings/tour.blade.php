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

                        <!-- Duration -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center text-gray-700 mb-3">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">{{ $tour->duration }} {{ __('messages.days') }}</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-semibold">{{ $tour->destination->location }}</span>
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
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-blue-700">{{ session('info') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Booking Form -->
                    <form action="{{ route('bookings.store-tour', $tour) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name (for guests) or show user name (for logged in) -->
                        @guest
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.full_name') ?? 'Full Name' }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                       placeholder="{{ __('messages.enter_full_name') ?? 'Enter your full name' }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.email') ?? 'Email' }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                       placeholder="{{ __('messages.enter_email') ?? 'Enter your email' }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.phone') ?? 'Phone Number' }} <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                       placeholder="{{ __('messages.enter_phone') ?? 'Enter your phone number' }}">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                                <p class="text-sm font-semibold text-emerald-800 mb-1">{{ __('messages.booking_as') ?? 'Booking as' }}</p>
                                <p class="text-emerald-900 font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-emerald-700">{{ auth()->user()->email }}</p>
                            </div>
                        @endguest

                        <!-- Tour Date -->
                        <div>
                            <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('messages.tour_date') ?? 'Tour Date' }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date') }}" 
                                   min="{{ date('Y-m-d') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('date') border-red-500 @enderror">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Number of Guests -->
                        <div>
                            <label for="guests" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('messages.number_of_guests') ?? 'Number of Guests' }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="guests" 
                                   name="guests" 
                                   value="{{ old('guests', $tour->min_guests ?? 1) }}" 
                                   min="{{ $tour->min_guests ?? 1 }}" 
                                   max="50"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('guests') border-red-500 @enderror">
                            @if(($tour->min_guests ?? 1) > 1)
                                <p class="mt-1 text-sm text-gray-500">{{ __('messages.min_guests_required', ['min' => $tour->min_guests]) ?? 'Minimum ' . $tour->min_guests . ' guests required for this tour' }}</p>
                            @endif
                            @error('guests')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Special Requests -->
                        <div>
                            <label for="special_requests" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('messages.special_requests') ?? 'Special Requests' }} <span class="text-gray-500">({{ __('messages.optional') ?? 'Optional' }})</span>
                            </label>
                            <textarea id="special_requests" 
                                      name="special_requests" 
                                      rows="4"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition @error('special_requests') border-red-500 @enderror"
                                      placeholder="{{ __('messages.enter_special_requests') ?? 'Any dietary requirements, accessibility needs, or other special requests...' }}">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="pt-4 border-t border-gray-200">
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
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" 
                                    class="w-full px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-lg font-bold rounded-full hover:from-emerald-700 hover:to-teal-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-emerald-300">
                                <span class="flex items-center justify-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('messages.proceed_to_payment') ?? 'Proceed to Payment' }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
