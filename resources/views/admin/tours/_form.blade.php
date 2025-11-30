@php
    $isEdit = isset($tour) && $tour;
@endphp

<form action="{{ $isEdit ? route('admin.tours.update', $tour) : route('admin.tours.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="space-y-8">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- Basic Information Section --}}
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informasi Dasar
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name ID --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    Nama Tour (Bahasa Indonesia) <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name_id" 
                       value="{{ old('name_id', $tour->name_id ?? '') }}" 
                       class="mt-1 block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name_id') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                       placeholder="Contoh: Paket Wisata Bali 5 Hari"
                       required>
                @error('name_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Name EN --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    Nama Tour (English) <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name_en" 
                       value="{{ old('name_en', $tour->name_en ?? '') }}" 
                       class="mt-1 block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name_en') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                       placeholder="Example: Bali Tour Package 5 Days"
                       required>
                @error('name_en')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Name ZH --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    Nama Tour (中文) <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name_zh" 
                       value="{{ old('name_zh', $tour->name_zh ?? '') }}" 
                       class="mt-1 block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name_zh') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                       placeholder="例如: 巴厘岛5天旅游套餐"
                       required>
                @error('name_zh')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    URL Slug <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="slug" 
                       value="{{ old('slug', $tour->slug ?? '') }}" 
                       class="mt-1 block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('slug') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                       placeholder="bali-tour-package-5-days"
                       required>
                <p class="mt-1 text-xs text-gray-500">URL-friendly version (lowercase, hyphens)</p>
                @error('slug')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Pricing & Details Section --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Harga & Detail
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Price --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Harga (USD) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-600 font-semibold">$</span>
                          <input type="number" 
                              step="0.01" 
                              name="price" 
                              value="{{ old('price', $tour->price_usd ?? $tour->price ?? '') }}" 
                           class="block w-full pl-8 pr-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                           placeholder="299.00"
                           required>
                </div>
                @error('price')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Duration --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Durasi (hari) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number" 
                           name="duration" 
                           value="{{ old('duration', $tour->duration ?? '') }}" 
                           class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('duration') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                           placeholder="5"
                           min="1"
                           required>
                    <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 text-sm">hari</span>
                </div>
                @error('duration')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Minimal Guests --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4-10 4 10M12 3v4"/>
                    </svg>
                    Minimal Guest <span class="text-red-500">*</span>
                </label>
                <input type="number"
                       name="min_guests"
                       value="{{ old('min_guests', $tour->min_guests ?? 1) }}"
                       class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('min_guests') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                       min="1"
                       required>
                @error('min_guests')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Destination --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Destinasi <span class="text-red-500">*</span>
                </label>
                <select name="destination_id" 
                        class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('destination_id') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                        required>
                    <option value="">-- Pilih Destinasi --</option>
                    @foreach($destinations as $dest)
                        <option value="{{ $dest->id }}" @if(old('destination_id', $tour->destination_id ?? '') == $dest->id) selected @endif>
                            {{ $dest->name_id }} / {{ $dest->name_en }}
                        </option>
                    @endforeach
                </select>
                @error('destination_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Descriptions Section --}}
    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            Deskripsi
        </h3>

        <div class="space-y-6">
            {{-- Description ID --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Tour (Bahasa Indonesia) <span class="text-red-500">*</span>
                </label>
                <textarea name="description_id" 
                          rows="4" 
                          class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('description_id') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
                          placeholder="Jelaskan detail paket wisata dalam Bahasa Indonesia..."
                          required>{{ old('description_id', $tour->description_id ?? '') }}</textarea>
                @error('description_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description EN --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Tour (English) <span class="text-red-500">*</span>
                </label>
                <textarea name="description_en" 
                          rows="4" 
                          class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('description_en') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
                          placeholder="Describe the tour package in English..."
                          required>{{ old('description_en', $tour->description_en ?? '') }}</textarea>
                @error('description_en')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description ZH --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Tour (中文) <span class="text-red-500">*</span>
                </label>
                <textarea name="description_zh" 
                          rows="4" 
                          class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('description_zh') border-red-500 bg-red-50 @else border-gray-300 @enderror" 
                          placeholder="用中文描述旅游套餐..."
                          required>{{ old('description_zh', $tour->description_zh ?? '') }}</textarea>
                @error('description_zh')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Itinerary & Includes Section --}}
    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Itinerary & Detail Tour
        </h3>

        <div class="space-y-6">
            {{-- Itinerary --}}
            <div class="form-group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Itinerary
                </label>
                <textarea name="itinerary" 
                          rows="6" 
                          class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 font-mono text-sm @error('itinerary') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                          placeholder="Day 1: Arrival and Check-in&#10;Day 2: Beach Tour&#10;Day 3: Temple Visit&#10;Day 4: Adventure Activities&#10;Day 5: Departure">{{ old('itinerary', isset($tour->itinerary) ? (is_array($tour->itinerary) ? implode("\n", $tour->itinerary) : $tour->itinerary) : '') }}</textarea>
                <p class="mt-2 text-xs text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pisahkan setiap hari/aktivitas dengan baris baru
                </p>
                @error('itinerary')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Includes --}}
                <div class="form-group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Yang Termasuk
                    </label>
                    <textarea name="includes" 
                              rows="5" 
                              class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono text-sm @error('includes') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                              placeholder="Hotel Accommodation&#10;Airport Transfer&#10;Breakfast&#10;Tour Guide&#10;Entrance Tickets">{{ old('includes', isset($tour->includes) ? (is_array($tour->includes) ? implode("\n", $tour->includes) : $tour->includes) : '') }}</textarea>
                    <p class="mt-2 text-xs text-gray-600">Satu item per baris</p>
                    @error('includes')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Excludes --}}
                <div class="form-group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Yang Tidak Termasuk
                    </label>
                    <textarea name="excludes" 
                              rows="5" 
                              class="block w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono text-sm @error('excludes') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                              placeholder="Flight Tickets&#10;Personal Expenses&#10;Travel Insurance&#10;Lunch & Dinner&#10;Tips">{{ old('excludes', isset($tour->excludes) ? (is_array($tour->excludes) ? implode("\n", $tour->excludes) : $tour->excludes) : '') }}</textarea>
                    <p class="mt-2 text-xs text-gray-600">Satu item per baris</p>
                    @error('excludes')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Image & Settings Section --}}
    <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Gambar & Pengaturan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Image Upload --}}
            <div class="form-group md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Tour
                </label>
                @if($isEdit && $tour->image)
                    <div class="mb-4 p-4 bg-white rounded-lg border-2 border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                        @include('components.responsive-image', [
                            'path' => $tour->image, 
                            'alt' => 'Gambar Tour', 
                            'class' => 'rounded-lg shadow-md max-h-48 w-auto', 
                            'derivatives' => $tour->image_derivatives ?? null
                        ])
                    </div>
                @endif
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition-all duration-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                        </div>
                        <input type="file" 
                               name="image" 
                               class="hidden" 
                               accept="image/png,image/jpeg,image/jpg"
                               onchange="previewImage(this)">
                    </label>
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <div id="imagePreview" class="mt-4 hidden">
                    <img src="" alt="Preview" class="rounded-lg shadow-md max-h-48">
                </div>
            </div>

            {{-- Featured Checkbox --}}
            <div class="form-group">
                <label class="flex items-center space-x-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" 
                               name="featured" 
                               value="1" 
                               {{ old('featured', $tour->featured ?? false) ? 'checked' : '' }} 
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Tour Unggulan
                        </span>
                        <span class="text-xs text-gray-500">Tampilkan di halaman utama</span>
                    </div>
                </label>
                @error('featured')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between pt-6 border-t-2 border-gray-200">
        <a href="{{ route('admin.tours.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Batal
        </a>
        <button type="submit" 
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $isEdit ? 'Update Tour' : 'Simpan Tour' }}
        </button>
    </div>
</form>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
