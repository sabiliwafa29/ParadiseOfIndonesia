@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb + Header --}}
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-500 hover:text-emerald-600 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-emerald-600 font-semibold">Gallery</span>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Gallery Showcase</h1>
                    <p class="text-gray-600 mt-1">Manage, upload, and organize showcase photos displayed on pnbtravel.com</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('gallery.index') }}" target="_blank"
                       class="inline-flex items-center px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition shadow-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Public Gallery
                    </a>
                    <a href="{{ route('admin.gallery.create') }}" 
                       class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/30 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload Photo
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Photos</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalImages }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Destinations Tagged</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $destinations->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Current Page</p>
                    <p class="text-3xl font-extrabold text-cyan-600 mt-1">{{ $galleries->currentPage() }} of {{ $galleries->lastPage() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center text-cyan-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-200 shadow-sm mb-8">
            <form method="GET" action="{{ route('admin.gallery.index') }}" class="flex flex-col sm:flex-row items-center gap-4">
                <div class="relative flex-1 w-full">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search photos by title or description..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <div class="w-full sm:w-64">
                    <select name="destination_id" 
                            onchange="this.form.submit()"
                            class="w-full py-2.5 px-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">All Destinations</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                                {{ $dest->name_en ?? $dest->name_id ?? 'Destination #' . $dest->id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-gray-900 hover:bg-black text-white font-medium rounded-xl text-sm transition">
                    Search
                </button>

                @if(request('search') || request('destination_id'))
                    <a href="{{ route('admin.gallery.index') }}" class="w-full sm:w-auto px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition text-center">
                        Clear Filters
                    </a>
                @endif
            </form>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Gallery Grid --}}
        @if($galleries->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($galleries as $gallery)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col">
                        <!-- Photo Frame -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $gallery->image_url }}" 
                                 alt="{{ $gallery->title ?? $gallery->name }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500"
                                 loading="lazy">
                            
                            <!-- Destination Badge -->
                            <div class="absolute top-3 left-3">
                                @if($gallery->destination)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-emerald-800 shadow-sm">
                                        {{ $gallery->destination->name_en ?? $gallery->destination->name_id }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-900/70 backdrop-blur-md text-white shadow-sm">
                                        General
                                    </span>
                                @endif
                            </div>

                            <!-- ID Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="text-xs font-mono font-bold bg-black/60 backdrop-blur-md text-white px-2 py-0.5 rounded-md">
                                    #{{ $gallery->id }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 truncate" title="{{ $gallery->title ?? $gallery->name }}">
                                    {{ $gallery->title ?? $gallery->name ?? 'Untitled Photo' }}
                                </h3>
                                @if($gallery->description)
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $gallery->description }}</p>
                                @endif
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs text-gray-400">
                                    {{ $gallery->created_at ? $gallery->created_at->diffForHumans() : '-' }}
                                </span>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('admin.gallery.edit', $gallery) }}" 
                                       class="p-2 text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                                       title="Edit Photo">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Delete this gallery photo?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Delete Photo">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $galleries->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 rounded-full mb-5 text-emerald-600">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No gallery photos found</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">Start building your showcase gallery by uploading high-resolution photos of Indonesia</p>
                <a href="{{ route('admin.gallery.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/30 transition transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Upload First Photo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
