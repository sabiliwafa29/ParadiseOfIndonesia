@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.destinations.index') }}" 
                       class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white hover:bg-gray-50 text-gray-600 shadow-sm transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Create New Destination</h1>
                        <p class="text-gray-600 mt-1">Add a new travel destination to your platform</p>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded-r-lg shadow">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Information Section --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Basic Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name ID --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Name (Indonesian) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name_id" 
                                   value="{{ old('name_id') }}" 
                                   class="w-full px-4 py-3 border @error('name_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                   placeholder="Masukkan nama dalam Bahasa Indonesia"
                                   required>
                            @error('name_id')
                                <p class="text-sm text-red-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Name EN --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Name (English) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name_en" 
                                   value="{{ old('name_en') }}" 
                                   class="w-full px-4 py-3 border @error('name_en') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                   placeholder="Enter English name"
                                   required>
                            @error('name_en')
                                <p class="text-sm text-red-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Name ZH --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Name (Chinese) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name_zh" 
                                   value="{{ old('name_zh') }}" 
                                   class="w-full px-4 py-3 border @error('name_zh') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                   placeholder="输入中文名称"
                                   required>
                            @error('name_zh')
                                <p class="text-sm text-red-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                URL Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="slug" 
                                   value="{{ old('slug') }}" 
                                   class="w-full px-4 py-3 border @error('slug') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition font-mono text-sm"
                                   placeholder="destination-url-slug"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">Use lowercase letters, numbers, and hyphens only</p>
                            @error('slug')
                                <p class="text-sm text-red-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="location" 
                                       value="{{ old('location') }}" 
                                       class="w-full pl-10 pr-4 py-3 border @error('location') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                       placeholder="e.g., Bali, Indonesia"
                                       required>
                            </div>
                            @error('location')
                                <p class="text-sm text-red-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Featured --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Settings</label>
                            <div class="flex items-center h-12">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="featured" 
                                           value="1" 
                                           {{ old('featured') ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Featured Destination
                                    </span>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Featured destinations will be highlighted on the homepage</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Descriptions Section --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Descriptions
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    {{-- Description ID --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (Indonesian)
                        </label>
                        <textarea name="description_id" 
                                  rows="4"
                                  class="w-full px-4 py-3 border @error('description_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none"
                                  placeholder="Deskripsi destinasi dalam Bahasa Indonesia...">{{ old('description_id') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Provide a detailed description of the destination in Indonesian</p>
                        @error('description_id')
                            <p class="text-sm text-red-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description EN --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (English)
                        </label>
                        <textarea name="description_en" 
                                  rows="4"
                                  class="w-full px-4 py-3 border @error('description_en') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none"
                                  placeholder="Destination description in English...">{{ old('description_en') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Provide a detailed description of the destination in English</p>
                        @error('description_en')
                            <p class="text-sm text-red-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description ZH --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (Chinese)
                        </label>
                        <textarea name="description_zh" 
                                  rows="4"
                                  class="w-full px-4 py-3 border @error('description_zh') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none"
                                  placeholder="中文目的地描述...">{{ old('description_zh') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Provide a detailed description of the destination in Chinese</p>
                        @error('description_zh')
                            <p class="text-sm text-red-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Image Section --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Destination Image
                    </h2>
                </div>
                <div class="p-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Image
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                        <span>Upload a file</span>
                                        <input id="image-upload" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        <div id="image-preview" class="mt-4 hidden">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Image Preview:</p>
                            <img id="preview-img" class="h-64 w-auto rounded-lg shadow-md" alt="Preview">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between bg-white rounded-xl shadow-lg p-6">
                <a href="{{ route('admin.destinations.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Destination
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
