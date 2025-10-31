@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h2 class="text-2xl font-bold mb-6">Tour Packages</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($packages as $package)
                        <div class="bg-gray-100 rounded-lg shadow-md">
                            <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $package->name }}</h3>
                                <p class="text-gray-600 mt-2">{{ $package->description }}</p>
                                <div class="mt-4">
                                    <span class="font-bold text-xl">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    @if($package->includes_guide)
                                        <span>Includes Tour Guide</span>
                                    @endif
                                    @if($package->includes_transport)
                                        <span class="ml-2">Includes Private Transport</span>
                                    @endif
                                    </div>
                                    <div class="mt-4">
                                        @if($package->tours->isNotEmpty())
                                            <a href="{{ route('tours.show', $package->tours->first()) }}" class="w-full py-2 bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">
                                                Book Now
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
                            <p>No tour packages found.</p>
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
