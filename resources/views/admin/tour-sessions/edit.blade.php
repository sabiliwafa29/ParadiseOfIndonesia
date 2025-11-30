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
                    <!-- Form Card -->
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-3">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
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

                                    <!-- Session Name Field -->
                                    <div class="mb-6">
                                        <label for="name" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                            Session Name
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $tourSession->name) }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-300 bg-red-50 @else border-gray-300 @enderror">
                                        @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Description Field -->
                                    <div class="mb-6">
                                        <label for="description" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                            </svg>
                                            Description
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <textarea id="description" name="description" rows="4" required class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('description') border-red-300 bg-red-50 @else border-gray-300 @enderror">{{ old('description', $tourSession->description) }}</textarea>
                                        @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Date Range Fields -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Start Date
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $tourSession->start_date->format('Y-m-d')) }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('start_date') border-red-300 bg-red-50 @else border-gray-300 @enderror">
                                            @error('start_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                        </div>

                                        <div>
                                            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                End Date
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $tourSession->end_date->format('Y-m-d')) }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('end_date') border-red-300 bg-red-50 @else border-gray-300 @enderror">
                                            @error('end_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <!-- Location Field -->
                                    <div class="mb-8">
                                        <label for="location" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Location
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <input type="text" id="location" name="location" value="{{ old('location', $tourSession->location) }}" required class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('location') border-red-300 bg-red-50 @else border-gray-300 @enderror">
                                        @error('location')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                        <a href="{{ route('admin.tour-sessions.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                            Cancel
                                        </a>
                                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Update Session
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <aside class="lg:col-span-1">
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                                <div class="p-4 bg-emerald-600 text-white"><h4 class="font-semibold">Quick Info</h4></div>
                                <div class="p-4 space-y-3">
                                    <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Session ID</span><span class="text-sm font-medium text-gray-800">#{{ $tourSession->id }}</span></div>
                                    <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Created</span><span class="text-sm font-medium text-gray-800">{{ $tourSession->created_at ? $tourSession->created_at->format('M d, Y') : '-' }}</span></div>
                                    <div class="pt-2">
                                        <form action="{{ route('admin.tour-sessions.destroy', $tourSession) }}" method="POST" onsubmit="return confirm('Delete this session?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-md">Delete Session</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <!-- Session Status Info -->
                    @php
                        $isUpcoming = \Carbon\Carbon::parse($tourSession->start_date)->isFuture();
                        $duration = \Carbon\Carbon::parse($tourSession->start_date)->diffInDays(\Carbon\Carbon::parse($tourSession->end_date)) + 1;
                    @endphp
                    <div class="mt-6 max-w-3xl">
                        <div class="bg-gradient-to-r from-{{ $isUpcoming ? 'green' : 'gray' }}-50 to-{{ $isUpcoming ? 'emerald' : 'gray' }}-50 border border-{{ $isUpcoming ? 'green' : 'gray' }}-200 rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    @if($isUpcoming)
                                        <div class="bg-green-100 rounded-full p-3">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                    @else
                                        <div class="bg-gray-100 rounded-full p-3">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Session Status: <span class="text-{{ $isUpcoming ? 'green' : 'gray' }}-600">{{ $isUpcoming ? 'Upcoming' : 'Past' }}</span></h3>
                                    <p class="text-gray-600">
                                        @if($isUpcoming)
                                            This session is scheduled from <strong>{{ \Carbon\Carbon::parse($tourSession->start_date)->format('d M') }}</strong> to <strong>{{ \Carbon\Carbon::parse($tourSession->end_date)->format('d M Y') }}</strong> ({{ $duration }} days)
                                        @else
                                            This session was held from <strong>{{ \Carbon\Carbon::parse($tourSession->start_date)->format('d M') }}</strong> to <strong>{{ \Carbon\Carbon::parse($tourSession->end_date)->format('d M Y') }}</strong>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            This session is scheduled from <strong>{{ \Carbon\Carbon::parse($tourSession->start_date)->format('d M') }}</strong> to <strong>{{ \Carbon\Carbon::parse($tourSession->end_date)->format('d M Y') }}</strong> ({{ $duration }} days)
                        @else
                            This session was held from <strong>{{ \Carbon\Carbon::parse($tourSession->start_date)->format('d M') }}</strong> to <strong>{{ \Carbon\Carbon::parse($tourSession->end_date)->format('d M Y') }}</strong>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-update end date min when start date changes
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = this.value;
    const endDateInput = document.getElementById('end_date');
    endDateInput.min = startDate;
    
    // If end date is before start date, update it
    if (endDateInput.value && endDateInput.value < startDate) {
        endDateInput.value = startDate;
    }
});
</script>
@endsection
