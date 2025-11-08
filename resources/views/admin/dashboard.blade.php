@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-gray-600 mt-1">Welcome back! Here's what's happening today</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">{{ Carbon\Carbon::now()->format('l, F d, Y') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ Carbon\Carbon::now()->format('h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Tours --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Tours</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTours }}</p>
                        <p class="text-xs text-emerald-600 mt-2">
                            <span class="font-semibold">{{ $activeTours }}</span> active
                        </p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Bookings --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBookings }}</p>
                        <p class="text-xs text-orange-600 mt-2">
                            <span class="font-semibold">{{ $pendingBookings }}</span> pending
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">${{ number_format($totalRevenue, 0) }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">+12.5%</span> from last month
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Customers --}}
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Customers</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalCustomers }}</p>
                        <p class="text-xs text-blue-600 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                            </svg>
                            <span class="font-semibold">+8</span> new this week
                        </p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts and Data Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Revenue Chart --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Revenue Overview</h2>
                        <p class="text-sm text-gray-600">Last 6 months performance</p>
                    </div>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option>Last 6 months</option>
                        <option>Last year</option>
                        <option>All time</option>
                    </select>
                </div>
                <div class="h-64 flex items-end justify-between space-x-2">
                    @php
                        $maxRevenue = $monthlyRevenue->max('revenue') ?: 1;
                    @endphp
                    @foreach($monthlyRevenue as $data)
                        @php
                            $height = ($data->revenue / $maxRevenue) * 100;
                            $monthName = Carbon\Carbon::create()->month($data->month)->format('M');
                        @endphp
                        <div class="flex-1 flex flex-col items-center group">
                            <div class="relative w-full bg-gradient-to-t from-emerald-500 to-emerald-400 rounded-t-lg hover:from-emerald-600 hover:to-emerald-500 transition-all duration-300 cursor-pointer" 
                                 style="height: {{ $height }}%">
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                    ${{ number_format($data->revenue) }}
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">{{ $monthName }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Booking Status Distribution --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Booking Status</h2>
                <div class="space-y-4">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'bar' => 'bg-yellow-500'],
                            'confirmed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'bar' => 'bg-blue-500'],
                            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'bar' => 'bg-green-500'],
                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'bar' => 'bg-red-500'],
                        ];
                        $totalStatusBookings = $bookingsByStatus->sum();
                    @endphp
                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                        @php
                            $count = $bookingsByStatus[$status] ?? 0;
                            $percentage = $totalStatusBookings > 0 ? ($count / $totalStatusBookings) * 100 : 0;
                            $colors = $statusColors[$status];
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 capitalize">{{ $status }}</span>
                                <span class="text-sm font-bold text-gray-800">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $colors['bar'] }} h-2.5 rounded-full transition-all duration-500" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Bookings and Popular Tours --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Recent Bookings --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Recent Bookings</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentBookings as $booking)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($booking->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $booking->user->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $booking->tour->name }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $booking->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-emerald-600 font-bold">${{ number_format($booking->total_price) }}</span>
                                    </div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full {{ 
                                    $booking->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                    ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                    ($booking->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) 
                                }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p>No bookings yet</p>
                        </div>
                    @endforelse
                </div>
                @if($recentBookings->count() > 0)
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            View all bookings →
                        </a>
                    </div>
                @endif
            </div>

            {{-- Popular Tours --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Popular Tours</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($popularTours as $tour)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-400 to-purple-500 flex-shrink-0 overflow-hidden">
                                    @if($tour->image)
                                        <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $tour->name }}</h3>
                                    <div class="flex items-center space-x-3 mt-1">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            {{ $tour->bookings_count }} bookings
                                        </span>
                                        <span class="text-sm font-bold text-emerald-600">${{ number_format($tour->price) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            <p>No tours available</p>
                        </div>
                    @endforelse
                </div>
                @if($popularTours->count() > 0)
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <a href="{{ route('admin.tours.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            View all tours →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Recent Activities</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $activity['type'] === 'tour' ? 'bg-emerald-100' : 'bg-blue-100' }} flex items-center justify-center">
                                @if($activity['type'] === 'tour')
                                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-800">{{ $activity['message'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activity['created_at']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>No recent activities</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection