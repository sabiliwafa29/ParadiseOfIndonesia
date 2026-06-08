@extends('layouts.admin')

@section('page-title', 'Upload Gallery Image')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb + Header --}}
        <div class="mb-6">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-500 hover:text-purple-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <a href="{{ route('admin.gallery.index') }}" class="text-gray-600 hover:text-purple-600">Gallery</a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-purple-600 font-semibold">Upload</span>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Upload Gallery Image</h1>
                    <p class="text-gray-600 mt-1">Add a new image to your gallery collection</p>
                </div>
                <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-8 py-6 border-b border-purple-100">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Image Details
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Upload and describe your image</p>
                    </div>

                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-8" id="uploadForm">
                        @csrf

                        <!-- Title Field -->
                        <div class="mb-8">
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Image Title
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="title"
                                       name="title" 
                                       value="{{ old('title') }}"
                                       placeholder="Enter a descriptive title for the image"
                                       class="w-full px-4 py-3 pl-12 border-2 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('title') border-red-300 bg-red-50 @else border-gray-300 @enderror"
                                       required>
                                <div class="absolute left-4 top-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('title')
                                <div class="flex items-center mt-2 text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $message }}</span>
                                </div>
                            @else
                                <p class="mt-2 text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Give your image a meaningful title
                                </p>
                            @enderror
                        </div>

                        <!-- Description Field (Optional) -->
                        <div class="mb-8">
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Description
                                <span class="text-gray-400 text-xs ml-2">(Optional)</span>
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Add a description for this image..."
                                      class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition border-gray-300 resize-none">{{ old('description') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Optional description to provide context
                            </p>
                        </div>

                        <!-- Image Upload Field -->
                        <div class="mb-8">
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Image File
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            
                            <!-- Custom File Upload Area -->
                            <div class="relative">
                                <input type="file" 
                                       id="image"
                                       name="image" 
                                       accept="image/*"
                                       class="hidden"
                                       required
                                       onchange="previewImage(event)">
                                
                                <label for="image" 
                                       class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-xl cursor-pointer transition @error('image') border-red-300 bg-red-50 hover:bg-red-100 @else border-gray-300 bg-gray-50 hover:bg-gray-100 @enderror"
                                       id="uploadArea">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="uploadPlaceholder">
                                        <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-full p-4 mb-4">
                                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                        <p class="mb-2 text-sm text-gray-700">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG, GIF, WEBP (MAX. 10MB)</p>
                                    </div>
                                    
                                    <!-- Image Preview (Hidden initially) -->
                                    <div id="imagePreview" class="hidden w-full h-full p-4">
                                        <img id="previewImg" src="" alt="Preview" class="w-full h-full object-contain rounded-lg">
                                    </div>
                                </label>
                                
                                <!-- Selected File Name -->
                                <div id="fileName" class="hidden mt-3 text-sm text-gray-700 flex items-center justify-between bg-purple-50 border border-purple-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span id="fileNameText" class="font-medium"></span>
                                    </div>
                                    <button type="button" 
                                            onclick="clearImage()"
                                            class="text-red-600 hover:text-red-800 font-semibold">
                                        Remove
                                    </button>
                                </div>
                            </div>
                            
                            @error('image')
                                <div class="flex items-center mt-2 text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $message }}</span>
                                </div>
                            @else
                                <p class="mt-2 text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Choose a high-quality image for best results
                                </p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.gallery.index') }}" 
                               class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Upload Image
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Image Upload Tips</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start"><strong class="mr-2">Resolution:</strong> Use high-resolution images (recommended: 1920x1080)</li>
                        <li class="flex items-start"><strong class="mr-2">Format:</strong> JPG for photos, PNG for graphics</li>
                        <li class="flex items-start"><strong class="mr-2">File Size:</strong> Keep under 10MB</li>
                        <li class="flex items-start"><strong class="mr-2">Title:</strong> Use descriptive titles</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('uploadPlaceholder').classList.add('hidden');
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('fileName').classList.remove('hidden');
            document.getElementById('fileNameText').textContent = file.name;
        }
        reader.readAsDataURL(file);
    }
}

function clearImage() {
    document.getElementById('image').value = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('fileName').classList.add('hidden');
    document.getElementById('previewImg').src = '';
}
</script>
@endsection
