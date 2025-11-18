@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Edit Tour Session</h1>

    <form action="{{ route('admin.tour-sessions.update', $tourSession) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Date</label>
            <input type="date" name="date" value="{{ old('date', $tourSession->date->format('Y-m-d')) }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('date'), 'border border-gray-300' => !$errors->has('date')]) required>
            @error('date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $tourSession->capacity) }}" @class(['w-full p-2', 'border border-red-500' => $errors->has('capacity'), 'border border-gray-300' => !$errors->has('capacity')])>
            @error('capacity')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <button class="px-4 py-2 bg-emerald-500 text-white rounded">Save</button>
    </form>
</div>
@endsection
