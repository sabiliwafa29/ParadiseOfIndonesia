@php
    $isEdit = isset($tourPackage) && $tourPackage;
@endphp

<form action="{{ $isEdit ? route('admin.tour-packages.update', $tourPackage) : route('admin.tour-packages.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

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
                           value="{{ old('name_id', $tourPackage->name_id ?? '') }}" 
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
                           value="{{ old('name_en', $tourPackage->name_en ?? '') }}" 
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
                           value="{{ old('name_zh', $tourPackage->name_zh ?? '') }}" 
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
                          placeholder="Deskripsi lengkap dalam Bahasa Indonesia">{{ old('description_id', $tourPackage->description_id ?? '') }}</textarea>
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
                          placeholder="Full description in English">{{ old('description_en', $tourPackage->description_en ?? '') }}</textarea>
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
                          placeholder="完整的中文描述">{{ old('description_zh', $tourPackage->description_zh ?? '') }}</textarea>
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
            <!-- Price IDR -->
            <div>
                <label for="price_idr" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga (IDR) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-500 font-semibold">Rp</span>
                    <input type="number" 
                           name="price_idr" 
                           id="price_idr" 
                           value="{{ old('price_idr', $tourPackage->price_idr ?? '') }}" 
                           required 
                           min="0" 
                           step="0.01" 
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_idr') border-red-500 @enderror" 
                           placeholder="0">
                </div>
                @error('price_idr')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price USD -->
            <div>
                <label for="price_usd" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga (USD) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-500 font-semibold">$</span>
                    <input type="number" 
                           name="price_usd" 
                           id="price_usd" 
                           value="{{ old('price_usd', $tourPackage->price_usd ?? '') }}" 
                           required 
                           min="0" 
                           step="0.01" 
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_usd') border-red-500 @enderror" 
                           placeholder="0">
                </div>
                @error('price_usd')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price CNY -->
             <div>
                <label for="price_cny" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga (CNY) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-500 font-semibold">¥</span>
                    <input type="number" 
                           name="price_cny" 
                           id="price_cny" 
                           value="{{ old('price_cny', $tourPackage->price_cny ?? '') }}" 
                           required 
                           min="0" 
                           step="0.01" 
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_cny') border-red-500 @enderror" 
                           placeholder="0">
                </div>
                @error('price_cny')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Price Special (IDR) -->
            <div>
                <label for="price_special_idr" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Spesial (IDR)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-red-500 font-semibold">Rp*</span>
                    <input type="number"
                            name="price_special_idr"
                            id="price_special_idr"
                            value="{{ old('price_special_idr', $tourPackage->price_special_idr ?? '') }}"
                            min="0"
                            step="0.01"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_special_idr') border-red-500 @enderror"
                            placeholder="Harga spesial IDR (opsional)">
                </div>
                @error('price_special_idr')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Special (USD) -->
            <div>
                <label for="price_special_usd" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Spesial (USD)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-red-500 font-semibold">$*</span>
                    <input type="number"
                            name="price_special_usd"
                            id="price_special_usd"
                            value="{{ old('price_special_usd', $tourPackage->price_special_usd ?? '') }}"
                            min="0"
                            step="0.01"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_special_usd') border-red-500 @enderror"
                            placeholder="Harga spesial USD (opsional)">
                </div>
                @error('price_special_usd')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Special (CNY) -->
            <div>
                <label for="price_special_cny" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Spesial (CNY)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-red-500 font-semibold">¥*</span>
                    <input type="number"
                            name="price_special_cny"
                            id="price_special_cny"
                            value="{{ old('price_special_cny', $tourPackage->price_special_cny ?? '') }}"
                            min="0"
                            step="0.01"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_special_cny') border-red-500 @enderror"
                            placeholder="Harga spesial CNY (opsional)">
                </div>
                @error('price_special_cny')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            

            <!-- Minimal Guests -->
            <div>
                <label for="min_guests" class="block text-sm font-semibold text-gray-700 mb-2">
                    Minimal Guest <span class="text-red-500">*</span>
                </label>
                <input type="number"
                       name="min_guests"
                       id="min_guests"
                       value="{{ old('min_guests', $tourPackage->min_guests ?? 1) }}"
                       min="1"
                       required
                       class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('min_guests') border-red-500 @enderror">
                @error('min_guests')
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
                               {{ old('includes_guide', $tourPackage->includes_guide ?? true) ? 'checked' : '' }} 
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
                               {{ old('includes_transport', $tourPackage->includes_transport ?? true) ? 'checked' : '' }} 
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

    <!-- Itinerary Card -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Itinerary (Jadwal Perjalanan)
        </h2>

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

    <!-- Image Section -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Gambar Package
        </h2>

        <div class="space-y-4">
            @if($isEdit && $tourPackage->image)
                <div class="relative inline-block">
                    @if(isset($tourPackage->image_derivatives))
                        @include('components.responsive-image', [
                            'path' => $tourPackage->image, 
                            'alt' => 'Current Package Image', 
                            'class' => 'max-h-64 rounded-lg shadow-md border-2 border-gray-200', 
                            'derivatives' => $tourPackage->image_derivatives
                        ])
                    @else
                        <img src="{{ Storage::url($tourPackage->image) }}" 
                             alt="Current Package Image" 
                             class="max-h-64 rounded-lg shadow-md border-2 border-gray-200">
                    @endif
                    <span class="absolute top-2 left-2 px-3 py-1 bg-emerald-500 text-white text-xs font-semibold rounded-full">Current Image</span>
                </div>
            @endif

            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ $isEdit ? 'Upload Gambar Baru (Opsional)' : 'Upload Gambar' }}
                </label>
                <input type="file" 
                       name="image" 
                       id="image" 
                       accept="image/*"
                       class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 hover:border-emerald-400 transition-colors cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="mt-2 text-sm text-gray-500">Format: JPG, PNG, GIF (Max: 2MB)</p>
            </div>
        </div>
    </div>

    <!-- Tours Selection -->
    @if(isset($tours) && $tours->count() > 0)
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Tours Terkait
        </h2>

        <div>
            <label for="tours" class="block text-sm font-semibold text-gray-700 mb-2">
                Pilih Tours <span class="text-gray-500 font-normal">(Multiple Select - Opsional)</span>
            </label>
            <select name="tours[]" 
                    id="tours" 
                    multiple 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tours') border-red-500 @enderror"
                    size="5">
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" 
                            @if(collect(old('tours', $tourPackage->tours->pluck('id') ?? []))->contains($tour->id)) selected @endif
                            class="py-2">
                        {{ $tour->name_id ?? $tour->name }} / {{ $tour->name_en ?? '' }}
                    </option>
                @endforeach
            </select>
            <p class="mt-2 text-sm text-gray-500">Tekan Ctrl (Cmd di Mac) untuk memilih beberapa tours</p>
            @error('tours')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 pt-4">
        <button type="submit" 
                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($isEdit)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                @endif
            </svg>
            {{ $isEdit ? 'Update Package' : 'Buat Package' }}
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