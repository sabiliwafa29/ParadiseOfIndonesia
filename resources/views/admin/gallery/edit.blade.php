@extends('layouts.admin')

@section('page-title', 'Edit Gallery Image')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Gallery Image</h1>
                <p class="text-gray-600">Change title or replace the image.</p>
            </div>
            <div>
                <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50">Back to gallery</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white rounded-xl shadow-lg overflow-hidden">
                    @csrf
                    @method('PUT')

                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Image Details</h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required class="mt-1 block w-full border-gray-300 rounded-md">
                                @error('title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                <div class="mt-2">
                                    @if($gallery->image)
                                        @include('components.responsive-image', ['path' => $gallery->image, 'alt' => $gallery->title ?? '', 'class' => 'w-48 h-32 object-cover rounded'])
                                    @endif
                                </div>
                                <input type="file" name="image" class="mt-2">
                                @error('image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-6 flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-md">Save</button>
                        <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-3 bg-gray-100 rounded-md text-gray-700">Cancel</a>
                    </div>
                </form>
            </div>

            <aside class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-4 bg-emerald-600 text-white">
                        <h4 class="font-semibold">Quick Info</h4>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Created</span><span class="text-sm font-medium text-gray-800">{{ $gallery->created_at ? $gallery->created_at->format('M d, Y') : '-' }}</span></div>
                        <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Updated</span><span class="text-sm font-medium text-gray-800">{{ $gallery->updated_at ? $gallery->updated_at->format('M d, Y') : '-' }}</span></div>
                        <div class="pt-2">
                            <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Delete this gallery image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-md">Delete Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
