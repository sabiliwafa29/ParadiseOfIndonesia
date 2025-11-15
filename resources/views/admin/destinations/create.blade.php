@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create Destination</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded">
            <ul class="text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Name (ID)</label>
                <input type="text" name="name_id" value="{{ old('name_id') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('name_id'), 'border border-gray-300' => !$errors->has('name_id')]) required>
                @error('name_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block mb-1">Name (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('name_en'), 'border border-gray-300' => !$errors->has('name_en')]) required>
                @error('name_en')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block mb-1">Name (ZH)</label>
                <input type="text" name="name_zh" value="{{ old('name_zh') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('name_zh'), 'border border-gray-300' => !$errors->has('name_zh')]) required>
                @error('name_zh')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('slug'), 'border border-gray-300' => !$errors->has('slug')]) required>
                @error('slug')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Description (ID)</label>
                <textarea name="description_id" @class(['w-full p-2', 'border border-red-500' => $errors->has('description_id'), 'border border-gray-300' => !$errors->has('description_id')]) rows="4">{{ old('description_id') }}</textarea>
                @error('description_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1">Description (EN)</label>
                <textarea name="description_en" @class(['w-full p-2', 'border border-red-500' => $errors->has('description_en'), 'border border-gray-300' => !$errors->has('description_en')]) rows="4">{{ old('description_en') }}</textarea>
                @error('description_en')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1">Description (ZH)</label>
                <textarea name="description_zh" @class(['w-full p-2', 'border border-red-500' => $errors->has('description_zh'), 'border border-gray-300' => !$errors->has('description_zh')]) rows="4">{{ old('description_zh') }}</textarea>
                @error('description_zh')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('location'), 'border border-gray-300' => !$errors->has('location')]) required>
                @error('location')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block mb-1">Featured</label>
                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                @error('featured')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Image</label>
                <input type="file" name="image" class="w-full">
            </div>
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-emerald-500 text-white rounded">Create Destination</button>
            <a href="{{ route('admin.destinations.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-emerald-50 p-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Destinasi</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama (ID)</label>
                <input type="text" name="name_id" value="{{ old('name_id') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama (ZH)</label>
                <input type="text" name="name_zh" value="{{ old('name_zh') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" name="image" class="mt-1 block w-full rounded-md border-gray-300">
            </div>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="form-checkbox">
                    <span class="ml-2">Featured</span>
                </label>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Deskripsi (ID)</label>
                <textarea name="description_id" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_id') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Deskripsi (EN)</label>
                <textarea name="description_en" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_en') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Deskripsi (ZH)</label>
                <textarea name="description_zh" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_zh') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.destinations.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
