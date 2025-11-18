@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create Tour Package</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded">
            <ul class="text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tour-packages.store') }}" method="POST" enctype="multipart/form-data">
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

            <div class="md:col-span-2">
                <label class="block mb-1">Description (ID)</label>
                <textarea name="description_id" @class(['w-full p-2', 'border border-red-500' => $errors->has('description_id'), 'border border-gray-300' => !$errors->has('description_id')]) rows="3">{{ old('description_id') }}</textarea>
                @error('description_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1">Description (EN)</label>
                <textarea name="description_en" @class(['w-full p-2', 'border border-red-500' => $errors->has('description_en'), 'border border-gray-300' => !$errors->has('description_en')]) rows="3">{{ old('description_en') }}</textarea>
                @error('description_en')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1">Description (ZH)</label>
                <textarea name="description_zh" @class(['w-full p-2', 'border border-red-500' => $errors->has('description_zh'), 'border border-gray-300' => !$errors->has('description_zh')]) rows="3">{{ old('description_zh') }}</textarea>
                @error('description_zh')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block mb-1">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('price'), 'border border-gray-300' => !$errors->has('price')]) required>
                @error('price')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block mb-1">Includes Guide</label>
                <input type="checkbox" name="includes_guide" value="1" {{ old('includes_guide') ? 'checked' : '' }}>
                @error('includes_guide')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block mb-1">Includes Transport</label>
                <input type="checkbox" name="includes_transport" value="1" {{ old('includes_transport') ? 'checked' : '' }}>
                @error('includes_transport')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Tours (select multiple)</label>
                <select name="tours[]" multiple @class(['w-full p-2', 'border border-red-500' => $errors->has('tours'), 'border border-gray-300' => !$errors->has('tours')])>
                    @foreach(App\Models\Tour::all() as $t)
                        <option value="{{ $t->id }}" {{ in_array($t->id, old('tours', [])) ? 'selected' : '' }}>{{ $t->name ?? $t->title ?? 'Tour #' . $t->id }}</option>
                    @endforeach
                </select>
                @error('tours')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Image</label>
                <input type="file" name="image" class="w-full">
            </div>
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-emerald-500 text-white rounded">Create Package</button>
            <a href="{{ route('admin.tour-packages.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-emerald-50 p-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Tour Package</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tour-packages.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
        @csrf

        <div class="mb-4">
            <label for="name_id" class="block font-semibold mb-1">Nama (ID)</label>
            <input type="text" name="name_id" id="name_id" value="{{ old('name_id') }}" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="name_en" class="block font-semibold mb-1">Nama (EN)</label>
            <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="name_zh" class="block font-semibold mb-1">Nama (ZH)</label>
            <input type="text" name="name_zh" id="name_zh" value="{{ old('name_zh') }}" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="description_id" class="block font-semibold mb-1">Deskripsi (ID)</label>
            <textarea name="description_id" id="description_id" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description_id') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="description_en" class="block font-semibold mb-1">Deskripsi (EN)</label>
            <textarea name="description_en" id="description_en" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description_en') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="description_zh" class="block font-semibold mb-1">Deskripsi (ZH)</label>
            <textarea name="description_zh" id="description_zh" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description_zh') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block font-semibold mb-1">Harga</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Gambar</label>
            <input type="file" name="image" id="image" class="w-full" />
        </div>

        <div class="mb-4 flex items-center space-x-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="includes_guide" value="1" {{ old('includes_guide', true) ? 'checked' : '' }} class="form-checkbox" />
                <span class="ml-2">Includes Guide</span>
            </label>

            <label class="inline-flex items-center">
                <input type="checkbox" name="includes_transport" value="1" {{ old('includes_transport', true) ? 'checked' : '' }} class="form-checkbox" />
                <span class="ml-2">Includes Transport</span>
            </label>
        </div>

        <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded hover:bg-emerald-700 transition">Simpan</button>
        <a href="{{ route('admin.tour-packages.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
