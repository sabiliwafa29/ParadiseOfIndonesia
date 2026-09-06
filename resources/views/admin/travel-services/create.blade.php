@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb + Header --}}
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-500 hover:text-emerald-600 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <a href="{{ route('admin.travel-services.index') }}" class="text-gray-500 hover:text-emerald-600 transition">Travel Services</a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-emerald-600 font-semibold">Create Service</span>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create Travel Service</h1>
                    <p class="text-gray-600 mt-1">Add a new travel service, vehicle rental, or add-on to display on the landing page</p>
                </div>
                <a href="{{ route('admin.travel-services.index') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition shadow-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Services
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Form Column --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                    <form action="{{ route('admin.travel-services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Service Name --}}
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-800 mb-2">
                                Service Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g. Airport Transfer, Car Rental, Tour Guide..."
                                   class="w-full px-4 py-3 rounded-xl border-2 transition focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 bg-red-50/50 @else border-gray-200 @enderror"
                                   required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1.5 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Type and Price in 2 Columns --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Service Type / Category --}}
                            <div>
                                <label for="type" class="block text-sm font-bold text-gray-800 mb-2">
                                    Category / Type <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="type" 
                                           name="type" 
                                           list="type-suggestions"
                                           value="{{ old('type', 'Transport') }}" 
                                           placeholder="e.g. Transport, Guide, Event..."
                                           class="w-full px-4 py-3 rounded-xl border-2 transition focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('type') border-red-500 bg-red-50/50 @else border-gray-200 @enderror"
                                           required>
                                    <datalist id="type-suggestions">
                                        @foreach($suggestedTypes ?? ['Transport', 'Accommodation', 'Guide', 'Document', 'Insurance', 'Event', 'Package', 'Custom'] as $typeOption)
                                            <option value="{{ $typeOption }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <p class="text-xs text-gray-500 mt-1.5">Pick from suggestions or type a custom category</p>
                                @error('type')
                                    <p class="text-sm text-red-600 mt-1.5 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Starting Price --}}
                            <div>
                                <label for="price" class="block text-sm font-bold text-gray-800 mb-2">
                                    Starting Price (IDR) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-semibold text-sm">Rp</span>
                                    <input type="number" 
                                           id="price" 
                                           step="1" 
                                           min="0" 
                                           name="price" 
                                           value="{{ old('price') }}" 
                                           placeholder="350000"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 transition focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('price') border-red-500 bg-red-50/50 @else border-gray-200 @enderror"
                                           required>
                                </div>
                                <p class="text-xs text-gray-500 mt-1.5" id="formatted-price-preview">Displayed as "Starting from {{ format_price(0) }}"</p>
                                @error('price')
                                    <p class="text-sm text-red-600 mt-1.5 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-800 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="5"
                                      placeholder="Describe the service details, vehicles/facilities included, terms, and highlights..."
                                      class="w-full px-4 py-3 rounded-xl border-2 transition focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 bg-red-50/50 @else border-gray-200 @enderror"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-1.5 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Image Upload with Live Preview --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">
                                Cover Image
                            </label>
                            <div class="mt-1 flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-2xl transition @error('image') border-red-400 bg-red-50/30 @else border-gray-300 hover:border-emerald-500 bg-gray-50/50 @enderror" id="drop-area">
                                
                                {{-- Preview Container --}}
                                <div id="image-preview-container" class="hidden mb-4 relative w-full max-w-md h-48 rounded-xl overflow-hidden shadow-md border border-gray-200">
                                    <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                                    <button type="button" onclick="removeImagePreview()" class="absolute top-2 right-2 p-1.5 bg-black/60 text-white rounded-full hover:bg-red-600 transition" title="Remove image">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                <div id="upload-placeholder" class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center mt-2">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-semibold text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp,image/svg+xml" class="sr-only" onchange="previewSelectedImage(event)">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, WebP up to 5MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-sm text-red-600 mt-1.5 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Form Buttons --}}
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.travel-services.index') }}" 
                               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/30 transition-all duration-200 transform hover:scale-105">
                                Create Travel Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <aside class="lg:col-span-1 space-y-6">
                {{-- Quick Tips Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Tips for Services</h3>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-3">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>Clear Name:</strong> Use recognizable titles such as "Airport Transfer" or "Innova Rental".</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>Category:</strong> Assign a category so customers can quickly filter services on the landing page.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>Starting Price:</strong> Provide the base minimum rate. Customers will see "Starting from [price]".</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>High Quality Image:</strong> Landscape images (16:9 or 4:3) render best in the landing page cards.</span>
                        </li>
                    </ul>
                </div>

                {{-- Live Preview Card --}}
                <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white rounded-2xl shadow-sm p-6">
                    <p class="text-xs uppercase tracking-widest text-emerald-400 font-bold mb-2">Display Location</p>
                    <h4 class="text-lg font-bold">Landing Page & Services Catalog</h4>
                    <p class="text-sm text-gray-300 mt-2 leading-relaxed">
                        Once created, this service will immediately appear in the <strong>Our Travel Services</strong> section on <a href="{{ route('home') }}#services" target="_blank" class="text-emerald-400 underline">pnbtravel.com</a> and in the dedicated <a href="{{ route('travel-services.index') }}" target="_blank" class="text-emerald-400 underline">/travel-services</a> catalog.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
function previewSelectedImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('image-preview-container').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function removeImagePreview() {
    document.getElementById('image').value = '';
    document.getElementById('image-preview').src = '#';
    document.getElementById('image-preview-container').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
}

// Live price formatter preview
document.getElementById('price').addEventListener('input', function(e) {
    const val = parseFloat(e.target.value);
    const previewEl = document.getElementById('formatted-price-preview');
    if (!isNaN(val) && val >= 0) {
        previewEl.textContent = 'Displayed as: Rp ' + val.toLocaleString('id-ID');
    } else {
        previewEl.textContent = 'Displayed as: Rp 0';
    }
});
</script>
@endsection

