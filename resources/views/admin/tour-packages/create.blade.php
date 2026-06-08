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
                    </div>
                </div>
            </div>
        </div>
        @endif

        @include('admin.tour-packages._form', ['tours' => \App\Models\Tour::all()])
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