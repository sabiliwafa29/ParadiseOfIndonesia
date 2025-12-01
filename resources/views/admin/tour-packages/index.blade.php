@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Tour Packages</h1>
                    <p class="text-gray-600 mt-1">Manage and organize your tour packages</p>
                </div>
                <a href="{{ route('admin.tour-packages.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Package
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
                        <p class="text-gray-600 text-sm font-medium">Total Packages</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $packages->total() }}</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">With Guide</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $packages->where('includes_guide', true)->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">With Transport</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $packages->where('includes_transport', true)->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $packages->sum(function($p) { return $p->bookings_count ?? 0; }) }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
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
                        <button onclick="filterPackages('all')" id="filter-all"
                                class="px-4 py-2 text-sm rounded-lg transition text-emerald-700 bg-emerald-100 font-semibold">
                            All Packages
                        </button>
                        <button onclick="filterPackages('guide')" id="filter-guide"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            With Guide
                        </button>
                        <button onclick="filterPackages('transport')" id="filter-transport"
                                class="px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium">
                            With Transport
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" 
                                   id="search-input"
                                   oninput="searchPackages()"
                                   placeholder="Search packages..." 
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

                function filterPackages(filter) {
                    currentFilter = filter;
                    
                    document.querySelectorAll('[id^="filter-"]').forEach(btn => {
                        btn.className = 'px-4 py-2 text-sm rounded-lg transition text-gray-600 hover:bg-gray-100 font-medium';
                    });
                    document.getElementById('filter-' + filter).className = 'px-4 py-2 text-sm rounded-lg transition text-emerald-700 bg-emerald-100 font-semibold';
                    
                    applyFilters();
                }

                function searchPackages() {
                    applyFilters();
                }

                function applyFilters() {
                    const searchValue = document.getElementById('search-input').value.toLowerCase();
                    const packages = document.querySelectorAll('.package-card');
                    
                    packages.forEach(pkg => {
                        let matchesFilter = true;
                        let matchesSearch = true;
                        
                        if (currentFilter === 'guide') {
                            matchesFilter = pkg.dataset.guide === '1';
                        } else if (currentFilter === 'transport') {
                            matchesFilter = pkg.dataset.transport === '1';
                        }
                        
                        if (searchValue) {
                            const name = pkg.dataset.name.toLowerCase();
                            matchesSearch = name.includes(searchValue);
                        }
                        
                        if (matchesFilter && matchesSearch) {
                            pkg.style.display = 'block';
                        } else {
                            pkg.style.display = 'none';
                        }
                    });
                }
            </script>

            {{-- Packages Grid --}}
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($packages as $package)
                    <div class="package-card group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300"
                         data-guide="{{ $package->includes_guide ? '1' : '0' }}"
                         data-transport="{{ $package->includes_transport ? '1' : '0' }}"
                         data-name="{{ $package->name }}">
                        <div class="flex">
                            {{-- Image Section --}}
                            <div class="w-48 h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex-shrink-0 relative overflow-hidden">
                                @if($package->image)
                                    @include('components.responsive-image', [
                                        'path' => $package->image, 
                                        'alt' => $package->name ?? '', 
                                        'class' => 'w-full h-full object-cover', 
                                        'derivatives' => $package->image_derivatives ?? null
                                    ])
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                {{-- Badges --}}
                                <div class="absolute top-3 left-3 flex flex-col gap-1">
                                    @if($package->includes_guide)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            Guide
                                        </span>
                                    @endif
                                    @if($package->includes_transport)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-600 text-white">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                            </svg>
                                            Transport
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content Section --}}
                            <div class="flex-1 p-5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between mb-2">
                                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-emerald-600 transition">
                                            {{ $package->name }}
                                        </h3>
                                    </div>
                                    
                                    {{-- Multi-language names --}}
                                    <div class="space-y-1 mb-3 text-xs">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">ID</span>
                                            <span class="text-gray-600 truncate">{{ $package->name_id }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">EN</span>
                                            <span class="text-gray-600 truncate">{{ $package->name_en }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mr-2">ZH</span>
                                            <span class="text-gray-600 truncate">{{ $package->name_zh }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                                            </svg>
                                            {{ $package->min_guests ?? 1 }} min
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $package->bookings_count ?? 0 }} booked
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-2xl font-bold text-emerald-600">
                                                {{ format_price(get_price($package)) }}
                                            </span>
                                            <span class="text-sm text-gray-500">/person</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center space-x-2 mt-4 pt-4 border-t border-gray-100">
                                    <a href="{{ route('admin.tour-packages.edit', $package) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('tour-packages.show', $package) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                    <form action="{{ route('admin.tour-packages.destroy', $package) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this package?');"
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
                @if($packages->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No packages yet</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first tour package</p>
                    <a href="{{ route('admin.tour-packages.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New Package
                    </a>
                </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($packages->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $packages->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection