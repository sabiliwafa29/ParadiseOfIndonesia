@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header with Back Button --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.bookings.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Bookings
                </a>
            </div>
            
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Details</h1>
                    <p class="text-gray-600">Order ID: <span class="font-mono font-semibold text-gray-800">{{ $booking->order_id ?? '#' . $booking->id }}</span></p>
                </div>
                
                {{-- Status Badge --}}
                <div>
                    <span class="px-6 py-3 rounded-full text-sm font-bold inline-flex items-center shadow-lg
                        {{ $booking->status === 'completed' ? 'bg-green-100 text-green-700 ring-2 ring-green-300' : 
                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700 ring-2 ring-yellow-300' : 
                           ($booking->status === 'confirmed' ? 'bg-blue-100 text-blue-700 ring-2 ring-blue-300' : 'bg-red-100 text-red-700 ring-2 ring-red-300')) }}">
                        @if($booking->status === 'completed')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($booking->status === 'pending')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($booking->status === 'confirmed')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Tour/Package Information --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Booking Information
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @if($booking->tour)
                            {{-- Tour Booking --}}
                            <div class="flex items-start space-x-4 mb-6">
                                @if($booking->tour->image)
                                    <img src="{{ asset('storage/' . $booking->tour->image) }}" 
                                         alt="Tour" 
                                         class="w-24 h-24 rounded-lg object-cover shadow-md">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Tour</p>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        {{ \App\Helpers\LanguageHelper::get($booking->tour, 'name') }}
                                    </h3>
                                    @if($booking->tour->destination)
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ \App\Helpers\LanguageHelper::get($booking->tour->destination, 'name') }}
                                        </p>
                                    @endif
                                    @if($booking->tour->duration)
                                        <p class="text-sm text-gray-600 flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $booking->tour->duration }} days
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @elseif($booking->package)
                            {{-- Package Booking --}}
                            <div class="flex items-start space-x-4 mb-6">
                                @if($booking->package->image)
                                    <img src="{{ asset('storage/' . $booking->package->image) }}" 
                                         alt="Package" 
                                         class="w-24 h-24 rounded-lg object-cover shadow-md">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <p class="text-xs text-purple-600 font-semibold mb-1">PACKAGE</p>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        {{ \App\Helpers\LanguageHelper::get($booking->package, 'name') }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Complete tour package with multiple destinations
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p>No tour or package information</p>
                            </div>
                        @endif

                        {{-- Booking Details Grid --}}
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-xs text-gray-600 mb-1">Travel Date</p>
                                <p class="text-lg font-bold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $booking->date ? $booking->date->format('M d, Y') : 'Not set' }}
                                </p>
                            </div>
                            
                            <div class="bg-green-50 rounded-lg p-4">
                                <p class="text-xs text-gray-600 mb-1">Number of Guests</p>
                                <p class="text-lg font-bold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $booking->guests ?? 1 }} {{ $booking->guests > 1 ? 'People' : 'Person' }}
                                </p>
                            </div>
                        </div>

                        {{-- Additional Services --}}
                        @if($booking->guide_service || $booking->transport_service)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Additional Services</p>
                                <div class="flex flex-wrap gap-2">
                                    @if($booking->guide_service)
                                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            Tour Guide
                                        </span>
                                    @endif
                                    @if($booking->transport_service)
                                        <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                            </svg>
                                            Transport
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Customer Information
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @php
                            $customerName = $booking->user->name ?? $booking->full_name ?? 'Guest';
                            $customerEmail = $booking->user->email ?? $booking->email ?? null;
                            $isGuest = !$booking->user_id;
                        @endphp

                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br {{ $isGuest ? 'from-gray-400 to-gray-600' : 'from-emerald-400 to-teal-500' }} flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                {{ substr($customerName, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                    {{ $customerName }}
                                    @if($isGuest)
                                        <span class="ml-2 px-3 py-1 bg-gray-200 text-gray-700 text-xs rounded-full font-semibold">Guest Booking</span>
                                    @endif
                                </h3>
                                <p class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $customerEmail ?? 'No email provided' }}
                                </p>
                            </div>
                        </div>

                        @if($booking->contact_handle)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Contact</p>
                                <p class="font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $booking->contact_handle }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                
                {{-- Payment Information --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Payment
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Total Amount</p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ format_price_by_currency($booking->total_price ?? 0, $booking->currency ?? current_currency()) }}
                                </p>
                        </div>

                        @if($booking->addon_cost)
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <p class="text-sm text-gray-600">Additional Services Cost</p>
                                <p class="text-lg font-semibold text-gray-700">
                                    {{ format_price_by_currency($booking->addon_cost ?? 0, $booking->currency ?? current_currency()) }}
                                </p>
                            </div>
                        @endif

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Payment Status</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 
                                       ($booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($booking->payment_status ?? 'pending') }}
                                </span>
                            </div>

                            @if($booking->payment_method)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Payment Method</span>
                                    <span class="font-semibold text-gray-900">{{ ucfirst($booking->payment_method) }}</span>
                                </div>
                            @endif

                            @if($booking->payment_id)
                                <div class="bg-gray-50 rounded-lg p-3 mt-3">
                                    <p class="text-xs text-gray-500 mb-1">Payment ID</p>
                                    <p class="font-mono text-sm text-gray-800">{{ $booking->payment_id }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Booking Timeline --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Timeline
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Booking Created</p>
                                    <p class="text-sm text-gray-600">{{ $booking->created_at->format('M d, Y - H:i') }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if($booking->updated_at != $booking->created_at)
                                <div class="flex items-start">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">Last Updated</p>
                                        <p class="text-sm text-gray-600">{{ $booking->updated_at->format('M d, Y - H:i') }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                @if($booking->status === 'pending')
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Confirm Booking
                            </button>
                        </form>

                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                    class="w-full px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-semibold transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel Booking
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
