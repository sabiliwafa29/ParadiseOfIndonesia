@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Travel Services</h1>
                    <p class="text-gray-600 mt-1">Manage and organize travel services, transportation, and add-ons displayed on the landing page</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('travel-services.index') }}" target="_blank"
                       class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-xl shadow-sm transition">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View on Site
                    </a>
                    <a href="{{ route('admin.travel-services.create') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/30 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Service
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-6 border-l-4 border-emerald-500 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Total Services</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalServices ?? $services->total() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Services displayed on landing page</p>
                    </div>
                    <div class="bg-emerald-100 rounded-2xl p-3.5">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-6 border-l-4 border-teal-500 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Categories / Types</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalTypes ?? count($types ?? []) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Transport, Guide, Booking, etc.</p>
                    </div>
                    <div class="bg-teal-100 rounded-2xl p-3.5">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-6 border-l-4 border-cyan-500 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase tracking-wider">Avg. Starting Price</p>
                        <p class="text-3xl font-extrabold text-cyan-600 mt-1">{{ format_price($avgPrice ?? 0) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Across all available services</p>
                    </div>
                    <div class="bg-cyan-100 rounded-2xl p-3.5">
                        <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table / Grid Container --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- Filter & Search Bar --}}
            <div class="border-b border-gray-200 bg-gray-50/70 p-4 sm:p-6">
                <form method="GET" action="{{ route('admin.travel-services.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    
                    {{-- Type Filter Pills --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('admin.travel-services.index', ['search' => request('search')]) }}" 
                           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ !request('type') || request('type') === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                            All ({{ $totalServices ?? $services->total() }})
                        </a>
                        @foreach($types ?? [] as $type)
                            <a href="{{ route('admin.travel-services.index', ['type' => $type, 'search' => request('search')]) }}" 
                               class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ request('type') === $type ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                                {{ $type }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Search Input --}}
                    <div class="flex items-center gap-2">
                        <div class="relative w-full sm:w-64">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search services..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white shadow-sm">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        @if(request('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-xl transition shadow-sm">
                            Filter
                        </button>
                        @if(request('search') || (request('type') && request('type') !== 'all'))
                            <a href="{{ route('admin.travel-services.index') }}" class="p-2 text-gray-400 hover:text-gray-600 transition" title="Clear Filters">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Services Grid --}}
            <div class="p-6">
                @if($services->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group">
                            
                            {{-- Image Container --}}
                            <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                                @if($service->image)
                                    <img src="{{ $service->image_url }}" 
                                         alt="{{ $service->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'600\' viewBox=\'0 0 800 600\'%3E%3Crect fill=\'%23e5e7eb\' width=\'800\' height=\'600\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'24\' fill=\'%239ca3af\'%3ENo Image%3C/text%3E%3C/svg%3E';">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 text-white/70">
                                        <svg class="w-12 h-12 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-white/80">{{ $service->type }}</span>
                                    </div>
                                @endif

                                {{-- Type Badge --}}
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-3 py-1 bg-black/70 backdrop-blur-md text-white text-xs font-bold rounded-full uppercase tracking-wider shadow">
                                        {{ $service->type }}
                                    </span>
                                </div>
                            </div>

                            {{-- Service Info --}}
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-emerald-600 transition leading-snug">
                                    {{ $service->name }}
                                </h3>

                                <p class="text-sm text-gray-600 mt-2 line-clamp-3 leading-relaxed flex-1">
                                    {{ $service->description }}
                                </p>

                                {{-- Price Display --}}
                                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-xs text-gray-500 block">Starting from</span>
                                        <span class="text-xl font-extrabold text-emerald-600">
                                            {{ format_price($service->price) }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-400">ID: #{{ $service->id }}</span>
                                </div>

                                {{-- Actions --}}
                                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
                                    <a href="{{ route('travel-services.show', $service) }}" target="_blank"
                                       class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition" title="Preview on website">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.travel-services.edit', $service) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold rounded-xl text-sm transition">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.travel-services.destroy', $service) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($service->name) }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center p-2 text-red-600 hover:bg-red-50 rounded-xl transition" 
                                                title="Delete Service">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-600">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">No services found</h3>
                        <p class="text-gray-500 mb-6">
                            @if(request('search') || request('type'))
                                No services match your active search filters.
                            @else
                                Get started by creating your first travel service for your customers.
                            @endif
                        </p>
                        @if(request('search') || request('type'))
                            <a href="{{ route('admin.travel-services.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition mr-2">
                                Clear Filters
                            </a>
                        @endif
                        <a href="{{ route('admin.travel-services.create') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Service
                        </a>
                    </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($services->hasPages())
            <div class="bg-gray-50/70 px-6 py-4 border-t border-gray-200">
                {{ $services->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
