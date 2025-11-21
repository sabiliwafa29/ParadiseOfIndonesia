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
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="font-bold text-red-800 mb-2">Terdapat beberapa kesalahan:</p>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.tour-packages.update', $tourPackage) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @method('PUT')

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

            <!-- Descriptions Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    Deskripsi Package
                </h2>

                <div class="space-y-4">
                    <!-- Indonesian Description -->
                    <div>
                        <label for="description_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi (ID) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description_id" 
                                  id="description_id" 
                                  rows="4" 
                                  required 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description_id') border-red-500 @enderror" 
                                  placeholder="Deskripsi lengkap dalam Bahasa Indonesia">{{ old('description_id', $tourPackage->description_id) }}</textarea>
                        @error('description_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- English Description -->
                    <div>
                        <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (EN) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description_en" 
                                  id="description_en" 
                                  rows="4" 
                                  required 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description_en') border-red-500 @enderror" 
                                  placeholder="Full description in English">{{ old('description_en', $tourPackage->description_en) }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chinese Description -->
                    <div>
                        <label for="description_zh" class="block text-sm font-semibold text-gray-700 mb-2">
                            描述 (ZH) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description_zh" 
                                  id="description_zh" 
                                  rows="4" 
                                  required 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description_zh') border-red-500 @enderror" 
                                  placeholder="完整的中文描述">{{ old('description_zh', $tourPackage->description_zh) }}</textarea>
                        @error('description_zh')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Price & Features Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Harga & Fasilitas
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga (IDR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-semibold">Rp</span>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   value="{{ old('price', $tourPackage->price) }}" 
                                   required 
                                   min="0" 
                                   step="0.01" 
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price') border-red-500 @enderror" 
                                   placeholder="0">
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Features -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Fasilitas Termasuk</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                                <input type="checkbox" 
                                       name="includes_guide" 
                                       value="1" 
                                       {{ old('includes_guide', $tourPackage->includes_guide) ? 'checked' : '' }} 
                                       class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                <span class="ml-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700">Includes Guide</span>
                                </span>
                            </label>

                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                                <input type="checkbox" 
                                       name="includes_transport" 
                                       value="1" 
                                       {{ old('includes_transport', $tourPackage->includes_transport) ? 'checked' : '' }} 
                                       class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                <span class="ml-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700">Includes Transport</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itinerary Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Itinerary (Jadwal Perjalanan)
                </h2>

                <!-- DEBUG INFO -->
                <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                    <p class="font-bold text-yellow-800 mb-2">🐛 DEBUG INFORMATION:</p>
                    <div class="text-sm text-yellow-700 space-y-1 font-mono">
                        @php
                            $rawItinerary = $tourPackage->getRawOriginal('itinerary');
                            $castedItinerary = $tourPackage->itinerary;
                            $oldItinerary = old('itinerary');
                        @endphp
                        <p><strong>Raw DB Value:</strong> {{ $rawItinerary ? substr(json_encode($rawItinerary), 0, 200) : 'NULL' }}...</p>
                        <p><strong>Casted Value:</strong> {{ $castedItinerary ? substr(json_encode($castedItinerary), 0, 200) : 'NULL' }}...</p>
                        <p><strong>Old Input:</strong> {{ $oldItinerary ? 'EXISTS' : 'NULL' }}</p>
                        <p><strong>Is Array:</strong> {{ is_array($castedItinerary) ? 'YES' : 'NO' }}</p>
                        <p><strong>Array Count:</strong> {{ is_array($castedItinerary) ? count($castedItinerary) : '0' }}</p>
                        <p><strong>JSON Decode Test:</strong> 
                            @php
                                if (is_string($rawItinerary)) {
                                    $decoded = json_decode($rawItinerary, true);
                                    echo json_last_error() === JSON_ERROR_NONE ? 'SUCCESS' : 'FAILED: ' . json_last_error_msg();
                                } else {
                                    echo 'NOT STRING';
                                }
                            @endphp
                        </p>
                    </div>
                </div>

                <div id="itinerary-container" class="space-y-6">
                    @php
                        // Ambil data itinerary dari old() atau database
                        $existingItinerary = old('itinerary');
                        
                        // Jika tidak ada old data, ambil dari database
                        if (!$existingItinerary) {
                            $existingItinerary = $tourPackage->itinerary;
                        }
                        
                        // Debug: Log nilai
                        \Log::info('=== ITINERARY DEBUG ===');
                        \Log::info('Raw from DB: ' . json_encode($tourPackage->getRawOriginal('itinerary')));
                        \Log::info('After casting: ' . json_encode($tourPackage->itinerary));
                        \Log::info('Type: ' . gettype($existingItinerary));
                        \Log::info('Is Array: ' . (is_array($existingItinerary) ? 'YES' : 'NO'));
                        
                        // Pastikan dalam bentuk array
                        if (!is_array($existingItinerary)) {
                            \Log::warning('Converting to array because type is: ' . gettype($existingItinerary));
                            $existingItinerary = [];
                        }
                        
                        // Jika kosong, buat minimal 1 item
                        if (empty($existingItinerary)) {
                            \Log::info('Empty itinerary, creating default item');
                            $existingItinerary = [[
                                'title_id' => '',
                                'title_en' => '',
                                'title_zh' => '',
                                'description_id' => '',
                                'description_en' => '',
                                'description_zh' => ''
                            ]];
                        }
                        
                        \Log::info('Final itinerary count: ' . count($existingItinerary));
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === DEBUG CONSOLE ===
    console.log('🐛 === ITINERARY DEBUG START ===');
    console.log('Initial itinerary count from PHP:', {{ count($existingItinerary) }});
    console.log('Itinerary data:', @json($existingItinerary));
    console.log('Tour Package ID:', {{ $tourPackage->id }});
    console.log('Raw itinerary from model:', @json($tourPackage->itinerary));
    
    // Check DOM elements
    const container = document.getElementById('itinerary-container');
    const items = container.querySelectorAll('.itinerary-item');
    console.log('DOM: Found', items.length, 'itinerary items in container');
    
    items.forEach((item, index) => {
        const inputs = item.querySelectorAll('input[type="text"], textarea');
        console.log(`DOM: Day ${index + 1} has ${inputs.length} input fields`);
        
        // Log each field value
        inputs.forEach(input => {
            console.log(`  - ${input.name}: "${input.value}"`);
        });
    });
    console.log('🐛 === ITINERARY DEBUG END ===');
    // === END DEBUG ===

    let itineraryCount = {{ count($existingItinerary) }};
    const addButton = document.getElementById('add-itinerary');

    console.log('Itinerary manager initialized with count:', itineraryCount);

    // Add new itinerary item
    addButton.addEventListener('click', function() {
        console.log('➕ Adding new itinerary item, current count:', itineraryCount);
        
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
        console.log('✅ Item added, new count:', itineraryCount);
        updateRemoveButtons();
    });

    // Remove itinerary item
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-itinerary')) {
            console.log('🗑️ Removing itinerary item');
            const item = e.target.closest('.itinerary-item');
            const itemIndex = Array.from(container.querySelectorAll('.itinerary-item')).indexOf(item);
            console.log('Item index to remove:', itemIndex);
            
            item.remove();
            updateDayNumbers();
            updateRemoveButtons();
            
            console.log('✅ Item removed, remaining count:', container.querySelectorAll('.itinerary-item').length);
        }
    });

    // Update day numbers AND field names after removal
    function updateDayNumbers() {
        console.log('🔄 Updating day numbers and field names...');
        const items = container.querySelectorAll('.itinerary-item');
        
        items.forEach((item, index) => {
            const dayNumber = index + 1;
            const badge = item.querySelector('span.inline-flex');
            const heading = item.querySelector('h3');
            badge.textContent = dayNumber;
            heading.childNodes[1].textContent = ` Day ${dayNumber}`;
            
            console.log(`  - Day ${dayNumber}: Updating field names`);
            
            // PENTING: Update nama field agar index berurutan
            const inputs = item.querySelectorAll('input[type="text"], textarea');
            inputs.forEach(input => {
                const oldName = input.getAttribute('name');
                if (oldName) {
                    // Ganti index lama dengan index baru
                    const newName = oldName.replace(/\[(\d+)\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                    
                    if (oldName !== newName) {
                        console.log(`    ${oldName} → ${newName}`);
                    }
                }
            });
        });
        itineraryCount = items.length;
        console.log('✅ Update complete, total items:', itineraryCount);
    }

    // Show/hide remove buttons (hide if only one item)
    function updateRemoveButtons() {
        const items = container.querySelectorAll('.itinerary-item');
        const removeButtons = container.querySelectorAll('.remove-itinerary');
        
        console.log('🔘 Updating remove buttons visibility, items count:', items.length);
        
        if (items.length <= 1) {
            removeButtons.forEach(btn => btn.classList.add('hidden'));
            console.log('  - Hiding remove buttons (only 1 item)');
        } else {
            removeButtons.forEach(btn => btn.classList.remove('hidden'));
            console.log('  - Showing remove buttons');
        }
    }
    
    // Initialize remove button visibility
    console.log('🎬 Initializing remove buttons...');
    updateRemoveButtons();
    console.log('✅ Initialization complete!');
});

// Image preview function
function previewImage(event) {
    console.log('🖼️ Image selected for preview');
    const input = event.target;
    if (input.files && input.files[0]) {
        console.log('  - File:', input.files[0].name, '(' + (input.files[0].size / 1024).toFixed(2) + ' KB)');
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
            console.log('✅ Image preview loaded');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection