@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Special Links</h1>
        <a href="{{ route('admin.special-links.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded">Create Link</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 text-green-800">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Token</th>
                    <th class="p-3">Package</th>
                    <th class="p-3">Price (USD/IDR/CNY)</th>
                    <th class="p-3">Expires</th>
                    <th class="p-3">Uses</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($links as $link)
                    <tr class="border-t">
                        <td class="p-3 font-mono text-sm">
                            <div class="flex items-center gap-2">
                                <span class="token-text">{{ $link->token }}</span>
                                <button type="button" data-token="{{ $link->token }}" class="copy-token inline-flex items-center px-2 py-1 border rounded text-xs bg-gray-50 hover:bg-gray-100">Copy</button>
                            </div>
                        </td>
                        <td class="p-3">{{ $link->package->name ?? '-' }}</td>
                        <td class="p-3">{{ $link->price_special_usd ?? '-' }} / {{ $link->price_special_idr ?? '-' }} / {{ $link->price_special_cny ?? '-' }}</td>
                        <td class="p-3">{{ $link->expires_at ? \Carbon\Carbon::parse($link->expires_at)->format('Y-m-d') : '-' }}</td>
                        <td class="p-3">{{ $link->used_count }}{{ $link->max_uses ? ' / '.$link->max_uses : '' }}</td>
                        <td class="p-3">
                            <a href="{{ route('admin.special-links.edit', $link) }}" class="text-emerald-600 mr-2">Edit</a>
                            <form action="{{ route('admin.special-links.destroy', $link) }}" method="POST" class="inline-block delete-special-link-form">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No special links yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $links->links() }}</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy token buttons
        document.querySelectorAll('.copy-token').forEach(function(btn) {
            btn.addEventListener('click', async function() {
                const token = this.dataset.token;
                try {
                    await navigator.clipboard.writeText(token);
                    this.textContent = 'Copied';
                    setTimeout(() => this.textContent = 'Copy', 1500);
                } catch (e) {
                    // Fallback: select text
                    const span = this.parentElement.querySelector('.token-text');
                    const range = document.createRange();
                    range.selectNode(span);
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            });
        });

        // Improve delete confirmation for special-link delete forms
        document.querySelectorAll('.delete-special-link-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const tokenCell = form.closest('tr')?.querySelector('.token-text');
                const token = tokenCell ? tokenCell.textContent.trim() : '';
                if (confirm('Delete special link "' + token + '"? This cannot be undone.')) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
