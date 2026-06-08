@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Tour Activity</h1>
        <a href="{{ route('admin.tour-activities.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back to List</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.tour-activities.update', $tourActivity) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Basic Information</h3>
                        
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">Activity Name *</label>
                            <input type="text" name="name" value="{{ old('name', $tourActivity->name) }}" 
                                   @class(['w-full p-3 rounded-lg', 'border-red-500 border-2' => $errors->has('name'), 'border border-gray-300' => !$errors->has('name')]) 
                                   placeholder="e.g., Sunrise Hiking" required>
                            @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block mb-2 font-medium">Duration *</label>
                                <input type="text" name="time" value="{{ old('time', $tourActivity->time) }}" 
                                       @class(['w-full p-3 rounded-lg', 'border-red-500 border-2' => $errors->has('time'), 'border border-gray-300' => !$errors->has('time')]) 
                                       placeholder="e.g., 2-3 hours" required>
                                @error('time')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block mb-2 font-medium">Location *</label>
                                <input type="text" name="location" value="{{ old('location', $tourActivity->location) }}" 
                                       @class(['w-full p-3 rounded-lg', 'border-red-500 border-2' => $errors->has('location'), 'border border-gray-300' => !$errors->has('location')]) 
                                       placeholder="e.g., Mount Bromo" required>
                                @error('location')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">Photo</label>
                            @if($tourActivity->photo)
                                <div class="mb-2">
                                    <img src="{{ asset($tourActivity->photo) }}" alt="Current photo" class="w-32 h-32 object-cover rounded-lg">
                                    <p class="text-sm text-gray-500 mt-1">Current photo</p>
                                </div>
                            @endif
                            <input type="file" name="photo" accept="image/*" 
                                   @class(['w-full p-3 rounded-lg', 'border-red-500 border-2' => $errors->has('photo'), 'border border-gray-300' => !$errors->has('photo')])>
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep current photo. Max 2MB (JPEG, PNG, JPG, WEBP)</p>
                            @error('photo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">Description</label>
                            <textarea name="description" rows="4" 
                                      @class(['w-full p-3 rounded-lg', 'border-red-500 border-2' => $errors->has('description'), 'border border-gray-300' => !$errors->has('description')]) 
                                      placeholder="Describe the activity in detail...">{{ old('description', $tourActivity->description) }}</textarea>
                            @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Highlights -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Activity Highlights</h3>
                        <div id="highlights-container">
                            @php
                                $highlights = old('highlights');
                                if (!$highlights && $tourActivity->highlights) {
                                    $decoded = json_decode($tourActivity->highlights, true);
                                    $highlights = is_array($decoded) ? $decoded : [$tourActivity->highlights];
                                }
                                if (!$highlights) {
                                    $highlights = [''];
                                }
                            @endphp
                            
                            @foreach($highlights as $highlight)
                                <div class="flex gap-2 mb-2 highlight-item">
                                    <input type="text" name="highlights[]" value="{{ $highlight }}" 
                                           class="flex-1 p-3 border border-gray-300 rounded-lg" 
                                           placeholder="e.g., Stunning panoramic views">
                                    <button type="button" onclick="this.parentElement.remove()" 
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Remove</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addHighlight()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">+ Add Highlight</button>
                    </div>

                    <!-- What to Bring -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">What to Bring</h3>
                        <div id="bring-container">
                            @php
                                $whatToBring = old('what_to_bring');
                                if (!$whatToBring && $tourActivity->what_to_bring) {
                                    $decoded = json_decode($tourActivity->what_to_bring, true);
                                    $whatToBring = is_array($decoded) ? $decoded : [$tourActivity->what_to_bring];
                                }
                                if (!$whatToBring) {
                                    $whatToBring = [''];
                                }
                            @endphp
                            
                            @foreach($whatToBring as $item)
                                <div class="flex gap-2 mb-2 bring-item">
                                    <input type="text" name="what_to_bring[]" value="{{ $item }}" class="flex-1 p-3 border border-gray-300 rounded-lg" placeholder="e.g., Comfortable hiking shoes">
                                    <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Remove</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addBringItem()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">+ Add Item</button>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Important Notes</h3>
                        <textarea name="notes" rows="3" @class(['w-full p-3 rounded-lg', 'border-red-500 border-2' => $errors->has('notes'), 'border border-gray-300' => !$errors->has('notes')]) placeholder="e.g., Not suitable for people with heart conditions">{{ old('notes', $tourActivity->notes) }}</textarea>
                        @error('notes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 font-semibold">Update Activity</button>
                        <a href="{{ route('admin.tour-activities.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <aside class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-4 bg-emerald-600 text-white">
                    <h4 class="font-semibold">Quick Info</h4>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Created</span><span class="text-sm font-medium text-gray-800">{{ $tourActivity->created_at ? $tourActivity->created_at->format('M d, Y') : '-' }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Updated</span><span class="text-sm font-medium text-gray-800">{{ $tourActivity->updated_at ? $tourActivity->updated_at->format('M d, Y') : '-' }}</span></div>
                    <div class="pt-2">
                        <form action="{{ route('admin.tour-activities.destroy', $tourActivity) }}" method="POST" onsubmit="return confirm('Delete this activity?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-md">Delete Activity</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
function addHighlight() {
    const container = document.getElementById('highlights-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 mb-2 highlight-item';
    div.innerHTML = `
        <input type="text" name="highlights[]" class="flex-1 p-3 border border-gray-300 rounded-lg" 
               placeholder="e.g., Stunning panoramic views">
        <button type="button" onclick="this.parentElement.remove()" 
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Remove
        </button>
    `;
    container.appendChild(div);
}

function addBringItem() {
    const container = document.getElementById('bring-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 mb-2 bring-item';
    div.innerHTML = `
        <input type="text" name="what_to_bring[]" class="flex-1 p-3 border border-gray-300 rounded-lg" 
               placeholder="e.g., Comfortable hiking shoes">
        <button type="button" onclick="this.parentElement.remove()" 
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Remove
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
