@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-emerald-50 p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Tour Packages</h1>
        <a href="{{ route('admin.tour-packages.create') }}" class="inline-block bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
            Tambah Tour Package
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
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Includes Guide</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Includes Transport</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($packages as $package)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $package->name_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $package->name_en }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $package->name_zh }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($package->includes_guide)
                            <span class="text-green-600 font-semibold">Ya</span>
                        @else
                            <span class="text-red-600 font-semibold">Tidak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($package->includes_transport)
                            <span class="text-green-600 font-semibold">Ya</span>
                        @else
                            <span class="text-red-600 font-semibold">Tidak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                        <a href="{{ route('admin.tour-packages.edit', $package) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">Edit</a>
                        <form action="{{ route('admin.tour-packages.destroy', $package) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tour package ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data tour package.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $packages->links() }}
    </div>
</div>
@endsection
