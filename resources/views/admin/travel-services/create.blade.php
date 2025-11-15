@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create Travel Service</h1>

    <form action="{{ route('admin.travel-services.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('name'), 'border border-gray-300' => !$errors->has('name')]) required>
            @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Base Price</label>
            <input type="number" step="0.01" name="base_price" value="{{ old('base_price') }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('base_price'), 'border border-gray-300' => !$errors->has('base_price')]) required>
            @error('base_price')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Description</label>
            <textarea name="description" @class(['w-full p-2', 'border border-red-500' => $errors->has('description'), 'border border-gray-300' => !$errors->has('description')])>{{ old('description') }}</textarea>
            @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <button class="px-4 py-2 bg-emerald-500 text-white rounded">Create</button>
    </form>
</div>
@endsection
