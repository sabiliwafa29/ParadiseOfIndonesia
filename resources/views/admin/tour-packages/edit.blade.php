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
                @include('admin.tour-packages._form', ['tours' => \App\Models\Tour::all(), 'tourPackage' => $tourPackage])
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