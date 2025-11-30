@extends('layouts.admin')

@section('page-title', 'Edit Tour Package')

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
                        <a href="{{ route('admin.tour-packages.index') }}" class="ml-1 text-sm font-medium text-gray-600 hover:text-emerald-600 md:ml-2">Tour Packages</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Edit Package</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Tour Package</h1>
                    <p class="text-gray-600">Update the details of <span class="font-semibold text-emerald-600">{{ $tourPackage->name_en ?? $tourPackage->name_id }}</span></p>
                </div>
                <div class="flex items-center space-x-3 flex-wrap gap-2">
                    <a href="{{ route('admin.tour-packages.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Flash & Errors --}}
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
                <form action="{{ route('admin.tour-packages.update', $tourPackage) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Pricing Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8"/>
                                </svg>
                                Pricing
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="price_idr_display" class="block text-sm font-semibold text-gray-700 mb-2">Price (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded">IDR</span>
                                    <input type="hidden" name="price_idr" id="price_idr" value="{{ old('price_idr', $tourPackage->price_idr ?? '') }}">
                                    <input type="text" id="price_idr_display" autocomplete="off"
                                           value="{{ old('price_idr', $tourPackage->price_idr ?? '') ? number_format(old('price_idr', $tourPackage->price_idr ?? 0), 0, ',', '.') : '' }}"
                                           class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price_idr') border-red-500 @enderror"
                                           placeholder="e.g. 1.500.000">
                                </div>
                                @error('price_idr')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="price_usd" class="block text-sm font-semibold text-gray-700 mb-2">Price (USD)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded">USD</span>
                                    <input type="number" name="price_usd" id="price_usd" step="0.01" min="0"
                                           value="{{ old('price_usd', $tourPackage->price_usd ?? '') }}"
                                           class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price_usd') border-red-500 @enderror"
                                           placeholder="e.g. 99.99">
                                </div>
                                @error('price_usd')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="price_cny" class="block text-sm font-semibold text-gray-700 mb-2">Price (CNY)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded">CNY</span>
                                    <input type="number" name="price_cny" id="price_cny" step="0.01" min="0"
                                           value="{{ old('price_cny', $tourPackage->price_cny ?? '') }}"
                                           class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price_cny') border-red-500 @enderror"
                                           placeholder="e.g. 699.00">
                                </div>
                                @error('price_cny')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Minimal Guests placed with pricing to match Tours layout --}}
                            <div class="md:col-span-3">
                                <label for="min_guests" class="block text-sm font-semibold text-gray-700 mb-2">Minimal Guest <span class="text-red-500">*</span></label>
                                <input type="number" name="min_guests" id="min_guests" value="{{ old('min_guests', $tourPackage->min_guests ?? 1) }}" required min="1"
                                       class="w-40 pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_guests') border-red-500 @enderror"
                                       placeholder="1">
                                @error('min_guests')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Package Names Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Nama Package
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="name_id" class="block text-sm font-semibold text-gray-700 mb-2">Nama Package (ID) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded">ID</span>
                                        <input type="text" name="name_id" id="name_id" value="{{ old('name_id', $tourPackage->name_id) }}" required
                                            class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_id') border-red-500 @enderror"
                                            placeholder="Nama dalam Bahasa Indonesia">
                                    </div>
                                    @error('name_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="name_en" class="block text-sm font-semibold text-gray-700 mb-2">Package Name (EN) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded">EN</span>
                                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $tourPackage->name_en) }}" required
                                            class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_en') border-red-500 @enderror"
                                            placeholder="Name in English">
                                    </div>
                                    @error('name_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="name_zh" class="block text-sm font-semibold text-gray-700 mb-2">套餐名称 (ZH) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 px-2 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded">ZH</span>
                                        <input type="text" name="name_zh" id="name_zh" value="{{ old('name_zh', $tourPackage->name_zh) }}" required
                                            class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_zh') border-red-500 @enderror"
                                            placeholder="中文名称">
                                    </div>
                                    @error('name_zh')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
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
                            <div>
                                <label for="description_id" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (ID) <span class="text-red-500">*</span></label>
                                <textarea name="description_id" id="description_id" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Deskripsi paket dalam Bahasa Indonesia">{{ old('description_id', $tourPackage->description_id ?? '') }}</textarea>
                                @error('description_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">Description (EN) <span class="text-red-500">*</span></label>
                                <textarea name="description_en" id="description_en" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Package description in English">{{ old('description_en', $tourPackage->description_en ?? '') }}</textarea>
                                @error('description_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description_zh" class="block text-sm font-semibold text-gray-700 mb-2">描述 (ZH) <span class="text-red-500">*</span></label>
                                <textarea name="description_zh" id="description_zh" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="套餐描述（中文）">{{ old('description_zh', $tourPackage->description_zh ?? '') }}</textarea>
                                @error('description_zh')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Itinerary Card --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                Itinerary (Jadwal Perjalanan)
                            </h3>
                        </div>
                        <div class="p-6">
                            <div id="itinerary-container" class="space-y-6">
                                @php
                                    $existingItinerary = old('itinerary', $tourPackage->itinerary ?? []);
                                    if (is_string($existingItinerary)) {
                                        $decoded = json_decode($existingItinerary, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $existingItinerary = $decoded;
                                        } else {
                                            $existingItinerary = [];
                                        }
                                    }
                                    if (!is_array($existingItinerary) || empty($existingItinerary)) {
                                        $existingItinerary = [[ 'title_id' => '', 'title_en' => '', 'title_zh' => '', 'description_id' => '', 'description_en' => '', 'description_zh' => '' ]];
                                    }
                                @endphp

                                @foreach($existingItinerary as $index => $item)
                                    @php
                                        $titleId = $item['title_id'] ?? '';
                                        $titleEn = $item['title_en'] ?? '';
                                        $titleZh = $item['title_zh'] ?? '';
                                        $descId = $item['description_id'] ?? '';
                                        $descEn = $item['description_en'] ?? '';
                                        $descZh = $item['description_zh'] ?? '';
                                    @endphp
                                    <div class="itinerary-item border-2 border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-lg font-bold text-gray-800 flex items-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold mr-3">{{ $index + 1 }}</span>
                                                Day {{ $index + 1 }}
                                            </h4>
                                            <button type="button" class="remove-itinerary text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors {{ count($existingItinerary) <= 1 ? 'hidden' : '' }}" title="Hapus Item">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4">
                                            <div><label class="block text-sm font-semibold text-gray-700 mb-2">Judul (ID) *</label><input type="text" name="itinerary[{{ $index }}][title_id]" value="{{ $titleId }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                                            <div><label class="block text-sm font-semibold text-gray-700 mb-2">Title (EN) *</label><input type="text" name="itinerary[{{ $index }}][title_en]" value="{{ $titleEn }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                                            <div><label class="block text-sm font-semibold text-gray-700 mb-2">标题 (ZH) *</label><input type="text" name="itinerary[{{ $index }}][title_zh]" value="{{ $titleZh }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                                            <div><label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (ID) *</label><textarea name="itinerary[{{ $index }}][description_id]" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $descId }}</textarea></div>
                                            <div><label class="block text-sm font-semibold text-gray-700 mb-2">Description (EN) *</label><textarea name="itinerary[{{ $index }}][description_en]" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $descEn }}</textarea></div>
                                            <div><label class="block text-sm font-semibold text-gray-700 mb-2">描述 (ZH) *</label><textarea name="itinerary[{{ $index }}][description_zh]" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $descZh }}</textarea></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4"><button type="button" id="add-itinerary" class="w-full inline-flex items-center justify-center px-4 py-3 border-2 border-dashed border-emerald-300 text-emerald-600 font-semibold rounded-lg hover:bg-emerald-50 hover:border-emerald-400 transition-colors"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>Tambah Hari Berikutnya</button></div>
                        </div>
                    </div>

                    {{-- Image & Tours selection --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center"><svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Gambar Package & Tours Terkait</h3></div>
                        <div class="p-6 space-y-4">
                            @if($tourPackage->image)
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Gambar Saat Ini</label>
                                    <div class="relative group"><div class="max-h-80 rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">@include('components.responsive-image', ['path' => $tourPackage->image, 'alt' => $tourPackage->name_en ?? 'Package Image', 'class' => 'w-full h-full object-cover', 'derivatives' => $tourPackage->image_derivatives ?? null])</div></div>
                                </div>
                            @endif

                            <div>
                                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">{{ $tourPackage->image ? 'Upload Gambar Baru (Opsional)' : 'Upload Gambar Package' }}</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 transition-colors bg-gray-50">
                                    <div class="space-y-1 text-center"><svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <div class="flex text-sm text-gray-600"><label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500"><span>Upload a file</span><input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)"></label><p class="pl-1">or drag and drop</p></div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                @if($tourPackage->image)<p class="mt-2 text-sm text-amber-600">Upload gambar baru akan menggantikan gambar yang ada</p>@endif
                            </div>

                            @if(\App\Models\Tour::count() > 0)
                                <div>
                                    <label for="tours" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tours (Multiple Select)</label>
                                    <select name="tours[]" id="tours" multiple class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" size="5">
                                        @foreach(\App\Models\Tour::all() as $tour)
                                            <option value="{{ $tour->id }}" {{ in_array($tour->id, old('tours', $tourPackage->tours->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>{{ $tour->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-sm text-gray-500">Tekan Ctrl (Cmd di Mac) untuk memilih beberapa tours</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-semibold flex items-center justify-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Update Package</button>
                        <a href="{{ route('admin.tour-packages.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">Cancel</a>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Quick Info</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200"><span class="text-sm text-gray-600">Status</span><span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($tourPackage->status ?? 'active') === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($tourPackage->status ?? 'active') }}</span></div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200"><span class="text-sm text-gray-600">Created</span><span class="text-sm font-medium text-gray-800">{{ $tourPackage->created_at ? $tourPackage->created_at->format('M d, Y') : '-' }}</span></div>
                        <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Last Updated</span><span class="text-sm font-medium text-gray-800">{{ $tourPackage->updated_at ? $tourPackage->updated_at->format('M d, Y') : '-' }}</span></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200"><h3 class="text-lg font-semibold text-gray-800">Actions</h3></div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.tour-packages.index') }}" class="flex items-center justify-center w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">View packages</a>
                        <form action="{{ route('admin.tour-packages.destroy', $tourPackage) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center justify-center w-full px-4 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition font-medium">Delete Package</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            if (img) img.src = e.target.result;
            if (preview) preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // price_idr display formatting
    const hidden = document.getElementById('price_idr');
    const disp = document.getElementById('price_idr_display');
    function formatNumber(n) { if (n === null || n === undefined || n === '') return ''; try { return new Intl.NumberFormat('id-ID').format(Number(n)); } catch(e){ return n; } }
    function rawDigits(str) { return (str || '').toString().replace(/[^0-9]/g, ''); }
    if (hidden && disp) {
        disp.value = hidden.value ? formatNumber(hidden.value) : '';
        disp.addEventListener('input', function() {
            const raw = rawDigits(disp.value);
            hidden.value = raw;
            disp.value = raw ? formatNumber(raw) : '';
            try { disp.setSelectionRange(disp.value.length, disp.value.length); } catch(e) {}
        });
        disp.addEventListener('blur', function() { disp.value = hidden.value ? formatNumber(hidden.value) : ''; });
    }

    // Itinerary manager
    let itineraryIndex = document.querySelectorAll('.itinerary-item').length || 0;
    document.getElementById('add-itinerary')?.addEventListener('click', function(){
        const container = document.getElementById('itinerary-container');
        const idx = itineraryIndex;
        const newItem = document.createElement('div');
        newItem.className = 'itinerary-item border-2 border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white';
        newItem.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-gray-800 flex items-center"><span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold mr-3">${idx + 1}</span>Day ${idx + 1}</h4>
                <button type="button" class="remove-itinerary text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Hapus Item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Judul (ID) *</label><input type="text" name="itinerary[${idx}][title_id]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Title (EN) *</label><input type="text" name="itinerary[${idx}][title_en]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">标题 (ZH) *</label><input type="text" name="itinerary[${idx}][title_zh]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (ID) *</label><textarea name="itinerary[${idx}][description_id]" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Description (EN) *</label><textarea name="itinerary[${idx}][description_en]" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">描述 (ZH) *</label><textarea name="itinerary[${idx}][description_zh]" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea></div>
            </div>
        `;
        container.appendChild(newItem);
        itineraryIndex++;
        updateRemoveButtons();
    });

    document.getElementById('itinerary-container')?.addEventListener('click', function(e){
        if (e.target.closest('.remove-itinerary')) {
            const item = e.target.closest('.itinerary-item');
            if (document.querySelectorAll('.itinerary-item').length > 1) {
                item.remove();
                document.querySelectorAll('.itinerary-item').forEach((it, i)=>{
                    it.querySelector('span.inline-flex').textContent = i+1;
                    it.querySelectorAll('input, textarea').forEach(inp=>{
                        const name = inp.getAttribute('name'); if (name) inp.setAttribute('name', name.replace(/\[\d+\]/, `[${i}]`));
                    });
                });
                itineraryIndex = document.querySelectorAll('.itinerary-item').length;
            } else { alert('Minimal harus ada 1 hari dalam itinerary'); }
        }
    });

    function updateRemoveButtons(){ const items = document.querySelectorAll('.itinerary-item'); const removeButtons = document.querySelectorAll('.remove-itinerary'); if (items.length <= 1) removeButtons.forEach(b=>b.classList.add('hidden')); else removeButtons.forEach(b=>b.classList.remove('hidden')); }
    updateRemoveButtons();
});
</script>
@endpush

@endsection