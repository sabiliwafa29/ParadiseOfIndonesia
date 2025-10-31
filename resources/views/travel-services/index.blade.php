@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h2 class="text-2xl font-bold mb-6">Travel Services</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($services as $service)
                        <div class="bg-gray-100 rounded-lg shadow-md">
                            <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="p-4">
                                <span class="inline-block bg-emerald-200 text-emerald-800 text-xs px-2 rounded-full uppercase font-semibold tracking-wide">{{ $service->type }}</span>
                                <h3 class="text-lg font-semibold mt-2">{{ $service->name }}</h3>
                                <p class="text-gray-600 mt-2">{{ $service->description }}</p>
                                <div class="mt-4">
                                    <span class="font-bold text-xl">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('travel-services.show', $service) }}" class="w-full py-2 bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">
                                            Select
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No travel services found.</p>
                        @endforelse
                </div>

                <div class="mt-6">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
