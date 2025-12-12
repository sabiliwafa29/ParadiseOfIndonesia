@extends('layouts.app')

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
                        <td class="p-3 font-mono text-sm">{{ $link->token }}</td>
                        <td class="p-3">{{ $link->package->name ?? '-' }}</td>
                        <td class="p-3">{{ $link->price_special_usd ?? '-' }} / {{ $link->price_special_idr ?? '-' }} / {{ $link->price_special_cny ?? '-' }}</td>
                        <td class="p-3">{{ $link->expires_at ? $link->expires_at->format('Y-m-d') : '-' }}</td>
                        <td class="p-3">{{ $link->used_count }}{{ $link->max_uses ? ' / '.$link->max_uses : '' }}</td>
                        <td class="p-3">
                            <a href="{{ route('admin.special-links.edit', $link) }}" class="text-emerald-600 mr-2">Edit</a>
                            <form action="{{ route('admin.special-links.destroy', $link) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete?');">
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
@endsection
