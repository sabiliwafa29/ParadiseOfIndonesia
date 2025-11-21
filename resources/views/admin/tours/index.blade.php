@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Tours</h1>
                    <p class="text-gray-600 mt-1">Manage and organize your tours</p>
                </div>
                <a href="{{ route('admin.tours.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Tour
                </a>
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Tours</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $tours->total() }}</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Featured Tours</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $featuredCount ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBookings ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            @if(($totalRevenue ?? 0) > 0)
                                ${{ number_format($totalRevenue / 1000, 1) }}K
                            @else
                                $0
                            @endif
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Tabs/Filter Section --}}
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex space-x-4">
                        <button onclick="filterTours('all')" id="filter-all"
                                class="px-4 py-2 text-sm rounded-lg transition text-emerald-700 bg-emerald-100 font-semibold">
                            All Tours
                        </button>
                        <button onclick="filterTours('featured')" id="filter-featured"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            Featured
                        </button>
                        <button onclick="filterTours('inactive')" id="filter-inactive"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            Inactive
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" 
                                   id="search-input"
                                   oninput="searchTours()"
                                   placeholder="Search tours..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition" title="More filters">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <script>
                let currentFilter = 'all';

                function filterTours(filter) {
                    currentFilter = filter;
                    
                    // Update button styles
                    document.querySelectorAll('[id^="filter-"]').forEach(btn => {
                        btn.className = 'px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium';
                    });
                    document.getElementById('filter-' + filter).className = 'px-4 py-2 text-sm rounded-lg transition text-emerald-700 bg-emerald-100 font-semibold';
                    
                    applyFilters();
                }

                function searchTours() {
                    applyFilters();
                }

                function applyFilters() {
                    const searchValue = document.getElementById('search-input').value.toLowerCase();
                    const tours = document.querySelectorAll('.tour-card');
                    
                    tours.forEach(tour => {
                        let matchesFilter = true;
                        let matchesSearch = true;
                        
                        // Filter by status
                        if (currentFilter === 'all') {
                            // Show all tours
                            matchesFilter = true;
                        } else if (currentFilter === 'featured') {
                            matchesFilter = tour.dataset.featured === '1';
                        } else if (currentFilter === 'inactive') {
                            // Show only inactive tours (status is not 'active')
                            matchesFilter = tour.dataset.status === 'inactive' || tour.dataset.status === 'draft' || tour.dataset.status === '';
                        }
                        
                        // Filter by search
                        if (searchValue) {
                            const name = tour.dataset.name.toLowerCase();
                            const description = tour.dataset.description.toLowerCase();
                            matchesSearch = name.includes(searchValue) || description.includes(searchValue);
                        }
                        
                        // Show/hide based on filters
                        if (matchesFilter && matchesSearch) {
                            tour.style.display = 'block';
                        } else {
                            tour.style.display = 'none';
                        }
                    });
                }
            </script>

            {{-- Tours Grid --}}
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($tours as $tour)
                    <div class="tour-card group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300"
                         data-status="{{ $tour->status ?? 'active' }}"
                         data-featured="{{ $tour->featured ? '1' : '0' }}"
                         data-name="{{ $tour->name }}"
                         data-description="{{ Str::limit($tour->description, 100) }}">
                        <div class="flex">
                            {{-- Image Section --}}
                            <div class="w-48 h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex-shrink-0 relative overflow-hidden">
                                @if($tour->image)
                                    @if($tour->image)
                                        @include('components.responsive-image', ['path' => $tour->image, 'alt' => $tour->name ?? '', 'class' => 'w-full h-full object-cover', 'derivatives' => $tour->image_derivatives])
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $tour->destination->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content Section --}}
                            <div class="flex-1 p-5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between mb-2">
                                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-emerald-600 transition">
                                            {{ $tour->name }}
                                        </h3>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $tour->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($tour->status ?? 'active') }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ Str::limit($tour->description, 100) }}
                                    </p>

                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $tour->duration ?? '7 Days' }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            4.8/5
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $tour->bookings_count ?? 0 }} booked
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-2xl font-bold text-emerald-600">
                                                {{ format_price(get_price($tour)) }}
                                            </span>
                                            <span class="text-sm text-gray-500">/person</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center space-x-2 mt-4 pt-4 border-t border-gray-100">
                                    <a href="{{ route('admin.tours.edit', $tour) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('tours.show', $tour) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                    <form action="{{ route('admin.tours.destroy', $tour) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this tour?');"
                                          class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Empty State --}}
                @if($tours->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No tours yet</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first tour</p>
                    <a href="{{ route('admin.tours.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New Tour
                    </a>
                </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($tours->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $tours->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection