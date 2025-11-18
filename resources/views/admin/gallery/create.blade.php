@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Upload Gallery Image</h1>

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('title'), 'border border-gray-300' => !$errors->has('title')]) required>
            @error('title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Image</label>
            <input type="file" name="image" @class(['w-full', 'border border-red-500' => $errors->has('image'), 'border border-gray-300' => !$errors->has('image')]) required>
            @error('image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <button class="px-4 py-2 bg-emerald-500 text-white rounded">Upload</button>
    </form>
</div>
@endsection
