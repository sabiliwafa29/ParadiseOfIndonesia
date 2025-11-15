@php
    $isEdit = isset($tourPackage) && $tourPackage;
@endphp

<form action="{{ $isEdit ? route('admin.tour-packages.update', $tourPackage) : route('admin.tour-packages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ID)</label>
            <input type="text" name="name_id" value="{{ old('name_id', $tourPackage->name_id ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (EN)</label>
            <input type="text" name="name_en" value="{{ old('name_en', $tourPackage->name_en ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama (ZH)</label>
            <input type="text" name="name_zh" value="{{ old('name_zh', $tourPackage->name_zh ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $tourPackage->price ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ID)</label>
            <textarea name="description_id" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_id', $tourPackage->description_id ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (EN)</label>
            <textarea name="description_en" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_en', $tourPackage->description_en ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Deskripsi (ZH)</label>
            <textarea name="description_zh" rows="2" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description_zh', $tourPackage->description_zh ?? '') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar</label>
            @if($isEdit && $tourPackage->image)
                @include('components.responsive-image', ['path' => $tourPackage->image, 'alt' => 'Gambar', 'class' => 'mb-2 max-h-32 rounded', 'derivatives' => $tourPackage->image_derivatives])
            @endif
            <input type="file" name="image" class="mt-1 block w-full rounded-md border-gray-300">
        </div>
        <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="includes_guide" value="1" {{ old('includes_guide', $tourPackage->includes_guide ?? true) ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2">Includes Guide</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="includes_transport" value="1" {{ old('includes_transport', $tourPackage->includes_transport ?? true) ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2">Includes Transport</span>
            </label>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Pilih Tours (bisa lebih dari satu)</label>
            <select name="tours[]" multiple class="mt-1 block w-full rounded-md border-gray-300">
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}"
                        @if(collect(old('tours', $tourPackage->tours->pluck('id') ?? []))->contains($tour->id)) selected @endif>
                        {{ $tour->name_id }} / {{ $tour->name_en }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Tekan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</p>
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-8">
        <a href="{{ route('admin.tour-packages.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
    </div>
</form>
