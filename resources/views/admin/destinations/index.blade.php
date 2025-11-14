@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-emerald-50 p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Destinasi</h1>
        <a href="{{ route('admin.destinations.create') }}" class="inline-block bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
            Tambah Destinasi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-emerald-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama (ID)</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama (EN)</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama (ZH)</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Featured</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($destinations as $destination)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $destination->name_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $destination->name_en }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $destination->name_zh }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $destination->location }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($destination->featured)
                            <span class="text-green-600 font-semibold">Ya</span>
                        @else
                            <span class="text-red-600 font-semibold">Tidak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                        <a href="{{ route('admin.destinations.edit', $destination) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">Edit</a>
                        <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus destinasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data destinasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $destinations->links() }}
    </div>
</div>
@endsection
