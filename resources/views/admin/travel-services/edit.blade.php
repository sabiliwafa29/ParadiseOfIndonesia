@extends('layouts.admin')

@section('page-title', 'Edit Travel Service')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Edit Travel Service</h1>
                <p class="text-gray-600">Update a travel service and pricing.</p>
            </div>
            <div>
                <a href="{{ route('admin.travel-services.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <form action="{{ route('admin.travel-services.update', $service) }}" method="POST" class="space-y-6 bg-white rounded-xl shadow-lg overflow-hidden p-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', $service->name) }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('name'), 'border border-gray-300' => !$errors->has('name')]) required>
                        @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block mb-1">Base Price</label>
                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $service->base_price) }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('base_price'), 'border border-gray-300' => !$errors->has('base_price')]) required>
                        @error('base_price')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea name="description" @class(['w-full p-2', 'border border-red-500' => $errors->has('description'), 'border border-gray-300' => !$errors->has('description')])>{{ old('description', $service->description) }}</textarea>
                        @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3">
                        <button class="px-4 py-2 bg-emerald-500 text-white rounded">Save</button>
                        <a href="{{ route('admin.travel-services.index') }}" class="px-4 py-2 bg-gray-100 rounded text-gray-700">Cancel</a>
                    </div>
                </form>
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-4 bg-emerald-600 text-white"><h4 class="font-semibold">Quick Info</h4></div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Created</span><span class="text-sm font-medium text-gray-800">{{ $service->created_at ? $service->created_at->format('M d, Y') : '-' }}</span></div>
                        <div class="flex items-center justify-between"><span class="text-sm text-gray-600">Updated</span><span class="text-sm font-medium text-gray-800">{{ $service->updated_at ? $service->updated_at->format('M d, Y') : '-' }}</span></div>
                        <div class="pt-2">
                            <form action="{{ route('admin.travel-services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-md">Delete Service</button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
