@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Edit Tour Package</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded">
            <ul class="text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tour-packages.update', $tourPackage) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Name (ID)</label>
                <input type="text" name="name_id" value="{{ old('name_id', $tourPackage->name_id) }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block mb-1">Name (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $tourPackage->name_en) }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block mb-1">Name (ZH)</label>
                <input type="text" name="name_zh" value="{{ old('name_zh', $tourPackage->name_zh) }}" class="w-full border p-2" required>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Description (ID)</label>
                <textarea name="description_id" class="w-full border p-2" rows="3">{{ old('description_id', $tourPackage->description_id) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1">Description (EN)</label>
                <textarea name="description_en" class="w-full border p-2" rows="3">{{ old('description_en', $tourPackage->description_en) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1">Description (ZH)</label>
                <textarea name="description_zh" class="w-full border p-2" rows="3">{{ old('description_zh', $tourPackage->description_zh) }}</textarea>
            </div>

            <div>
                <label class="block mb-1">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $tourPackage->price) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label class="block mb-1">Includes Guide</label>
                <input type="checkbox" name="includes_guide" value="1" {{ old('includes_guide', $tourPackage->includes_guide) ? 'checked' : '' }}>
            </div>

            <div>
                <label class="block mb-1">Includes Transport</label>
                <input type="checkbox" name="includes_transport" value="1" {{ old('includes_transport', $tourPackage->includes_transport) ? 'checked' : '' }}>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Tours (select multiple)</label>
                <select name="tours[]" multiple class="w-full border p-2">
                    @foreach(App\Models\Tour::all() as $t)
                        <option value="{{ $t->id }}" {{ in_array($t->id, old('tours', $tourPackage->tours->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Image</label>
                <input type="file" name="image" class="w-full">
                @if($tourPackage->image)
                    <p class="mt-2">Current image: <img src="{{ Storage::url($tourPackage->image) }}" alt="" class="h-24"></p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-emerald-500 text-white rounded">Save Changes</button>
            <a href="{{ route('admin.tour-packages.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-emerald-50 p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Tour Package</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tour-packages.update', $tourPackage) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name_id" class="block font-semibold mb-1">Nama (ID)</label>
            <input type="text" name="name_id" id="name_id" value="{{ old('name_id', $tourPackage->name_id) }}" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="name_en" class="block font-semibold mb-1">Nama (EN)</label>
            <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $tourPackage->name_en) }}" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="name_zh" class="block font-semibold mb-1">Nama (ZH)</label>
            <input type="text" name="name_zh" id="name_zh" value="{{ old('name_zh', $tourPackage->name_zh) }}" required class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="description_id" class="block font-semibold mb-1">Deskripsi (ID)</label>
            <textarea name="description_id" id="description_id" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description_id', $tourPackage->description_id) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="description_en" class="block font-semibold mb-1">Deskripsi (EN)</label>
            <textarea name="description_en" id="description_en" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description_en', $tourPackage->description_en) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="description_zh" class="block font-semibold mb-1">Deskripsi (ZH)</label>
            <textarea name="description_zh" id="description_zh" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description_zh', $tourPackage->description_zh) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block font-semibold mb-1">Harga</label>
            <input type="number" name="price" id="price" value="{{ old('price', $tourPackage->price) }}" required min="0" step="0.01" class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>

        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Gambar</label>
            @if($tourPackage->image)
                    <img src="{{ Storage::url($tourPackage->image) }}" alt="Gambar Tour Package" class="mb-2 max-h-48 rounded" />
                @endif
            <input type="file" name="image" id="image" class="w-full" />
        </div>

        <div class="mb-4 flex items-center space-x-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="includes_guide" value="1" {{ old('includes_guide', $tourPackage->includes_guide) ? 'checked' : '' }} class="form-checkbox" />
                <span class="ml-2">Includes Guide</span>
            </label>

            <label class="inline-flex items-center">
                <input type="checkbox" name="includes_transport" value="1" {{ old('includes_transport', $tourPackage->includes_transport) ? 'checked' : '' }} class="form-checkbox" />
                <span class="ml-2">Includes Transport</span>
            </label>
        </div>

        <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded hover:bg-emerald-700 transition">Update</button>
        <a href="{{ route('admin.tour-packages.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
