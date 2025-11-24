@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.tour-packages.index') }}" 
                   class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Edit Tour Package</h1>
            <p class="text-gray-600">Update informasi paket wisata</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg">
                    <strong class="font-semibold">There were validation errors:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

                <!-- Pricing Section (always visible) -->
                <form action="{{ route('admin.tour-packages.update', $tourPackage) }}" 
                            method="POST" 
                            enctype="multipart/form-data" 
                            class="space-y-6">
                        @csrf
                        @method('PUT')

                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8"/>
                </svg>
                Pricing (Editable)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
            </div>
        </div>

                        <!-- Package Names Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Nama Package
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Indonesian -->
                    <div>
                        <label for="name_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Package (ID) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded">ID</span>
                            <input type="text" 
                                   name="name_id" 
                                   id="name_id" 
                                   value="{{ old('name_id', $tourPackage->name_id) }}" 
                                   required 
                                   class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_id') border-red-500 @enderror" 
                                   placeholder="Nama dalam Bahasa Indonesia">
                        </div>
                        @error('name_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- English -->
                    <div>
                        <label for="name_en" class="block text-sm font-semibold text-gray-700 mb-2">
                            Package Name (EN) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded">EN</span>
                            <input type="text" 
                                   name="name_en" 
                                   id="name_en" 
                                   value="{{ old('name_en', $tourPackage->name_en) }}" 
                                   required 
                                   class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_en') border-red-500 @enderror" 
                                   placeholder="Name in English">
                        </div>
                        @error('name_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chinese -->
                    <div>
                        <label for="name_zh" class="block text-sm font-semibold text-gray-700 mb-2">
                            套餐名称 (ZH) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 px-2 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded">ZH</span>
                            <input type="text" 
                                   name="name_zh" 
                                   id="name_zh" 
                                   value="{{ old('name_zh', $tourPackage->name_zh) }}" 
                                   required 
                                   class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_zh') border-red-500 @enderror" 
                                   placeholder="中文名称">
                        </div>
                        @error('name_zh')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

                <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Itinerary manager (no debug logs)
                let itineraryCount = {{ isset($existingItinerary) ? count($existingItinerary) : 0 }};
                const addButton = document.getElementById('add-itinerary');
                const container = document.getElementById('itinerary-container');

                // Add new itinerary item
                addButton.addEventListener('click', function() {
                    const newItem = document.createElement('div');
                    newItem.className = 'itinerary-item border-2 border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white';
                    newItem.innerHTML = `
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold mr-3">${itineraryCount + 1}</span>
                                Day ${itineraryCount + 1}
                            </h3>
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
                                <input type="text" 
                                       name="itinerary[${itineraryCount}][title_id]" 
                                       required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                       placeholder="Contoh: Hari Kedua - Eksplorasi Pantai">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Title (EN) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="itinerary[${itineraryCount}][title_en]" 
                                       required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                       placeholder="Example: Second Day - Beach Exploration">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    标题 (ZH) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="itinerary[${itineraryCount}][title_zh]" 
                                       required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                       placeholder="例如：第二天 - 海滩探索">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi (ID) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="itinerary[${itineraryCount}][description_id]" 
                                          rows="3" 
                                          required 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                          placeholder="Jelaskan aktivitas di hari ini..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Description (EN) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="itinerary[${itineraryCount}][description_en]" 
                                          rows="3" 
                                          required 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                          placeholder="Describe today's activities..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    描述 (ZH) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="itinerary[${itineraryCount}][description_zh]" 
                                          rows="3" 
                                          required 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                          placeholder="描述今天的活动..."></textarea>
                            </div>
                        </div>
                    `;

                    container.appendChild(newItem);
                    itineraryCount++;
                    updateRemoveButtons();
                });

                // Remove itinerary item
                container.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-itinerary')) {
                        const item = e.target.closest('.itinerary-item');
                        const itemIndex = Array.from(container.querySelectorAll('.itinerary-item')).indexOf(item);

                        item.remove();
                        updateDayNumbers();
                        updateRemoveButtons();
                    }
                });

                // Update day numbers AND field names after removal
                function updateDayNumbers() {
                    const items = container.querySelectorAll('.itinerary-item');

                    items.forEach((item, index) => {
                        const dayNumber = index + 1;
                        const badge = item.querySelector('span.inline-flex');
                        const heading = item.querySelector('h3');
                        if (badge) badge.textContent = dayNumber;
                        if (heading && heading.childNodes[1]) heading.childNodes[1].textContent = ` Day ${dayNumber}`;

                        // Update nama field agar index berurutan
                        const inputs = item.querySelectorAll('input[type="text"], textarea');
                        inputs.forEach(input => {
                            const oldName = input.getAttribute('name');
                            if (oldName) {
                                const newName = oldName.replace(/\[(\d+)\]/, `[${index}]`);
                                if (oldName !== newName) input.setAttribute('name', newName);
                            }
                        });
                    });
                    itineraryCount = items.length;
                }

                // Show/hide remove buttons (hide if only one item)
                function updateRemoveButtons() {
                    const items = container.querySelectorAll('.itinerary-item');
                    const removeButtons = container.querySelectorAll('.remove-itinerary');

                    if (items.length <= 1) {
                        removeButtons.forEach(btn => btn.classList.add('hidden'));
                    } else {
                        removeButtons.forEach(btn => btn.classList.remove('hidden'));
                    }
                }

                // Initialize remove button visibility
                updateRemoveButtons();
            });

            // Image preview function
            function previewImage(event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('image-preview');
                        const img = document.getElementById('preview-img');
                        img.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            </script>
            
            {{-- Descriptions Section --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    Descriptions
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="description_id" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (ID) <span class="text-red-500">*</span></label>
                        <textarea name="description_id" id="description_id" rows="4" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Deskripsi paket dalam Bahasa Indonesia">{{ old('description_id', $tourPackage->description_id ?? '') }}</textarea>
                        @error('description_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">Description (EN) <span class="text-red-500">*</span></label>
                        <textarea name="description_en" id="description_en" rows="4" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Package description in English">{{ old('description_en', $tourPackage->description_en ?? '') }}</textarea>
                        @error('description_en')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description_zh" class="block text-sm font-semibold text-gray-700 mb-2">描述 (ZH) <span class="text-red-500">*</span></label>
                        <textarea name="description_zh" id="description_zh" rows="4" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="套餐描述（中文）">{{ old('description_zh', $tourPackage->description_zh ?? '') }}</textarea>
                        @error('description_zh')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
            <script>
            // price_idr display formatting: keep hidden numeric input in sync
            document.addEventListener('DOMContentLoaded', function() {
                const hidden = document.getElementById('price_idr');
                const disp = document.getElementById('price_idr_display');
                function formatNumber(n) {
                    if (n === null || n === undefined || n === '') return '';
                    try {
                        return new Intl.NumberFormat('id-ID').format(Number(n));
                    } catch(e) {
                        return n;
                    }
                }

                function rawDigits(str) {
                    return (str || '').toString().replace(/[^0-9]/g, '');
                }

                // initialize display from hidden
                if (hidden && disp) {
                    disp.value = hidden.value ? formatNumber(hidden.value) : '';

                    // when user types in display, update hidden with raw number and reformat
                    disp.addEventListener('input', function(e) {
                        const raw = rawDigits(disp.value);
                        hidden.value = raw;
                        const cursorPos = disp.selectionStart;
                        disp.value = raw ? formatNumber(raw) : '';
                        // try to restore cursor near end (simple heuristic)
                        try { disp.setSelectionRange(disp.value.length, disp.value.length); } catch(err) {}
                    });

                    // also on blur reformat
                    disp.addEventListener('blur', function() {
                        disp.value = hidden.value ? formatNumber(hidden.value) : '';
                    });
                }
            });
            </script>
            @php
                $existingItinerary = $tourPackage->itinerary ?? [];
                if (!is_array($existingItinerary)) {
                    $existingItinerary = [];
                }

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

            <div id="itinerary-container" class="space-y-4">
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
                            $titleId = $item['day']['id'] ?? '';
                            $titleEn = $item['day']['en'] ?? '';
                            $titleZh = $item['day']['zh'] ?? '';
                            
                            // Gabungkan semua activities menjadi description
                            if (isset($item['activities']) && is_array($item['activities'])) {
                                $activitiesId = [];
                                $activitiesEn = [];
                                $activitiesZh = [];
                                
                                foreach ($item['activities'] as $activity) {
                                    if (isset($activity['description_id'])) {
                                        $time = $activity['time'] ?? '';
                                        $activitiesId[] = ($time ? "[$time] " : '') . $activity['description_id'];
                                        $activitiesEn[] = ($time ? "[$time] " : '') . ($activity['description_en'] ?? '');
                                        $activitiesZh[] = ($time ? "[$time] " : '') . ($activity['description_zh'] ?? '');
                                    }
                                }
                                
                                $descId = implode("\n\n", $activitiesId);
                                $descEn = implode("\n\n", $activitiesEn);
                                $descZh = implode("\n\n", $activitiesZh);
                                
                                // Tambahkan note jika ada
                                if (isset($item['note']['id'])) {
                                    $descId .= "\n\nCatatan: " . $item['note']['id'];
                                    $descEn .= "\n\nNote: " . ($item['note']['en'] ?? '');
                                    $descZh .= "\n\n注意: " . ($item['note']['zh'] ?? '');
                                }
                            }
                        }
                    @endphp
                    <div class="itinerary-item border-2 border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 text-white text-sm font-bold mr-3">{{ $index + 1 }}</span>
                                Day {{ $index + 1 }}
                            </h3>
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
                                       placeholder="Contoh: Hari Pertama - Tiba di Bali">
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
                                       placeholder="Example: First Day - Arrival in Bali">
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
                                       placeholder="例如：第一天 - 抵达巴厘岛">
                            </div>

                            <!-- Description ID -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi (ID) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="itinerary[{{ $index }}][description_id]" 
                                          rows="5" 
                                          required 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                          placeholder="Jelaskan aktivitas di hari ini...">{{ $descId }}</textarea>
                            </div>

                            <!-- Description EN -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Description (EN) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="itinerary[{{ $index }}][description_en]" 
                                          rows="5" 
                                          required 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                          placeholder="Describe today's activities...">{{ $descEn }}</textarea>
                            </div>

                            <!-- Description ZH -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    描述 (ZH) <span class="text-red-500">*</span>
                                </label>
                                <textarea name="itinerary[{{ $index }}][description_zh]" 
                                          rows="5" 
                                          required 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                                          placeholder="描述今天的活动...">{{ $descZh }}</textarea>
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

            <!-- Image Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Gambar Package
                </h2>

                <div class="space-y-4">
                    @if($tourPackage->image)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Gambar Saat Ini</label>
                            <div class="relative inline-block group">
                                <div class="max-h-80 rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
                                    @include('components.responsive-image', [
                                        'path' => $tourPackage->image, 
                                        'alt' => $tourPackage->name_en ?? 'Package Image', 
                                        'class' => 'w-full h-full object-cover', 
                                        'derivatives' => $tourPackage->image_derivatives ?? null
                                    ])
                                </div>
                                <span class="absolute top-3 left-3 px-3 py-1.5 bg-emerald-500 text-white text-xs font-semibold rounded-full shadow-lg flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Current Image
                                </span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ $tourPackage->image ? 'Upload Gambar Baru (Opsional)' : 'Upload Gambar Package' }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 transition-colors bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                        <span>Upload a file</span>
                                        <input id="image" 
                                               name="image" 
                                               type="file" 
                                               class="sr-only" 
                                               accept="image/*"
                                               onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        @if($tourPackage->image)
                            <p class="mt-2 text-sm text-amber-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Upload gambar baru akan menggantikan gambar yang ada
                            </p>
                        @endif
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Preview Gambar Baru</label>
                        <div class="relative inline-block">
                            <div class="max-h-80 rounded-xl shadow-lg border-2 border-emerald-300 overflow-hidden">
                                <img id="preview-img" class="w-full h-full object-cover" alt="Preview">
                            </div>
                            <span class="absolute top-3 left-3 px-3 py-1.5 bg-blue-500 text-white text-xs font-semibold rounded-full shadow-lg flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Preview
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tours Selection (if applicable) -->
            @if(\App\Models\Tour::count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Tours Terkait
                </h2>

                <div>
                    <label for="tours" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Tours (Multiple Select)
                    </label>
                    <select name="tours[]" 
                            id="tours" 
                            multiple 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            size="5">
                        @foreach(\App\Models\Tour::all() as $tour)
                            <option value="{{ $tour->id }}" 
                                    {{ in_array($tour->id, old('tours', $tourPackage->tours->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}
                                    class="py-2">
                                {{ $tour->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-sm text-gray-500">Tekan Ctrl (Cmd di Mac) untuk memilih beberapa tours</p>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" 
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Package
                </button>
                <a href="{{ route('admin.tour-packages.index') }}" 
                   class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>


@endsection