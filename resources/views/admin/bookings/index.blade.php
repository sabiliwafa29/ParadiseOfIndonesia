@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Booking Management</h1>
                    <p class="text-gray-600 mt-1">Track and manage all customer bookings</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative" id="exportDropdownContainer">
                        <button id="exportDropdownBtn"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="font-medium text-gray-700">Export</span>
                            <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div id="exportDropdown"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden opacity-0 transition-all duration-200">
                            <div class="py-2">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Export Report</p>
                                </div>
                                
                                {{-- Export Excel --}}
                                <a href="{{ route('admin.bookings.export-excel', request()->query()) }}" 
                                   class="flex items-center px-4 py-3 hover:bg-gray-50 transition">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM9.5 11.5l1.5 3 1.5-3h1.5l-2.25 4.5L14 20.5h-1.5L11 17.5 9.5 20.5H8l2.25-4.5L8 11.5h1.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Excel (.xls)</p>
                                        <p class="text-xs text-gray-500">Full report with formatting</p>
                                    </div>
                                </a>
                                
                                {{-- Export CSV --}}
                                <a href="{{ route('admin.bookings.export', request()->query()) }}" 
                                   class="flex items-center px-4 py-3 hover:bg-gray-50 transition">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">CSV (.csv)</p>
                                        <p class="text-xs text-gray-500">Simple spreadsheet format</p>
                                    </div>
                                </a>
                                
                                <div class="border-t border-gray-100 mt-2 pt-2 px-4 pb-2">
                                    <p class="text-xs text-gray-400">
                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Exports current filtered data
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-600 text-emerald-700 rounded-r-lg shadow">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Bookings --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                        <p class="text-xs text-blue-600 mt-2">
                            <span class="font-semibold">+{{ $stats['today_bookings'] }}</span> today
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Pending Bookings --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending'] }}</p>
                        <p class="text-xs text-yellow-600 mt-2">Awaiting confirmation</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Confirmed Bookings --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Confirmed</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['confirmed'] }}</p>
                        <p class="text-xs text-green-600 mt-2">Active bookings</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ format_price_by_currency($stats['total_revenue'] ?? 0, current_currency()) }}</p>
                        <p class="text-xs text-purple-600 mt-2">From confirmed bookings</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Filter Section --}}
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <form method="GET" action="{{ route('admin.bookings.index') }}" class="space-y-4">
                    <div class="flex flex-wrap items-center gap-4">
                        {{-- Search --}}
                        <div class="flex-1 min-w-[200px]">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by user or tour name..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Status Filter --}}
                        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        {{-- Date From --}}
                        <input type="date" 
                               name="date_from" 
                               value="{{ request('date_from') }}"
                               placeholder="From date"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                        {{-- Date To --}}
                        <input type="date" 
                               name="date_to" 
                               value="{{ request('date_to') }}"
                               placeholder="To date"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                        {{-- Buttons --}}
                        <div class="flex items-center space-x-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                Apply
                            </button>
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Bookings Grid --}}
            <div class="p-6">
                @if($bookings->isEmpty())
                    {{-- Empty State --}}
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No bookings found</h3>
                        <p class="text-gray-500 mb-6">
                            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                Try adjusting your filters to find what you're looking for.
                            @else
                                Bookings will appear here once customers start making reservations.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($bookings as $booking)
                        <div class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="p-6">
                                {{-- Header --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="text-xs font-semibold text-gray-500">#{{ $booking->id }}</span>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                                {{ $booking->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                                   ($booking->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">
                                            @if($booking->tour)
                                                {{ \App\Helpers\LanguageHelper::get($booking->tour, 'name') }}
                                            @elseif($booking->package)
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                                    </svg>
                                                    {{ \App\Helpers\LanguageHelper::get($booking->package, 'name') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">No Tour/Package</span>
                                            @endif
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            @if($booking->tour && $booking->tour->destination)
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ \App\Helpers\LanguageHelper::get($booking->tour->destination, 'name') }}
                                            @elseif($booking->package)
                                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-purple-600 font-medium">Package Booking</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Customer Info --}}
                                <div class="flex items-center space-x-3 mb-4 p-3 bg-gray-50 rounded-lg">
                                    @php
                                        $customerName = $booking->user->name ?? $booking->full_name ?? 'Guest';
                                        $customerEmail = $booking->user->email ?? $booking->email ?? null;
                                        $isGuest = !$booking->user_id;
                                    @endphp
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $isGuest ? 'from-gray-400 to-gray-500' : 'from-blue-400 to-indigo-500' }} flex items-center justify-center text-white font-bold">
                                        {{ substr($customerName, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">
                                            {{ $customerName }}
                                            @if($isGuest)
                                                <span class="ml-1 px-2 py-0.5 bg-gray-200 text-gray-600 text-xs rounded-full">Guest</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $customerEmail ?? 'No email' }}</p>
                                    </div>
                                </div>

                                {{-- Booking Details Grid --}}
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Travel Date</p>
                                        <p class="font-semibold text-gray-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $booking->date ? $booking->date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Guests</p>
                                        <p class="font-semibold text-gray-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $booking->guests ?? '1' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Booked On</p>
                                        <p class="text-sm text-gray-700">{{ $booking->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Total Price</p>
                                        <p class="text-xl font-bold text-blue-600">{{ format_price_by_currency($booking->total_price ?? 0, $booking->currency ?? current_currency()) }}</p>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center space-x-2 pt-4 border-t border-gray-100">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View Details
                                    </a>
                                    @if($booking->status === 'pending')
                                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" 
                                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Confirm
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($bookings->hasPages())
                    <div class="mt-8">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Export Dropdown
        const exportBtn = document.getElementById('exportDropdownBtn');
        const exportDropdown = document.getElementById('exportDropdown');
        const exportContainer = document.getElementById('exportDropdownContainer');
        let exportOpen = false;

        function toggleExportDropdown() {
            exportOpen = !exportOpen;
            if (exportOpen) {
                exportDropdown.classList.remove('hidden', 'opacity-0');
                exportDropdown.classList.add('opacity-100');
            } else {
                exportDropdown.classList.add('opacity-0');
                setTimeout(() => {
                    exportDropdown.classList.add('hidden');
                }, 200);
            }
        }

        function closeExportDropdown() {
            if (exportOpen) {
                exportOpen = false;
                exportDropdown.classList.add('opacity-0');
                setTimeout(() => {
                    exportDropdown.classList.add('hidden');
                }, 200);
            }
        }

        if (exportBtn) {
            exportBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleExportDropdown();
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (exportContainer && !exportContainer.contains(e.target)) {
                closeExportDropdown();
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeExportDropdown();
            }
        });
    });
</script>
@endpush
