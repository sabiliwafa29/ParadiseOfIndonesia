@extends('layouts.admin')

@section('page-title', 'Create New Tour')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-500 hover:text-emerald-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('admin.tours.index') }}" class="text-gray-500 hover:text-emerald-600">Tours</a>
                </li>
                <li>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-emerald-600 font-semibold">Create New</span>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">Create New Tour</h1>
                <p class="text-gray-600">Fill in the details below to create a new tour.</p>
            </div>
            <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg p-4 shadow-sm flex items-center">
                <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-emerald-800 font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-red-800 font-medium mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white rounded-xl shadow-lg p-8">
            @csrf

            {{-- Multilingual Names --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="name_id" class="block text-sm font-semibold text-gray-700 mb-2">Nama Tour (ID) *</label>
                    <input type="text" name="name_id" id="name_id" value="{{ old('name_id') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_id') border-red-500 @enderror"
                        placeholder="Nama dalam Bahasa Indonesia">
                    @error('name_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="name_en" class="block text-sm font-semibold text-gray-700 mb-2">Tour Name (EN) *</label>
                    <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_en') border-red-500 @enderror"
                        placeholder="Name in English">
                    @error('name_en')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="name_zh" class="block text-sm font-semibold text-gray-700 mb-2">旅游名称 (ZH) *</label>
                    <input type="text" name="name_zh" id="name_zh" value="{{ old('name_zh') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name_zh') border-red-500 @enderror"
                        placeholder="中文名称">
                    @error('name_zh')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug *</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                    placeholder="e.g., explore-bromo-midnight">
                @error('slug')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                <p class="text-xs text-gray-500 mt-1">URL-friendly version of the tour name</p>
            </div>

            {{-- Multilingual Descriptions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="description_id" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (ID) *</label>
                    <textarea name="description_id" id="description_id" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description_id') border-red-500 @enderror"
                        required>{{ old('description_id') }}</textarea>
                    @error('description_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">Description (EN) *</label>
                    <textarea name="description_en" id="description_en" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description_en') border-red-500 @enderror"
                        required>{{ old('description_en') }}</textarea>
                    @error('description_en')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="description_zh" class="block text-sm font-semibold text-gray-700 mb-2">描述 (ZH) *</label>
                    <textarea name="description_zh" id="description_zh" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description_zh') border-red-500 @enderror"
                        required>{{ old('description_zh') }}</textarea>
                    @error('description_zh')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Price & Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price_usd" class="block text-sm font-semibold text-gray-700 mb-2">Price (USD) *</label>
                    <input type="number" name="price_usd" id="price_usd" value="{{ old('price_usd') }}" required min="0" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price_usd') border-red-500 @enderror"
                        placeholder="0.00">
                    @error('price_usd')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">Duration (Days) *</label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration') }}" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('duration') border-red-500 @enderror"
                        placeholder="1">
                    @error('duration')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="min_guests" class="block text-sm font-semibold text-gray-700 mb-2">Minimal Guest *</label>
                    <input type="number" name="min_guests" id="min_guests" value="{{ old('min_guests', 1) }}" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('min_guests') border-red-500 @enderror"
                        placeholder="1">
                    @error('min_guests')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Destination --}}
            <div>
                <label for="destination_id" class="block text-sm font-semibold text-gray-700 mb-2">Destination *</label>
                <select name="destination_id" id="destination_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('destination_id') border-red-500 @enderror">
                    <option value="">Select a destination...</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                            {{ $destination->name }}
                        </option>
                    @endforeach
                </select>
                @error('destination_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Image Upload --}}
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Tour Image</label>
                <input type="file" name="image" id="image"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('image') border-red-500 @enderror"
                    accept="image/*">
                @error('image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Itinerary --}}
            <div>
                <label for="itinerary" class="block text-sm font-semibold text-gray-700 mb-2">Itinerary (JSON Format)</label>
                <textarea name="itinerary" id="itinerary" rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm @error('itinerary') border-red-500 @enderror"
                    placeholder='[{"day":"DAY 1","activities":[{"time":"18:00","description":"Penjemputan di bandara"}]}]'>{{ old('itinerary') }}</textarea>
                @error('itinerary')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                <button type="button" onclick="formatJSON('itinerary')" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300 transition">
                    Format JSON
                </button>
                <p class="text-xs text-gray-500 mt-2">Format: [{"day":"DAY 1","activities":[{"time":"HH:MM","description":"Activity description"}]}]</p>
            </div>

            {{-- Includes --}}
            <div>
                <label for="includes" class="block text-sm font-semibold text-gray-700 mb-2">What's Included (JSON Array)</label>
                <textarea name="includes" id="includes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm @error('includes') border-red-500 @enderror"
                    placeholder='["Tour Guide","Transportation","Meals"]'>{{ old('includes') }}</textarea>
                @error('includes')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                <button type="button" onclick="formatJSON('includes')" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300 transition">
                    Format JSON
                </button>
                <p class="text-xs text-gray-500 mt-2">Format: ["Item 1","Item 2","Item 3"]</p>
            </div>

            {{-- Excludes --}}
            <div>
                <label for="excludes" class="block text-sm font-semibold text-gray-700 mb-2">What's Not Included (JSON Array)</label>
                <textarea name="excludes" id="excludes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm @error('excludes') border-red-500 @enderror"
                    placeholder='["Airfare","Hotel"]'>{{ old('excludes') }}</textarea>
                @error('excludes')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                <button type="button" onclick="formatJSON('excludes')" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300 transition">
                    Format JSON
                </button>
                <p class="text-xs text-gray-500 mt-2">Format: ["Item 1","Item 2"]</p>
            </div>

            {{-- Featured --}}
            <div class="flex items-center mt-4">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                    class="w-4 h-4 text-emerald-600 rounded focus:ring-2 focus:ring-emerald-500">
                <label for="featured" class="ml-2 text-sm font-semibold text-gray-700">Mark as Featured</label>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-semibold flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Tour
                </button>
                <a href="{{ route('admin.tours.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Cancel
                </a>
            </div>
        </form>

        {{-- Help Card --}}
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Quick Tips</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Fill all required fields marked with *</li>
                        <li>• Use high-quality images for better presentation</li>
                        <li>• Write clear, engaging descriptions</li>
                        <li>• Double-check pricing and duration</li>
                        <li>• Use the "Format JSON" button for itinerary, includes, and excludes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Slug auto-generation
    const nameEnInput = document.getElementById('name_en');
    const slugInput = document.getElementById('slug');
    if (nameEnInput && slugInput) {
        nameEnInput.addEventListener('input', function() {
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
    if (!textarea) return;
    try {
        const value = textarea.value.trim();
        if (!value) return;
        const obj = JSON.parse(value);
        textarea.value = JSON.stringify(obj, null, 2);
        textarea.classList.remove('border-red-500');
        textarea.classList.add('border-green-500');
        setTimeout(() => textarea.classList.remove('border-green-500'), 2000);
    } catch (e) {
        textarea.classList.add('border-red-500');
    }
}
</script>
@endsection
