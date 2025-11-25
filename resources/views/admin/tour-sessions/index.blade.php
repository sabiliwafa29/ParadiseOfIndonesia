@extends('layouts.admin')

@section('page-title', 'Tour Sessions')

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
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-800 font-semibold ml-1 md:ml-2">Tour Sessions</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header with Action Button -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tour Sessions</h1>
            <p class="text-gray-600 mt-1">Manage and schedule tour sessions</p>
        </div>
        <a href="{{ route('admin.tour-sessions.create') }}" 
           class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Add New Session</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-semibold uppercase tracking-wide">Total Sessions</p>
                    <p class="text-3xl font-bold text-blue-900 mt-2">{{ $totalSessions ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-semibold uppercase tracking-wide">Upcoming</p>
                    <p class="text-3xl font-bold text-green-900 mt-2">{{ $upcomingSessions ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-600 text-sm font-semibold uppercase tracking-wide">Past Sessions</p>
                    <p class="text-3xl font-bold text-purple-900 mt-2">{{ $pastSessions ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessions List -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($sessions->count())
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Session Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date Range</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($sessions as $session)
                            @php
                                $isUpcoming = \Carbon\Carbon::parse($session->start_date)->isFuture();
                                $packageName = $session->tourPackage 
                                    ? \App\Helpers\LanguageHelper::get($session->tourPackage, 'name', app()->getLocale())
                                    : 'N/A';
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">#{{ $session->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $session->name }}</div>
                                            <div class="text-xs text-gray-500">Package: {{ $packageName }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-sm text-gray-900">{{ $session->location }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($session->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($session->end_date)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($session->start_date)->diffInDays(\Carbon\Carbon::parse($session->end_date)) + 1 }} days</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($isUpcoming)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Upcoming
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Past
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.tour-sessions.edit', $session) }}" 
                                           class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-lg transition"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.tour-sessions.destroy', $session) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this session?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition"
                                                    title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $sessions->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No sessions found</h3>
            <p class="text-gray-600 mb-6">Get started by creating your first tour session</p>
            <a href="{{ route('admin.tour-sessions.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create First Session
            </a>
        </div>
    @endif
</div>
@endsection
