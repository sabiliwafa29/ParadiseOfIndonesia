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
                            <li class="text-gray-700">Create</li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-800">Create Special Link</h1>
                    <p class="text-gray-600 mt-1">Generate a private promotional link that applies custom pricing for a package.</p>
                </div>
                <a href="{{ route('admin.special-links.index') }}" class="inline-flex items-center px-4 py-2 border rounded text-sm">
                    Back to list
                </a>
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
            <form action="{{ route('admin.special-links.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Apply To (choose package or one/more tours)</label>
                    <p class="text-xs text-gray-500">Select a package to apply the special link to the whole package, or select one or more tours to apply the special link only to those tours. Do not mix package + tours selections.</p>
                    <select id="target-selection" name="target_selection[]" multiple class="w-full mt-1 p-2 border rounded h-44">
                        <optgroup label="Packages">
                            @foreach($packages as $p)
                                <option value="pkg:{{ $p->id }}" @if(old('tour_package_id') == $p->id) selected @endif>Package: {{ $p->name }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Tours">
                            @foreach($tours as $t)
                                <option value="tour:{{ $t->id }}" @if(in_array($t->id, old('tours', []))) selected @endif>Tour: {{ $t->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>

                    <input type="hidden" name="tour_package_id" id="tour_package_id" value="{{ old('tour_package_id', '') }}">
                    <div id="tours-hidden-inputs">
                        @foreach(old('tours', []) as $oldTourId)
                            <input type="hidden" name="tours[]" value="{{ $oldTourId }}">
                        @endforeach
                    </div>
                    <p id="target-error" class="text-sm text-red-600 mt-2 hidden">Please select either package or tours, not both.</p>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Price USD</label>
                        <input type="number" step="0.01" name="price_special_usd" class="w-full mt-1 p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Price IDR</label>
                        <input type="number" step="0.01" name="price_special_idr" class="w-full mt-1 p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Price CNY</label>
                        <input type="number" step="0.01" name="price_special_cny" class="w-full mt-1 p-2 border rounded">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Expires At</label>
                        <input type="date" name="expires_at" class="w-full mt-1 p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Max Uses</label>
                        <input type="number" name="max_uses" class="w-full mt-1 p-2 border rounded">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium">Min Guests (special price applies from)</label>
                        <input type="number" name="min_guests" min="1" class="w-full mt-1 p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Max Guests (special price up to)</label>
                        <input type="number" name="max_guests" min="1" class="w-full mt-1 p-2 border rounded">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium">Fixed Guests (optional)</label>
                    <p class="text-xs text-gray-500">If set, the special price applies only for this exact guest count.</p>
                    <input type="number" name="fixed_guests" min="1" class="w-40 mt-1 p-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Note</label>
                    <textarea name="note" rows="3" class="w-full mt-1 p-2 border rounded"></textarea>
                </div>

                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-emerald-600 text-white rounded">Create</button>
                    <a href="{{ route('admin.special-links.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('target-selection');
    const hiddenPackage = document.getElementById('tour_package_id');
    const hiddenContainer = document.getElementById('tours-hidden-inputs');
    const errorEl = document.getElementById('target-error');
    const form = select ? select.closest('form') : null;

    function syncHiddenInputs() {
        // clear current hidden tour inputs
        hiddenContainer.innerHTML = '';
        let hasPkg = false;
        let pkgId = null;
        let hasTour = false;
        const selected = Array.from(select.selectedOptions).map(o => o.value);

        selected.forEach(val => {
            if (val.startsWith('pkg:')) {
                hasPkg = true;
                if (!pkgId) pkgId = val.split(':')[1];
            } else if (val.startsWith('tour:')) {
                hasTour = true;
                const id = val.split(':')[1];
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'tours[]';
                inp.value = id;
                hiddenContainer.appendChild(inp);
            }
        });

        if (hasPkg && hasTour) {
            errorEl.classList.remove('hidden');
            // disable submit
            if (form) form.querySelector('button[type="submit"], button').disabled = true;
        } else {
            errorEl.classList.add('hidden');
            if (form) form.querySelector('button[type="submit"], button').disabled = false;
        }

        hiddenPackage.value = pkgId || '';
    }

    if (select) {
        select.addEventListener('change', syncHiddenInputs);
        // initial sync
        syncHiddenInputs();
    }
});
</script>
@endpush
