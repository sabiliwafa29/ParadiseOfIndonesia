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
                <input type="text" name="name_id" value="{{ old('name_id', $tour->name_id ?? '') }}" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('name_id'), 'border border-gray-300' => !$errors->has('name_id')]) required>
            @error('name_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $tour->name_en ?? '') }}" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('name_en'), 'border border-gray-300' => !$errors->has('name_en')]) required>
            @error('name_en')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ZH)</label>
                <input type="text" name="name_zh" value="{{ old('name_zh', $tour->name_zh ?? '') }}" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('name_zh'), 'border border-gray-300' => !$errors->has('name_zh')]) required>
            @error('name_zh')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $tour->slug ?? '') }}" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('slug'), 'border border-gray-300' => !$errors->has('slug')]) required>
            @error('slug')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Destination</label>
                <select name="destination_id" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('destination_id'), 'border border-gray-300' => !$errors->has('destination_id')]) required>
                <option value="">-- Pilih Destination --</option>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" @if(old('destination_id', $tour->destination_id ?? '') == $dest->id) selected @endif>
                        {{ $dest->name_id }} / {{ $dest->name_en }}
                    </option>
                @endforeach
            </select>
            @error('destination_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga (USD)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $tour->price ?? '') }}" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('price'), 'border border-gray-300' => !$errors->has('price')]) required>
            @error('price')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Durasi (hari)</label>
                <input type="number" name="duration" value="{{ old('duration', $tour->duration ?? '') }}" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('duration'), 'border border-gray-300' => !$errors->has('duration')]) required>
            @error('duration')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar</label>
            @if($isEdit && $tour->image)
                @include('components.responsive-image', ['path' => $tour->image, 'alt' => 'Gambar Tour', 'class' => 'mb-2 max-h-32 rounded', 'derivatives' => $tour->image_derivatives])
            @endif
                <input type="file" name="image" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('image'), 'border border-gray-300' => !$errors->has('image')])>
            @error('image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ID)</label>
            <textarea name="description_id" rows="2" class="mt-1 block w-full rounded-md border-gray-300 @error('description_id') border-red-500 @enderror" required>{{ old('description_id', $tour->description_id ?? '') }}</textarea>
            @error('description_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (EN)</label>
            <textarea name="description_en" rows="2" class="mt-1 block w-full rounded-md border-gray-300 @error('description_en') border-red-500 @enderror" required>{{ old('description_en', $tour->description_en ?? '') }}</textarea>
            @error('description_en')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ZH)</label>
            <textarea name="description_zh" rows="2" class="mt-1 block w-full rounded-md border-gray-300 @error('description_zh') border-red-500 @enderror" required>{{ old('description_zh', $tour->description_zh ?? '') }}</textarea>
            @error('description_zh')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Itinerary (satu baris per hari)</label>
                <textarea name="itinerary" rows="4" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('itinerary'), 'border border-gray-300' => !$errors->has('itinerary')])>{{ old('itinerary', isset($tour->itinerary) ? (is_array($tour->itinerary) ? implode("\n", $tour->itinerary) : $tour->itinerary) : '') }}</textarea>
            @error('itinerary')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            <p class="text-xs text-gray-500 mt-1">Pisahkan tiap hari/activity dengan baris baru.</p>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Includes (satu per baris)</label>
                <textarea name="includes" rows="2" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('includes'), 'border border-gray-300' => !$errors->has('includes')])>{{ old('includes', isset($tour->includes) ? (is_array($tour->includes) ? implode("\n", $tour->includes) : $tour->includes) : '') }}</textarea>
            @error('includes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Excludes (satu per baris)</label>
                <textarea name="excludes" rows="2" @class(['mt-1 block w-full rounded-md', 'border border-red-500' => $errors->has('excludes'), 'border border-gray-300' => !$errors->has('excludes')])>{{ old('excludes', isset($tour->excludes) ? (is_array($tour->excludes) ? implode("\n", $tour->excludes) : $tour->excludes) : '') }}</textarea>
            @error('excludes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Featured</label>
            <input type="checkbox" name="featured" value="1" {{ old('featured', $tour->featured ?? false) ? 'checked' : '' }} class="form-checkbox">
            @error('featured')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-8">
        <a href="{{ route('admin.tours.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
        <button
