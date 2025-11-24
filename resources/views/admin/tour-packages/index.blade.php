@extends('layouts.admin')

@section('content')
@php
    // Determine display mode for prices:
    // - If `show_all=1` query param is present -> show all currencies
    // - Else if `currency` is provided via request or session -> show that currency only
    // - Else fall back to app locale mapping (id -> IDR, zh -> CNY, otherwise USD)
    function __mapCurrency($val) {
        $v = strtolower(trim((string)$val));
        if (in_array($v, ['idr', 'id', 'rupiah'])) return 'idr';
        if (in_array($v, ['cny', 'cn', 'zh', 'rmb', 'yuan'])) return 'cny';
        return 'usd';
    }

    $forceAll = request()->boolean('show_all');
    $requested = request('currency') ?? session('currency');
    $locale = app()->getLocale();

    if ($forceAll) {
        $displayMode = 'all';
    } elseif ($requested) {
        $displayMode = __mapCurrency($requested);
    } else {
        // Map locale to currency by default
        $displayMode = __mapCurrency($locale);
        // If locale mapping yields a currency but you prefer to show all by default,
        // change $displayMode = 'all';
    }
@endphp
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Tour Packages</h1>
                    <p class="text-gray-600">Kelola semua paket wisata Anda</p>
                </div>
                <a href="{{ route('admin.tour-packages.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Package
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                        <input type="text"
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama paket..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <button type="submit" 
                        class="px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg">
                    <span class="sm:hidden">Cari</span>
                    <span class="hidden sm:inline">Cari Package</span>
                </button>
                <div class="flex items-center gap-2">
                        <select id="currency-select" name="currency" class="px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white">
                        <option value="">Auto</option>
                        <option value="idr" {{ request('currency') === 'idr' ? 'selected' : '' }}>IDR</option>
                        <option value="usd" {{ request('currency') === 'usd' ? 'selected' : '' }}>USD</option>
                        <option value="cny" {{ request('currency') === 'cny' ? 'selected' : '' }}>CNY</option>
                    </select>
                    <a href="{{ request()->fullUrlWithQuery(['show_all' => 1]) }}" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">Show All</a>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.tour-packages.index') }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-emerald-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Packages</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $packages->total() }}</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">With Guide</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $packages->where('includes_guide', true)->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">With Transport</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $packages->where('includes_transport', true)->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Current Page</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $packages->currentPage() }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Table/Cards -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Package Name</th>
                            @if($displayMode === 'all')
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price (IDR)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price (USD)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price (CNY)</th>
                            @else
                                @php
                                    $colLabel = $displayMode === 'idr' ? 'Price (IDR)' : ($displayMode === 'cny' ? 'Price (CNY)' : 'Price (USD)');
                                @endphp

                        /* De-emphasize secondary currency lines on desktop */
                        .secondary-currency { font-size: 0.95rem; opacity: 0.9; }

                        </style>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const select = document.getElementById('currency-select');
                            const form = document.getElementById('packages-search-form');
                            if (select && form) {
                                select.addEventListener('change', function() {
                                    form.submit();
                                });
                            }
                        });
                        </script>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ $colLabel }}</th>
                            @endif
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Guide</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Transport</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($packages as $package)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-20 h-20 rounded-lg overflow-hidden shadow-md bg-gradient-to-br from-emerald-400 to-teal-500">
                                    @if($package->image)
                                        @include('components.responsive-image', [
                                            'path' => $package->image, 
                                            'alt' => $package->name_en ?? '', 
                                            'class' => 'w-full h-full object-cover', 
                                            'derivatives' => $package->image_derivatives ?? null
                                        ])
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">ID</span>
                                        <span class="font-medium text-gray-900">{{ $package->name_id }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">EN</span>
                                        <span class="text-sm text-gray-600">{{ $package->name_en }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mr-2">ZH</span>
                                        <span class="text-sm text-gray-600">{{ $package->name_zh }}</span>
                                    </div>
                                </div>
                            </td>
                            @if($displayMode === 'all')
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-emerald-600">Rp {{ number_format($package->price_idr, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-blue-600">$ {{ number_format($package->price_usd, 2, '.', ',') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-red-600">¥ {{ number_format($package->price_cny, 2, '.', ',') }}</span>
                                </td>
                            @else
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($displayMode === 'idr')
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-emerald-600">Rp {{ number_format($package->price_idr, 0, ',', '.') }}</span>
                                            <div class="mt-1 secondary-currency">
                                                <span class="text-sm text-blue-600">$ {{ number_format($package->price_usd, 2, '.', ',') }}</span>
                                                <span class="text-sm text-red-600 ml-2">¥ {{ number_format($package->price_cny, 2, '.', ',') }}</span>
                                            </div>
                                        </div>
                                    @elseif($displayMode === 'cny')
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-red-600">¥ {{ number_format($package->price_cny, 2, '.', ',') }}</span>
                                            <div class="mt-1 secondary-currency">
                                                <span class="text-sm text-emerald-600">Rp {{ number_format($package->price_idr, 0, ',', '.') }}</span>
                                                <span class="text-sm text-blue-600 ml-2">$ {{ number_format($package->price_usd, 2, '.', ',') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-blue-600">$ {{ number_format($package->price_usd, 2, '.', ',') }}</span>
                                            <div class="mt-1 secondary-currency">
                                                <span class="text-sm text-emerald-600">Rp {{ number_format($package->price_idr, 0, ',', '.') }}</span>
                                                <span class="text-sm text-red-600 ml-2">¥ {{ number_format($package->price_cny, 2, '.', ',') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($package->includes_guide)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ya
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tidak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($package->includes_transport)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ya
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tidak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.tour-packages.edit', $package) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.tour-packages.destroy', $package) }}" 
                                          method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus package ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Tidak ada data tour package</p>
                                <p class="text-gray-400 text-sm mt-1">Tambahkan package pertama Anda!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden divide-y divide-gray-200">
                @forelse($packages as $package)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="space-y-3">
                        <!-- Package Image -->
                        <div class="w-full h-48 rounded-xl overflow-hidden shadow-md bg-gradient-to-br from-emerald-400 to-teal-500">
                            @if($package->image)
                                @include('components.responsive-image', [
                                    'path' => $package->image, 
                                    'alt' => $package->name_en ?? '', 
                                    'class' => 'w-full h-full object-cover', 
                                    'derivatives' => $package->image_derivatives ?? null
                                ])
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Package Names -->
                        <div>
                            <div class="flex items-center mb-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">ID</span>
                                <span class="font-semibold text-gray-900">{{ $package->name_id }}</span>
                            </div>
                            <div class="flex items-center mb-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">EN</span>
                                <span class="text-sm text-gray-600">{{ $package->name_en }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mr-2">ZH</span>
                                <span class="text-sm text-gray-600">{{ $package->name_zh }}</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <span class="text-sm text-gray-600">Harga</span>
                            <div class="flex flex-col items-end">
                                <span class="text-lg font-bold text-emerald-600">Rp {{ number_format($package->price_idr, 0, ',', '.') }}</span>
                                <span class="text-lg font-bold text-blue-600">$ {{ number_format($package->price_usd, 2, '.', ',') }}</span>
                                <span class="text-lg font-bold text-red-600">¥ {{ number_format($package->price_cny, 2, '.', ',') }}</span>
                            </div>
                        </div>

                        <!-- Includes -->
                        <div class="flex gap-2">
                            @if($package->includes_guide)
                                <span class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Guide
                                </span>
                            @else
                                <span class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold bg-gray-100 text-gray-500">
                                    No Guide
                                </span>
                            @endif

                            @if($package->includes_transport)
                                <span class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Transport
                                </span>
                            @else
                                <span class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold bg-gray-100 text-gray-500">
                                    No Transport
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('admin.tour-packages.edit', $package) }}" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.tour-packages.destroy', $package) }}" 
                                  method="POST" 
                                  class="flex-1" 
                                  onsubmit="return confirm('Yakin ingin menghapus package ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors font-medium text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada data tour package</p>
                    <p class="text-gray-400 text-sm mt-1">Tambahkan package pertama Anda!</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($packages->hasPages())
            <div class="mt-6 bg-white rounded-xl shadow-md p-4">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection