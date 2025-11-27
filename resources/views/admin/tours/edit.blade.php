@extends('layouts.admin')

@section('page-title', 'Edit Tour')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-emerald-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
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
                        <a href="{{ route('admin.tours.index') }}" class="ml-1 text-sm font-medium text-gray-600 hover:text-emerald-600 md:ml-2">Tours</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Edit Tour</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Tour</h1>
                    <p class="text-gray-600">Update the details of <span class="font-semibold text-emerald-600">{{ $tour->name }}</span></p>
                </div>
                <div class="flex items-center space-x-3 flex-wrap gap-2">
                    <a href="{{ route('tours.show', $tour) }}?from=admin" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview
                    </a>
                    <a href="{{ route('admin.tours.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <x-alert type="success">
                <p class="font-medium">{{ session('success') }}</p>
            </x-alert>
        @endif
        @if($errors->any())
            <x-alert type="error">
                <p class="font-medium mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- Main Form --}}
            <div class="lg:col-span-3">
                <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Basic Information Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Basic Information
                            </h3>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            {{-- Tour Name - Multi-language --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    Tour Name (Multi-language) *
                                </label>
                                
                                <div class="space-y-3">
                                    {{-- Indonesian --}}
                                    <div>
                                        <label for="name_id" class="block text-xs font-medium text-gray-600 mb-1">🇮🇩 Indonesian</label>
                                        <input type="text" name="name_id" id="name_id" value="{{ old('name_id', $tour->name_id) }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_id') border-red-500 @enderror"
                                            placeholder="e.g., Jelajahi Bromo Tengah Malam">
                                        @error('name_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>

                                    {{-- English --}}
                                    <div>
                                        <label for="name_en" class="block text-xs font-medium text-gray-600 mb-1">🇬🇧 English</label>
                                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $tour->name_en) }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_en') border-red-500 @enderror"
                                            placeholder="e.g., Explore Bromo Midnight">
                                        @error('name_en')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>

                                    {{-- Chinese --}}
                                    <div>
                                        <label for="name_zh" class="block text-xs font-medium text-gray-600 mb-1">🇨🇳 Chinese</label>
                                        <input type="text" name="name_zh" id="name_zh" value="{{ old('name_zh', $tour->name_zh) }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_zh') border-red-500 @enderror"
                                            placeholder="e.g., 探索布罗莫午夜">
                                        @error('name_zh')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div>
                                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug *</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $tour->slug) }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                                    placeholder="e.g., explore-bromo-midnight">
                                @error('slug')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                <p class="text-xs text-gray-500 mt-1">URL-friendly version of the tour name</p>
                            </div>

                            {{-- Destination --}}
                            <div>
                                <label for="destination_id" class="block text-sm font-semibold text-gray-700 mb-2">Destination *</label>
                                <select name="destination_id" id="destination_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('destination_id') border-red-500 @enderror">
                                    <option value="">Select a destination...</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}" {{ old('destination_id', $tour->destination_id) == $destination->id ? 'selected' : '' }}>
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destination_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Descriptions Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Descriptions (Multi-language)
                            </h3>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            {{-- Indonesian Description --}}
                            <div>
                                <label for="description_id" class="block text-sm font-semibold text-gray-700 mb-2">🇮🇩 Description (Indonesian) *</label>
                                <textarea name="description_id" id="description_id" rows="4" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description_id') border-red-500 @enderror"
                                    placeholder="Deskripsi tour dalam bahasa Indonesia...">{{ old('description_id', $tour->description_id) }}</textarea>
                                @error('description_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            {{-- English Description --}}
                            <div>
                                <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">🇬🇧 Description (English) *</label>
                                <textarea name="description_en" id="description_en" rows="4" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description_en') border-red-500 @enderror"
                                    placeholder="Tour description in English...">{{ old('description_en', $tour->description_en) }}</textarea>
                                @error('description_en')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            {{-- Chinese Description --}}
                            <div>
                                <label for="description_zh" class="block text-sm font-semibold text-gray-700 mb-2">🇨🇳 Description (Chinese) *</label>
                                <textarea name="description_zh" id="description_zh" rows="4" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description_zh') border-red-500 @enderror"
                                    placeholder="中文旅游描述...">{{ old('description_zh', $tour->description_zh) }}</textarea>
                                @error('description_zh')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Pricing & Duration Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pricing & Duration
                            </h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-2 gap-4">
                            {{-- Price (USD) --}}
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">💵 Base Price (USD) *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">$</span>
                                    <input type="number" name="price" id="price" value="{{ old('price', $tour->price_usd ?? $tour->price ?? '') }}" required min="0" step="0.01"
                                        class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                        placeholder="0.00">
                                </div>
                                @error('price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                <p class="text-xs text-gray-500 mt-1">Other currencies will be auto-converted</p>
                            </div>

                            {{-- Duration --}}
                            <div>
                                <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">⏱️ Duration (Days) *</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration', $tour->duration) }}" required min="1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duration') border-red-500 @enderror"
                                    placeholder="1">
                                @error('duration')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Multi-Currency Pricing Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Multi-Currency Pricing
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-900">
                                    <strong>Tip:</strong> Set prices in all currencies, or enter USD and click "Auto-Convert" to convert automatically.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- USD Price --}}
                                <div>
                                    <label for="price_usd" class="block text-sm font-semibold text-gray-700 mb-2">
                                        💵 Price (USD) *
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                                        <input type="number" name="price_usd" id="price_usd" value="{{ old('price_usd', $tour->price_usd) }}" required min="0" step="0.01"
                                            class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_usd') border-red-500 @enderror"
                                            placeholder="0.00">
                                    </div>
                                    @error('price_usd')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                </div>

                                {{-- IDR Price --}}
                                <div>
                                    <label for="price_idr" class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇮🇩 Price (IDR)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                        <input type="number" name="price_idr" id="price_idr" value="{{ old('price_idr', $tour->price_idr) }}" min="0" step="0.01"
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_idr') border-red-500 @enderror"
                                            placeholder="0.00">
                                    </div>
                                    @error('price_idr')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                </div>

                                {{-- CNY Price --}}
                                <div>
                                    <label for="price_cny" class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇨🇳 Price (CNY) 
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-500">¥</span>
                                        <input type="number" name="price_cny" id="price_cny" value="{{ old('price_cny', $tour->price_cny) }}" min="0" step="0.01"
                                            class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_cny') border-red-500 @enderror"
                                            placeholder="0.00">
                                    </div>
                                    @error('price_cny')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            {{-- Exchange Rates --}}
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12M8 11h12m-12 4h12M3 7l1.293 1.293a1 1 0 000 1.414L3 11m0 4l1.293 1.293a1 1 0 000 1.414L3 19"/>
                                    </svg>
                                    Exchange Rates
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- IDR Exchange Rate --}}
                                    <div>
                                        <label for="exchange_rate_idr" class="block text-sm font-semibold text-gray-700 mb-2">
                                            1 USD = ? IDR
                                        </label>
                                        <input type="number" name="exchange_rate_idr" id="exchange_rate_idr" value="{{ old('exchange_rate_idr', $tour->exchange_rate_idr) }}" min="0" step="0.01"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                            placeholder="15000">
                                    </div>

                                    {{-- CNY Exchange Rate --}}
                                    <div>
                                        <label for="exchange_rate_cny" class="block text-sm font-semibold text-gray-700 mb-2">
                                            1 USD = ? CNY
                                        </label>
                                        <input type="number" name="exchange_rate_cny" id="exchange_rate_cny" value="{{ old('exchange_rate_cny', $tour->exchange_rate_cny) }}" min="0" step="0.01"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                            placeholder="6.5">
                                    </div>
                                </div>

                                {{-- Auto Convert Button --}}
                                <button type="button" onclick="autoConvertPrices()" class="mt-4 px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-semibold inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Auto-Convert from USD
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Media Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tour Image
                            </h3>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            {{-- Current Image Preview --}}
                            @if($tour->image)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Image</label>
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $tour->image) }}" 
                                         alt="{{ $tour->name }}" 
                                         class="w-full h-48 object-cover rounded-lg border-2 border-gray-200"
                                         onerror="this.onerror=null;this.src='{{ asset('images/fallback.png') }}';">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg flex items-center justify-center">
                                        <span class="text-white opacity-0 group-hover:opacity-100 transition font-medium">Current Tour Image</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Path: {{ $tour->image }}
                                </p>
                            </div>
                            @endif

                            {{-- Image Upload --}}
                            <div>
                                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                                    📸 Upload New Image
                                    @if(!$tour->image)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       accept="image/*"
                                       @if(!$tour->image) required @endif
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('image') border-red-500 @enderror"
                                       onchange="previewImage(event)">
                                @error('image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                                <p class="text-xs text-gray-500 mt-2">
                                    Accepted formats: JPG, PNG, WebP (Max: 4MB) • Recommended size: 1200x800px
                                </p>
                            </div>

                            {{-- Image Preview --}}
                            <div id="imagePreview" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">New Image Preview</label>
                                <div class="relative">
                                    <img id="previewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg border-2 border-emerald-300">
                                    <button type="button" 
                                            onclick="clearImagePreview()" 
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Itinerary Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Itinerary (Jadwal Perjalanan)
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            
                            
                            <div id="itinerary-container" class="space-y-6">
                                @php
                                    // Ambil data itinerary dari old() atau database
                                    $existingItinerary = old('itinerary');
                                    
                                    // Jika tidak ada old data, ambil dari database
                                    if (!$existingItinerary) {
                                        $existingItinerary = $tour->itinerary;
                                    }
                                    
                                    
                                    
                                    // Jika string JSON, decode dulu
                                    if (is_string($existingItinerary)) {
                                        $decoded = json_decode($existingItinerary, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $existingItinerary = $decoded;
                                        } else {
                                            $existingItinerary = [];
                                        }
                                    }
                                    
                                    // Pastikan dalam bentuk array
                                    if (!is_array($existingItinerary)) {
                                        $existingItinerary = [];
                                    }
                                    
                                    // Jika kosong, buat minimal 1 item
                                    if (empty($existingItinerary)) {
                                        $existingItinerary = [[
                                            'title_id' => '',
                                            'title_en' => '',
                                            'title_zh' => '',
                                            'description_id' => '',
                                            'description_en' => '',
                                            'description_zh' => ''
                                        ]];
                                    }
                                    
                                    
                                @endphp

                                @foreach($existingItinerary as $index => $item)
                                @php
                                    // Konversi struktur lama ke struktur baru
                                    $titleId = '';
                                    $titleEn = '';
                                    $titleZh = '';
                                    $descId = '';
                                    $descEn = '';
                                    $descZh = '';
                                    
                                    // Cek apakah format baru (title_id exists) atau format lama (day exists)
                                    if (isset($item['title_id'])) {
                                        // Format baru - langsung ambil
                                        $titleId = $item['title_id'] ?? '';
                                        $titleEn = $item['title_en'] ?? '';
                                        $titleZh = $item['title_zh'] ?? '';
                                        $descId = $item['description_id'] ?? '';
                                        $descEn = $item['description_en'] ?? '';
                                        $descZh = $item['description_zh'] ?? '';
                                    } elseif (isset($item['day'])) {
                                        // Format lama - convert dari day/activities
                                        $titleId = is_array($item['day']) ? ($item['day']['id'] ?? '') : $item['day'];
                                        $titleEn = is_array($item['day']) ? ($item['day']['en'] ?? '') : $item['day'];
                                        $titleZh = is_array($item['day']) ? ($item['day']['zh'] ?? '') : $item['day'];
                                        
                                        // Gabungkan semua activities menjadi description
                                        if (isset($item['activities']) && is_array($item['activities'])) {
                                            $activitiesId = [];
                                            $activitiesEn = [];
                                            $activitiesZh = [];
                                            
                                            foreach ($item['activities'] as $activity) {
                                                if (is_array($activity)) {
                                                    $time = $activity['time'] ?? '';
                                                    $activitiesId[] = ($time ? "[$time] " : '') . ($activity['description_id'] ?? $activity['description'] ?? '');
                                                    $activitiesEn[] = ($time ? "[$time] " : '') . ($activity['description_en'] ?? $activity['description'] ?? '');
                                                    $activitiesZh[] = ($time ? "[$time] " : '') . ($activity['description_zh'] ?? $activity['description'] ?? '');
                                                } else {
                                                    // String activity
                                                    $activitiesId[] = $activity;
                                                    $activitiesEn[] = $activity;
                                                    $activitiesZh[] = $activity;
                                                }
                                            }
                                            
                                            $descId = implode("\n\n", $activitiesId);
                                            $descEn = implode("\n\n", $activitiesEn);
                                            $descZh = implode("\n\n", $activitiesZh);
                                        }
                                    }
                                @endphp
                                <div class="itinerary-item border-2 border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-bold text-gray-800 flex items-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold mr-3">{{ $index + 1 }}</span>
                                            Day {{ $index + 1 }}
                                        </h4>
                                        <button type="button" 
                                                class="remove-itinerary text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors {{ count($existingItinerary) <= 1 ? 'hidden' : '' }}"
                                                title="Hapus Item">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Title ID -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Judul (ID) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="itinerary[{{ $index }}][title_id]" 
                                                   value="{{ $titleId }}"
                                                   required 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                                   placeholder="Contoh: DAY 1 - Kedatangan di Surabaya">
                                        </div>

                                        <!-- Title EN -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Title (EN) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="itinerary[{{ $index }}][title_en]" 
                                                   value="{{ $titleEn }}"
                                                   required 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                                   placeholder="Example: DAY 1 - Arrival in Surabaya">
                                        </div>

                                        <!-- Title ZH -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                标题 (ZH) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="itinerary[{{ $index }}][title_zh]" 
                                                   value="{{ $titleZh }}"
                                                   required 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                                   placeholder="例如：第1天 - 抵达泗水">
                                        </div>

                                        <!-- Description ID -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Deskripsi (ID) <span class="text-red-500">*</span>
                                                <span class="text-xs text-gray-500 font-normal block mt-1">Format: [Waktu] Aktivitas. Pisahkan dengan enter 2x. Contoh: [Sore] Penjemputan di bandara</span>
                                            </label>
                                            <textarea name="itinerary[{{ $index }}][description_id]" 
                                                      rows="5" 
                                                      required 
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                                      placeholder="[Sore] Penjemputan di bandara&#10;&#10;[Malam] Check-in hotel">{{ $descId }}</textarea>
                                        </div>

                                        <!-- Description EN -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Description (EN) <span class="text-red-500">*</span>
                                                <span class="text-xs text-gray-500 font-normal block mt-1">Format: [Time] Activity. Separate with 2 enters. Example: [Evening] Airport pickup</span>
                                            </label>
                                            <textarea name="itinerary[{{ $index }}][description_en]" 
                                                      rows="5" 
                                                      required 
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                                      placeholder="[Evening] Airport pickup&#10;&#10;[Night] Hotel check-in">{{ $descEn }}</textarea>
                                        </div>

                                        <!-- Description ZH -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                描述 (ZH) <span class="text-red-500">*</span>
                                                <span class="text-xs text-gray-500 font-normal block mt-1">格式：[时间] 活动。用两个回车分隔。例如：[傍晚] 机场接机</span>
                                            </label>
                                            <textarea name="itinerary[{{ $index }}][description_zh]" 
                                                      rows="5" 
                                                      required 
                                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                                      placeholder="[傍晚] 机场接机&#10;&#10;[晚上] 酒店入住">{{ $descZh }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Add Itinerary Button -->
                            <div class="mt-4">
                                <button type="button" 
                                        id="add-itinerary" 
                                        class="w-full inline-flex items-center justify-center px-4 py-3 border-2 border-dashed border-emerald-300 text-emerald-600 font-semibold rounded-lg hover:bg-emerald-50 hover:border-emerald-400 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Hari Berikutnya
                                </button>
                            </div>
                        </div>
                    </div>                    {{-- Includes Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                What's Included (JSON Array)
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @php
                                // Handle both string and array formats
                                if (is_string($tour->includes)) {
                                    $includesValue = $tour->includes;
                                } elseif (is_array($tour->includes) || is_object($tour->includes)) {
                                    $includesValue = json_encode($tour->includes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                } else {
                                    $includesValue = '[]';
                                }
                            @endphp
                            <textarea name="includes" id="includes" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm @error('includes') border-red-500 @enderror"
                                placeholder='["Tour Guide","Transportation","Meals"]'>{{ old('includes', $includesValue) }}</textarea>
                            @error('includes')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            <p class="text-xs text-gray-500 mt-2">Format: ["Item 1","Item 2","Item 3"]</p>
                            <button type="button" onclick="formatJSON('includes')" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300 transition">
                                Format JSON
                            </button>
                        </div>
                    </div>

                    {{-- Excludes Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2M9 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                What's Not Included (JSON Array)
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @php
                                // Handle both string and array formats
                                if (is_string($tour->excludes)) {
                                    $excludesValue = $tour->excludes;
                                } elseif (is_array($tour->excludes) || is_object($tour->excludes)) {
                                    $excludesValue = json_encode($tour->excludes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                } else {
                                    $excludesValue = '[]';
                                }
                            @endphp
                            <textarea name="excludes" id="excludes" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm @error('excludes') border-red-500 @enderror"
                                placeholder='["Airfare","Hotel"]'>{{ old('excludes', $excludesValue) }}</textarea>
                            @error('excludes')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            <p class="text-xs text-gray-500 mt-2">Format: ["Item 1","Item 2"]</p>
                            <button type="button" onclick="formatJSON('excludes')" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300 transition">
                                Format JSON
                            </button>
                        </div>
                    </div>

                    {{-- Status & Featured Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.34 5.34l1.41 1.41m2.83-2.83l1.41 1.41m2.83-2.83l1.41 1.41"/>
                                </svg>
                                Settings
                            </h3>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            {{-- Status --}}
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="active" {{ old('status', $tour->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $tour->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            {{-- Featured --}}
                            <div class="flex items-center">
                                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $tour->featured) ? 'checked' : '' }}
                                    class="w-4 h-4 text-emerald-600 rounded focus:ring-2 focus:ring-emerald-500">
                                <label for="featured" class="ml-2 text-sm font-semibold text-gray-700">Mark as Featured</label>
                            </div>
                        </div>
                    </div>

                    {{-- Target Market Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20H7m6 0v-1a6 6 0 00-6-6H9a6 6 0 00-6 6v1"/>
                                </svg>
                                Target Market
                            </h3>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <p class="text-sm text-gray-600">Select which market this tour is intended for:</p>
                            
                            <div class="space-y-3">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer" 
                                    :class="{'border-emerald-500 bg-emerald-50': '{{ old('target_market', $tour->target_market) }}' === 'domestic'}">
                                    <input type="radio" name="target_market" value="domestic" 
                                        {{ old('target_market', $tour->target_market) === 'domestic' ? 'checked' : '' }}
                                        class="w-4 h-4 text-emerald-600">
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">🇮🇩 Domestic (Indonesia Only)</p>
                                        <p class="text-sm text-gray-600">Tour khusus untuk wisatawan lokal Indonesia</p>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer"
                                    :class="{'border-emerald-500 bg-emerald-50': '{{ old('target_market', $tour->target_market) }}' === 'international'}">
                                    <input type="radio" name="target_market" value="international" 
                                        {{ old('target_market', $tour->target_market) === 'international' ? 'checked' : '' }}
                                        class="w-4 h-4 text-emerald-600">
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">🌍 International Only</p>
                                        <p class="text-sm text-gray-600">Tour khusus untuk wisatawan mancanegara</p>
                                    </div>
                                </label>

                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer"
                                    :class="{'border-emerald-500 bg-emerald-50': '{{ old('target_market', $tour->target_market) }}' === 'both'}">
                                    <input type="radio" name="target_market" value="both" 
                                        {{ old('target_market', $tour->target_market) === 'both' ? 'checked' : '' }}
                                        class="w-4 h-4 text-emerald-600">
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">🌐 Both Markets</p>
                                        <p class="text-sm text-gray-600">Tour tersedia untuk semua wisatawan</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex gap-3">
                        <button type="submit" 
                            class="flex-1 px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-semibold flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Tour
                        </button>
                        <a href="{{ route('admin.tours.index') }}" 
                            class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Quick Info Card --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Quick Info
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($tour->status ?? 'active') === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($tour->status ?? 'active') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <span class="text-sm text-gray-600">Featured</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $tour->featured ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $tour->featured ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <span class="text-sm text-gray-600">Created</span>
                            <span class="text-sm font-medium text-gray-800">{{ $tour->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Last Updated</span>
                            <span class="text-sm font-medium text-gray-800">{{ $tour->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions Card --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('tours.show', $tour) }}?from=admin" 
                           target="_blank"
                           class="flex items-center justify-center w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            View on Website
                        </a>
                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center justify-center w-full px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Tour
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Help Card --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 mb-2">JSON Format Tips</h4>
                            <ul class="text-sm text-blue-800 space-y-2">
                                <li><strong>Itinerary:</strong> Use day-activities format</li>
                                <li><strong>Includes/Excludes:</strong> Simple array of strings</li>
                                <li><strong>Validate:</strong> Use online JSON validators</li>
                                <li><strong>Pretty Print:</strong> Use proper indentation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview function
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function clearImagePreview() {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    imageInput.value = '';
    preview.classList.add('hidden');
}

// Auto-generate slug from name
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name_en'); // Use English name for slug
        const slugInput = document.getElementById('slug');
        
        if (nameInput && slugInput) {
            nameInput.addEventListener('change', function() {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                
                slugInput.value = slug;
            });

            // Optional: Real-time slug generation on input
            nameInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                
                slugInput.value = slug;
            });
        }
    });

    // Format JSON with pretty print and validation
    function formatJSON(textareaId) {
        const textarea = document.getElementById(textareaId);
        
        if (!textarea) {
            return;
        }

        try {
            const value = textarea.value.trim();
            
            // Skip empty values
            if (!value || value === '[]' || value === '{}') {
                return;
            }

            const obj = JSON.parse(value);
            textarea.value = JSON.stringify(obj, null, 2);
            
            // Visual feedback
            textarea.classList.remove('border-red-500');
            textarea.classList.add('border-green-500');
            
            setTimeout(() => {
                textarea.classList.remove('border-green-500');
            }, 3000);
            
        } catch (e) {
            // Visual feedback for error
            textarea.classList.add('border-red-500');
        }
    }

    // Validate JSON before form submission
    function validateJSONBeforeSubmit() {
        const jsonFields = ['itinerary', 'includes', 'excludes'];
        let isValid = true;

        jsonFields.forEach(fieldId => {
            const textarea = document.getElementById(fieldId);
            const errorSpan = document.getElementById(fieldId + '-error');
            if (textarea && textarea.value.trim()) {
                try {
                    JSON.parse(textarea.value);
                    textarea.classList.remove('border-red-500');
                    if (errorSpan) errorSpan.classList.add('hidden');
                } catch (e) {
                    textarea.classList.add('border-red-500');
                    if (errorSpan) errorSpan.classList.remove('hidden');
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            // Optionally scroll to first error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        
        return true;
    }


    // Initialize format buttons and validation
    document.addEventListener('DOMContentLoaded', function() {
        const jsonFields = ['itinerary', 'includes', 'excludes'];

        
        // Attach validation to form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateJSONBeforeSubmit()) {
                    e.preventDefault();
                }
            });
        }
    });

    // Helper function to copy text to clipboard
    function copyToClipboard(text, fieldId) {
        navigator.clipboard.writeText(text).then(() => {
            const textarea = document.getElementById(fieldId);
            if (textarea) {
                textarea.classList.add('border-blue-500');
                setTimeout(() => textarea.classList.remove('border-blue-500'), 2000);
            }
        });
    }

    // Auto-convert USD to other currencies
    function autoConvertPrices() {
        const usdInput = document.getElementById('price_usd');
        const idrInput = document.getElementById('price_idr');
        const cnyInput = document.getElementById('price_cny');
        const idrRateInput = document.getElementById('exchange_rate_idr');
        const cnyRateInput = document.getElementById('exchange_rate_cny');

        if (!usdInput || !idrInput || !cnyInput || !idrRateInput || !cnyRateInput) return;

        const usdPrice = parseFloat(usdInput.value);
        const idrRate = parseFloat(idrRateInput.value) || 15000;
        const cnyRate = parseFloat(cnyRateInput.value) || 6.5;

        if (isNaN(usdPrice) || usdPrice <= 0) {
            showTemporaryMessage(usdInput, 'Please enter a valid USD price');
            return;
        }

        idrInput.value = (usdPrice * idrRate).toFixed(2);
        cnyInput.value = (usdPrice * cnyRate).toFixed(2);

        [idrInput, cnyInput].forEach(input => {
            input.classList.add('border-green-500', 'bg-green-50');
            setTimeout(() => {
                input.classList.remove('border-green-500', 'bg-green-50');
            }, 3000);
        });
    }

    function showTemporaryMessage(element, message) {
        const msg = document.createElement('div');
        msg.textContent = message;
        msg.className = 'absolute bg-red-500 text-white text-xs rounded px-2 py-1 mt-1';
        element.parentElement.style.position = 'relative';
        element.parentElement.appendChild(msg);
        setTimeout(() => msg.remove(), 3000);
    }


    // Real-time exchange rate update
    document.getElementById('price_usd').addEventListener('input', function() {
        // Update hints saat USD berubah
        const usdPrice = parseFloat(this.value);
        if (usdPrice > 0) {
            const idrRate = parseFloat(document.getElementById('exchange_rate_idr').value) || 15000;
            const cnyRate = parseFloat(document.getElementById('exchange_rate_cny').value) || 6.5;
            
            // Show preview (optional)
        }
    });

    // Itinerary Management
    let itineraryIndex = document.querySelectorAll('.itinerary-item').length;

    // Add new itinerary day
    document.getElementById('add-itinerary')?.addEventListener('click', function() {
        const container = document.getElementById('itinerary-container');
        const newItem = `
            <div class="itinerary-item border-2 border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold mr-3">${itineraryIndex + 1}</span>
                        Day ${itineraryIndex + 1}
                    </h4>
                    <button type="button" 
                            class="remove-itinerary text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors"
                            title="Hapus Item">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Judul (ID) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="itinerary[${itineraryIndex}][title_id]" value="" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                               placeholder="Contoh: DAY ${itineraryIndex + 1} - Kedatangan di Surabaya">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Title (EN) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="itinerary[${itineraryIndex}][title_en]" value="" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                               placeholder="Example: DAY ${itineraryIndex + 1} - Arrival in Surabaya">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            标题 (ZH) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="itinerary[${itineraryIndex}][title_zh]" value="" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                               placeholder="例如：第${itineraryIndex + 1}天 - 抵达泗水">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi (ID) <span class="text-red-500">*</span>
                            <span class="text-xs text-gray-500 font-normal block mt-1">Format: [Waktu] Aktivitas. Pisahkan dengan enter 2x. Contoh: [Sore] Penjemputan di bandara</span>
                        </label>
                        <textarea name="itinerary[${itineraryIndex}][description_id]" rows="5" required 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                  placeholder="[Sore] Penjemputan di bandara&#10;&#10;[Malam] Check-in hotel"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (EN) <span class="text-red-500">*</span>
                            <span class="text-xs text-gray-500 font-normal block mt-1">Format: [Time] Activity. Separate with 2 enters. Example: [Evening] Airport pickup</span>
                        </label>
                        <textarea name="itinerary[${itineraryIndex}][description_en]" rows="5" required 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                  placeholder="[Evening] Airport pickup&#10;&#10;[Night] Hotel check-in"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            描述 (ZH) <span class="text-red-500">*</span>
                            <span class="text-xs text-gray-500 font-normal block mt-1">格式：[时间] 活动。用两个回车分隔。例如：[傍晚] 机场接机</span>
                        </label>
                        <textarea name="itinerary[${itineraryIndex}][description_zh]" rows="5" required 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                  placeholder="[傍晚] 机场接机&#10;&#10;[晚上] 酒店入住"></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newItem);
        itineraryIndex++;
    });

    // Remove itinerary day (event delegation)
    document.getElementById('itinerary-container')?.addEventListener('click', function(e) {
        if (e.target.closest('.remove-itinerary')) {
            const item = e.target.closest('.itinerary-item');
            if (document.querySelectorAll('.itinerary-item').length > 1) {
                item.remove();
                // Reindex remaining items
                document.querySelectorAll('.itinerary-item').forEach((item, index) => {
                    item.querySelector('span.bg-emerald-500').textContent = index + 1;
                    item.querySelector('h4').childNodes[2].textContent = ` Day ${index + 1}`;
                });
            } else {
                alert('Minimal harus ada 1 hari dalam itinerary');
            }
        }
    });

    

    // Tour form script loaded
</script>
@endsection