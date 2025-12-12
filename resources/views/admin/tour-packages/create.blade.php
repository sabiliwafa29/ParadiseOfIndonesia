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
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Tambah Tour Package</h1>
            <p class="text-gray-600">Buat paket wisata baru untuk pelanggan Anda</p>
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
                    <!-- Form -->
                    @include('admin.tour-packages._form', ['tours' => \App\Models\Tour::all()])
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
                        Pilih Tours <span class="text-gray-500 font-normal">(Multiple Select - Opsional)</span>
                    </label>
                    <select name="tours[]" 
                            id="tours" 
                            multiple 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tours') border-red-500 @enderror"
                            size="5">
                        @foreach(\App\Models\Tour::all() as $tour)
                            <option value="{{ $tour->id }}" 
                                    {{ in_array($tour->id, old('tours', [])) ? 'selected' : '' }}
                                    class="py-2">
                                {{ $tour->name ?? $tour->title ?? 'Tour #' . $tour->id }}
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Package
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
    let itineraryCount = 1;
    const container = document.getElementById('itinerary-container');
    const addButton = document.getElementById('add-itinerary');

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
            item.remove();
            updateDayNumbers();
            updateRemoveButtons();
        }
    });

    // Update day numbers after removal
    function updateDayNumbers() {
        const items = container.querySelectorAll('.itinerary-item');
        items.forEach((item, index) => {
            const dayNumber = index + 1;
            const badge = item.querySelector('span.inline-flex');
            const heading = item.querySelector('h3');
            badge.textContent = dayNumber;
            heading.childNodes[1].textContent = ` Day ${dayNumber}`;
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
@endsection