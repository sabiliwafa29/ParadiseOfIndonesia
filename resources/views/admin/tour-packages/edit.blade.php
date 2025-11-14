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
                <img src="{{ asset('storage/' . $tourPackage->image) }}" alt="Gambar Tour Package" class="mb-2 max-h-48 rounded" />
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
