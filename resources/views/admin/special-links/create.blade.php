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
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Packages</label>
                            <p class="text-xs text-gray-500">Select one package to apply the special link for the entire package.</p>
                            <div class="mt-2 p-2 border rounded max-h-56 overflow-auto">
                                @foreach($packages as $p)
                                    <label class="flex items-center gap-2 p-1 rounded hover:bg-gray-50">
                                        <input type="radio" name="package_choice" value="pkg:{{ $p->id }}" class="package-choice" {{ old('tour_package_id') == $p->id ? 'checked' : '' }}>
                                        <span class="text-sm">{{ $p->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Tours</label>
                            <p class="text-xs text-gray-500">Or choose one or more tours to apply the special link only to those tours.</p>
                            <div class="mt-2 p-2 border rounded max-h-56 overflow-auto">
                                @foreach($tours as $t)
                                    <label class="flex items-center gap-2 p-1 rounded hover:bg-gray-50">
                                        <input type="checkbox" name="tour_choice[]" value="{{ $t->id }}" class="tour-choice" {{ in_array($t->id, old('tours', [])) ? 'checked' : '' }}>
                                        <span class="text-sm">{{ $t->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="tour_package_id" id="tour_package_id" value="{{ old('tour_package_id', '') }}">
                    <div id="tours-hidden-inputs">
                        @foreach(old('tours', []) as $oldTourId)
                            <input type="hidden" name="tours[]" value="{{ $oldTourId }}">
                        @endforeach
                    </div>
                    <p id="target-error" class="text-sm text-red-600 mt-2 hidden">Please select either a package or one or more tours — not both.</p>
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

        const selectedPkg = document.querySelector('input[name="package_choice"]:checked');
        const selectedTours = Array.from(document.querySelectorAll('input[name="tour_choice[]"]:checked'));

        if (selectedPkg) {
            hasPkg = true;
            pkgId = selectedPkg.value.split(':')[1];
        }

        selectedTours.forEach(cb => {
            hasTour = true;
            const id = cb.value;
            const inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'tours[]';
            inp.value = id;
            hiddenContainer.appendChild(inp);
        });

        if (hasPkg && hasTour) {
            errorEl.classList.remove('hidden');
            if (form) form.querySelector('button[type="submit"], button').disabled = true;
        } else {
            errorEl.classList.add('hidden');
            if (form) form.querySelector('button[type="submit"], button').disabled = false;
        }

        hiddenPackage.value = pkgId || '';
    }

    if (select) {
        // wire package radios and tour checkboxes
        document.querySelectorAll('input[name="package_choice"]').forEach(r => r.addEventListener('change', function() {
            // if a package is chosen, uncheck tours
            if (this.checked) {
                document.querySelectorAll('input[name="tour_choice[]"]').forEach(cb => cb.checked = false);
            }
            syncHiddenInputs();
        }));

        document.querySelectorAll('input[name="tour_choice[]"]').forEach(cb => cb.addEventListener('change', function() {
            // if any tour is checked, clear package radio
            if (this.checked) {
                document.querySelectorAll('input[name="package_choice"]').forEach(r => r.checked = false);
            }
            syncHiddenInputs();
        }));

        // initial sync
        syncHiddenInputs();
    }
});
</script>
@endpush
