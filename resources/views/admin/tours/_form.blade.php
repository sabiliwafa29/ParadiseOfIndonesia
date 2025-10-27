@php
    $isEdit = isset($tour) && $tour;
@endphp

<form action="{{ $isEdit ? route('admin.tours.update', $tour) : route('admin.tours.store') }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name', $tour->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $tour->slug ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Destination</label>
            <select name="destination_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" @if(old('destination_id', $tour->destination_id ?? '') == $dest->id) selected @endif>{{ $dest->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Price (USD)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $tour->price ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Duration (days)</label>
            <input type="number" name="duration" value="{{ old('duration', $tour->duration ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Image path</label>
            <input type="text" name="image" value="{{ old('image', $tour->image ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $tour->description ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Itinerary (one line per item / day)</label>
            <textarea name="itinerary" rows="6" class="mt-1 block w-full rounded-md border-gray-300">{{ old('itinerary', $tour->itinerary ?? '') }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Pisahkan tiap hari / activity dengan baris baru.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Includes (one per line)</label>
            <textarea name="includes" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('includes', $tour->includes ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Excludes (one per line)</label>
            <textarea name="excludes" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('excludes', $tour->excludes ?? '') }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.tours.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">{{ $isEdit ? 'Update' : 'Create' }}</button>
        </div>
    </div>
</form>
