@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create Tour</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded">
            <ul class="text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Name (ID)</label>
                <input type="text" name="name_id" value="{{ old('name_id') }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block mb-1">Name (EN)</label>
                <input type="text" name="name_en" value="{{ old('name_en') }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block mb-1">Name (ZH)</label>
                <input type="text" name="name_zh" value="{{ old('name_zh') }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border p-2" required>
            </div>

            <div>
                <label class="block mb-1">Price (USD)</label>
                <input type="number" step="0.01" name="price_usd" value="{{ old('price_usd') }}" class="w-full border p-2" required>
            </div>
            <div>
                <label class="block mb-1">Duration (days)</label>
                <input type="number" name="duration" value="{{ old('duration', 1) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label class="block mb-1">Destination</label>
                <select name="destination_id" class="w-full border p-2">
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}">{{ $d->name_id ?? $d->name_en }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Target Market</label>
                <select name="target_market" class="w-full border p-2">
                    <option value="domestic">Domestic</option>
                    <option value="international">International</option>
                    <option value="both" selected>Both</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Itinerary (JSON)</label>
                <textarea name="itinerary" class="w-full border p-2" rows="4">{{ old('itinerary') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Includes (JSON)</label>
                <textarea name="includes" class="w-full border p-2" rows="3">{{ old('includes') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Excludes (JSON)</label>
                <textarea name="excludes" class="w-full border p-2" rows="3">{{ old('excludes') }}</textarea>
            </div>

            <div>
                <label class="block mb-1">Featured</label>
                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
            </div>

            <div>
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border p-2">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1">Image (URL or upload)</label>
                <input type="file" name="image" class="w-full">
            </div>
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-emerald-500 text-white rounded">Create Tour</button>
            <a href="{{ route('admin.tours.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
@extends('layouts.admin')

@section('page-title', 'Create New Tour Package')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-emerald-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="{{ route('admin.tours.index') }}" class="ml-1 text-sm font-medium text-gray-600 hover:text-emerald-600 md:ml-2">Tour Packages</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Create New</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New Tour Package</h1>
                    <p class="text-gray-600">Fill in the details below to create a new tour package</p>
                </div>
                <a href="{{ route('admin.tours.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Tour Package Information
                </h3>
            </div>
            
            <div class="p-6">
                @include('admin.tours._form', ['tour' => null, 'destinations' => $destinations])
            </div>
        </div>

        {{-- Help Card --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Quick Tips</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Make sure to fill in all required fields marked with an asterisk (*)</li>
                        <li>• Use high-quality images for better presentation</li>
                        <li>• Write clear and engaging descriptions to attract customers</li>
                        <li>• Double-check pricing and duration information</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection