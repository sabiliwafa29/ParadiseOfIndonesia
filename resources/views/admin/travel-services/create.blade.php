@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb + Header --}}
        <div class="mb-6">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-500 hover:text-emerald-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <a href="{{ route('admin.travel-services.index') }}" class="text-gray-500 hover:text-emerald-600">Travel Services</a>
                    </li>
                    <li>
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-emerald-600 font-semibold">Create</span>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Create Travel Service</h1>
                    <p class="text-gray-600 mt-1">Add a new travel service to offer to customers</p>
                </div>
                <a href="{{ route('admin.travel-services.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-lg p-6">
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
                        <div class="flex justify-end">
                            <button class="px-4 py-2 bg-emerald-500 text-white rounded">Create</button>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Quick Tips</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Use clear service names</li>
                        <li>• Set an appropriate base price</li>
                        <li>• Provide helpful descriptions</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
