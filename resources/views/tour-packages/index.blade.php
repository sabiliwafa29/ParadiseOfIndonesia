@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h2 class="text-2xl font-bold mb-6">Tour Packages</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($packages as $package)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
        <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover">
        
        <div class="p-4">
            <h3 class="text-lg font-semibold">{{ $package->name }}</h3>
            <p class="text-gray-600 mt-2 line-clamp-2">{{ $package->description }}</p>
            
            <!-- Price -->
            <div class="mt-4">
                <span class="font-bold text-xl text-emerald-600">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            </div>
            
            <!-- Includes -->
            @if($package->includes_guide || $package->includes_transport)
                <div class="mt-2 flex flex-wrap gap-2">
                    @if($package->includes_guide)
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">📋 Tour Guide</span>
                    @endif
                    @if($package->includes_transport)
                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">🚗 Transport</span>
                    @endif
                </div>
            @endif
            
            <!-- Button -->
            <div class="mt-4">
                @if($package->tours->isNotEmpty())
                    <a href="{{ route('tour-packages.show', $package->id) }}" class="w-full py-2 bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">
                        View Details
                    </a>
                @else
                    <span class="w-full py-2 bg-gray-400 text-white rounded-md font-semibold text-center block cursor-not-allowed">
                        No Tours Available
                    </span>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-12">
        <p class="text-gray-500">No tour packages found.</p>
    </div>
@endforelse
                </div>

                <div class="mt-6">
                    {{ $packages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
