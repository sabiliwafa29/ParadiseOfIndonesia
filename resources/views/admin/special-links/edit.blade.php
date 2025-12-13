@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="text-sm mb-3" aria-label="Breadcrumb">
                        <ol class="list-none p-0 inline-flex items-center text-gray-500">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a></li>
                            <li class="mx-2">/</li>
                            <li><a href="{{ route('admin.special-links.index') }}" class="hover:text-gray-700">Special Links</a></li>
                            <li class="mx-2">/</li>
                            <li class="text-gray-700">Edit</li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Special Link</h1>
                    <p class="text-gray-600 mt-1">Update token settings, pricing and expiry for this special link.</p>
                </div>
                <a href="{{ route('admin.special-links.index') }}" class="inline-flex items-center px-4 py-2 border rounded text-sm">Back to list</a>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-800">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.special-links.update', $link) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Token</label>
                    <div class="mt-1 flex gap-2">
                        <input id="special-token-input" type="text" class="flex-1 p-2 border rounded bg-gray-100" value="{{ $link->token }}" readonly>
                        <button type="button" id="copy-token-btn" data-token="{{ $link->token }}" class="px-3 py-2 border rounded bg-gray-50 hover:bg-gray-100">Copy</button>
                    </div>
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

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium">Min Guests (special price applies from)</label>
                        <input type="number" name="min_guests" min="1" value="{{ $link->min_guests ?? '' }}" class="w-full mt-1 p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Max Guests (special price up to)</label>
                        <input type="number" name="max_guests" min="1" value="{{ $link->max_guests ?? '' }}" class="w-full mt-1 p-2 border rounded">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium">Fixed Guests (optional)</label>
                    <p class="text-xs text-gray-500">If set, the special price applies only for this exact guest count.</p>
                    <input type="number" name="fixed_guests" min="1" value="{{ $link->fixed_guests ?? '' }}" class="w-40 mt-1 p-2 border rounded">
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
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyBtn = document.getElementById('copy-token-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', async function() {
                const token = this.dataset.token;
                try {
                    await navigator.clipboard.writeText(token);
                    this.textContent = 'Copied';
                    setTimeout(() => this.textContent = 'Copy', 1500);
                } catch (e) {
                    const input = document.getElementById('special-token-input');
                    input.select();
                }
            });
        }
    });
</script>

@endsection
