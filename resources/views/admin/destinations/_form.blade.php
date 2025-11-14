@php
    $isEdit = isset($destination) && $destination;
@endphp

<form action="{{ $isEdit ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ID)</label>
            <input type="text" name="name_id" value="{{ old('name_id', $destination->name_id ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (EN)</label>
            <input type="text" name="name_en" value="{{ old('name_en', $destination->name_en ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ZH)</label>
            <input type="text" name="name_zh" value="{{ old('name_zh', $destination->name_zh ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $destination->slug ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $destination->location ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar</label>
            @if($isEdit && $destination->image)
                <img src="{{ asset('storage/' . $destination->image) }}" alt="Gambar" class="mb-2 max-h-32 rounded">
            @endif
            <input type="file" name="image" class="mt-1 block w-full rounded-md border-gray-300">
        </div>
        <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="featured" value="1" {{ old('featured', $destination->featured ?? false) ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2">Featured</span>
            </label>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ID)</label>
            <textarea name="description_id" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_id', $destination->description_id ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (EN)</label>
            <textarea name="description_en" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_en', $destination->description_en ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ZH)</label>
            <textarea name="description_zh" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_zh', $destination->description_zh ?? '') }}</textarea>
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-8">
        <a href="{{ route('admin.destinations.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
    </div>
</form>
