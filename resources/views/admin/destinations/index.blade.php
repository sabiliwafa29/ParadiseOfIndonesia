@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Destinations</h1>
                    <p class="text-gray-600 mt-1">Manage and organize your travel destinations</p>
                </div>
                <a href="{{ route('admin.destinations.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Destination
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Destinations</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $destinations->total() }}</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Featured Destinations</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $destinations->where('featured', true)->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Tours</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $destinations->sum(function($d) { return $d->tours->count(); }) }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Filter Section --}}
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex space-x-4">
                        <button onclick="filterDestinations('all')" id="filter-all"
                                class="px-4 py-2 text-sm rounded-lg transition text-emerald-700 bg-emerald-100 font-semibold">
                            All Destinations
                        </button>
                        <button onclick="filterDestinations('featured')" id="filter-featured"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            Featured
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" 
                                   id="search-input"
                                   oninput="searchDestinations()"
                                   placeholder="Search destinations..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let currentFilter = 'all';

                function filterDestinations(filter) {
                    currentFilter = filter;
                    
                    // Update button styles
                    document.querySelectorAll('[id^="filter-"]').forEach(btn => {
                        btn.className = 'px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium';
                    });
                    document.getElementById('filter-' + filter).className = 'px-4 py-2 text-sm rounded-lg transition text-emerald-700 bg-emerald-100 font-semibold';
                    
                    applyFilters();
                }

                function searchDestinations() {
                    applyFilters();
                }

                function applyFilters() {
                    const searchValue = document.getElementById('search-input').value.toLowerCase();
                    const destinations = document.querySelectorAll('.destination-card');
                    
                    destinations.forEach(destination => {
                        let matchesFilter = true;
                        let matchesSearch = true;
                        
                        // Filter by featured
                        if (currentFilter === 'featured') {
                            matchesFilter = destination.dataset.featured === '1';
                        }
                        
                        // Filter by search
                        if (searchValue) {
                            const name = destination.dataset.name.toLowerCase();
                            const location = destination.dataset.location.toLowerCase();
                            matchesSearch = name.includes(searchValue) || location.includes(searchValue);
                        }
                        
                        // Show/hide based on filters
                        if (matchesFilter && matchesSearch) {
                            destination.style.display = 'block';
                        } else {
                            destination.style.display = 'none';
                        }
                    });
                }
            </script>

            {{-- Destinations Grid --}}
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($destinations as $destination)
                    <div class="destination-card group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300"
                         data-featured="{{ $destination->featured ? '1' : '0' }}"
                         data-name="{{ $destination->name_en }}"
                         data-location="{{ $destination->location }}">
                        
                        {{-- Image Section --}}
                        <div class="relative h-48 bg-gradient-to-br from-emerald-400 to-teal-500 overflow-hidden">
                            @if($destination->image)
                                @include('components.responsive-image', [
                                    'path' => $destination->image, 
                                    'alt' => $destination->name_en ?? '', 
                                    'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700', 
                                    'derivatives' => $destination->image_derivatives ?? null
                                ])
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            @if($destination->featured)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400 text-yellow-900 shadow-lg">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Featured
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Content Section --}}
                        <div class="p-5">
                            <div class="mb-3">
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-emerald-600 transition mb-2">
                                    {{ $destination->name_en }}
                                </h3>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="w-4 h-4 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $destination->location }}
                                </div>

                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        {{ $destination->tours->count() }} Tours
                                    </div>
                                </div>
                            </div>

                            {{-- Multi-language Names --}}
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg space-y-1 text-xs">
                                <div><span class="font-semibold text-gray-600">ID:</span> {{ $destination->name_id }}</div>
                                <div><span class="font-semibold text-gray-600">ZH:</span> {{ $destination->name_zh }}</div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center space-x-2 pt-4 border-t border-gray-100">
                                <a href="{{ route('admin.destinations.edit', $destination) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition font-medium text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('destinations.show', $destination) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <form action="{{ route('admin.destinations.destroy', $destination) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this destination?');"
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
                    @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No destinations yet</h3>
                        <p class="text-gray-500 mb-6">Get started by creating your first destination</p>
                        <a href="{{ route('admin.destinations.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New Destination
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            @if($destinations->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $destinations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
