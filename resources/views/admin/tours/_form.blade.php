@php
    $isEdit = isset($tour) && $tour;
@endphp

<form action="{{ $isEdit ? route('admin.tours.update', $tour) : route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ID)</label>
            <input type="text" name="name_id" value="{{ old('name_id', $tour->name_id ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (EN)</label>
            <input type="text" name="name_en" value="{{ old('name_en', $tour->name_en ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ZH)</label>
            <input type="text" name="name_zh" value="{{ old('name_zh', $tour->name_zh ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $tour->slug ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Destination</label>
            <select name="destination_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                <option value="">-- Pilih Destination --</option>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" @if(old('destination_id', $tour->destination_id ?? '') == $dest->id) selected @endif>
                        {{ $dest->name_id }} / {{ $dest->name_en }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $tour->price ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Durasi (hari)</label>
            <input type="number" name="duration" value="{{ old('duration', $tour->duration ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar</label>
            @if($isEdit && $tour->image)
                <img src="{{ asset('storage/' . $tour->image) }}" alt="Gambar Tour" class="mb-2 max-h-32 rounded">
            @endif
            <input type="file" name="image" class="mt-1 block w-full rounded-md border-gray-300">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ID)</label>
            <textarea name="description_id" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_id', $tour->description_id ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (EN)</label>
            <textarea name="description_en" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_en', $tour->description_en ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ZH)</label>
            <textarea name="description_zh" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_zh', $tour->description_zh ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Itinerary (satu baris per hari)</label>
            <textarea name="itinerary" rows="4" class="mt-1 block w-full rounded-md border-gray-300">{{ old('itinerary', isset($tour->itinerary) ? (is_array($tour->itinerary) ? implode("\n", $tour->itinerary) : $tour->itinerary) : '') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Pisahkan tiap hari/activity dengan baris baru.</p>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Includes (satu per baris)</label>
            <textarea name="includes" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('includes', isset($tour->includes) ? (is_array($tour->includes) ? implode("\n", $tour->includes) : $tour->includes) : '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Excludes (satu per baris)</label>
            <textarea name="excludes" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('excludes', isset($tour->excludes) ? (is_array($tour->excludes) ? implode("\n", $tour->excludes) : $tour->excludes) : '') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Featured</label>
            <input type="checkbox" name="featured" value="1" {{ old('featured', $tour->featured ?? false) ? 'checked' : '' }} class="form-checkbox">
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-8">
        <a href="{{ route('admin.tours.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
        <button
