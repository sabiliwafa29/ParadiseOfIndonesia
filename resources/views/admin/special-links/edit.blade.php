@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Special Link</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-800">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.special-links.update', $link) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium">Token</label>
            <input type="text" class="w-full mt-1 p-2 border rounded bg-gray-100" value="{{ $link->token }}" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium">Package</label>
            <select name="tour_package_id" class="w-full mt-1 p-2 border rounded">
                @foreach($packages as $p)
                    <option value="{{ $p->id }}" {{ $p->id == $link->tour_package_id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Price USD</label>
                <input type="number" step="0.01" name="price_special_usd" value="{{ $link->price_special_usd }}" class="w-full mt-1 p-2 border rounded">
            </div>
            <div>
                <label class="block text-sm font-medium">Price IDR</label>
                <input type="number" step="0.01" name="price_special_idr" value="{{ $link->price_special_idr }}" class="w-full mt-1 p-2 border rounded">
            </div>
            <div>
                <label class="block text-sm font-medium">Price CNY</label>
                <input type="number" step="0.01" name="price_special_cny" value="{{ $link->price_special_cny }}" class="w-full mt-1 p-2 border rounded">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Expires At</label>
                <input type="date" name="expires_at" value="{{ optional($link->expires_at)->format('Y-m-d') }}" class="w-full mt-1 p-2 border rounded">
            </div>
            <div>
                <label class="block text-sm font-medium">Max Uses</label>
                <input type="number" name="max_uses" value="{{ $link->max_uses }}" class="w-full mt-1 p-2 border rounded">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Note</label>
            <textarea name="note" rows="3" class="w-full mt-1 p-2 border rounded">{{ $link->note }}</textarea>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2 bg-emerald-600 text-white rounded">Update</button>
            <a href="{{ route('admin.special-links.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection
