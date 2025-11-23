@extends('layouts.admin')

@section('page-title', 'Edit Tour Session')

@section('content')
<div class="p-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-emerald-600 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('admin.tour-sessions.index') }}" class="text-gray-600 hover:text-emerald-600 ml-1 md:ml-2">Tour Sessions</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-800 font-semibold ml-1 md:ml-2">Edit Session</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Tour Session</h1>
                <p class="text-gray-600 mt-1">Update session details and schedule</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-3xl">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-blue-100">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Session Information
            </h2>
            <p class="text-sm text-gray-600 mt-1">Session ID: #{{ $tourSession->id }}</p>
        </div>

        <form action="{{ route('admin.tour-sessions.update', $tourSession) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <!-- Session Package Info (Read-only) -->
            @if($tourSession->tourPackage)
                <div class="mb-8 p-6 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                    <label class="block text-sm font-semibold text-emerald-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Tour Package
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-base font-bold text-gray-900">{{ \App\Helpers\LanguageHelper::get($tourSession->tourPackage, 'name', app()->getLocale()) }}</p>
                            @if($tourSession->tourPackage->tours && $tourSession->tourPackage->tours->isNotEmpty() && $tourSession->tourPackage->tours->first()->destination)
                                <p class="text-sm text-gray-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ \App\Helpers\LanguageHelper::get($tourSession->tourPackage->tours->first()->destination, 'name', app()->getLocale()) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Date Field -->
            <div class="mb-8">
                <label for="date" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Session Date
                    <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative">
                    <input type="date" 
                           id="date"
                           name="date" 
                           value="{{ old('date', $tourSession->date->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 pl-12 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('date') border-red-300 bg-red-50 @else border-gray-300 @enderror"
                           required>
                    <div class="absolute left-4 top-3.5 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                @error('date')
                    <div class="flex items-center mt-2 text-red-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Capacity Field -->
            <div class="mb-8">
                <label for="capacity" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Capacity
                    <span class="text-gray-400 text-xs ml-2">(Optional)</span>
                </label>
                <div class="relative">
                    <input type="number" 
                           id="capacity"
                           name="capacity" 
                           value="{{ old('capacity', $tourSession->capacity) }}"
                           min="1"
                           placeholder="Enter maximum capacity (leave empty for unlimited)"
                           class="w-full px-4 py-3 pl-12 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('capacity') border-red-300 bg-red-50 @else border-gray-300 @enderror">
                    <div class="absolute left-4 top-3.5 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                @error('capacity')
                    <div class="flex items-center mt-2 text-red-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Leave empty for unlimited capacity
                    </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tour-sessions.index') }}" 
                   class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Session
                </button>
            </div>
        </form>
    </div>

    <!-- Session Status Info -->
    @php
        $isUpcoming = \Carbon\Carbon::parse($tourSession->date)->isFuture();
    @endphp
    <div class="mt-6 max-w-3xl">
        <div class="bg-gradient-to-r from-{{ $isUpcoming ? 'green' : 'gray' }}-50 to-{{ $isUpcoming ? 'emerald' : 'gray' }}-50 border border-{{ $isUpcoming ? 'green' : 'gray' }}-200 rounded-xl p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    @if($isUpcoming)
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    @else
                        <div class="bg-gray-100 rounded-full p-3">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                        Session Status: <span class="text-{{ $isUpcoming ? 'green' : 'gray' }}-600">{{ $isUpcoming ? 'Upcoming' : 'Past' }}</span>
                    </h3>
                    <p class="text-gray-600">
                        @if($isUpcoming)
                            This session is scheduled for <strong>{{ \Carbon\Carbon::parse($tourSession->date)->format('l, d F Y') }}</strong> ({{ \Carbon\Carbon::parse($tourSession->date)->diffForHumans() }})
                        @else
                            This session was held on <strong>{{ \Carbon\Carbon::parse($tourSession->date)->format('l, d F Y') }}</strong> ({{ \Carbon\Carbon::parse($tourSession->date)->diffForHumans() }})
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
