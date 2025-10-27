@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}" class="w-full h-64 object-cover">
            <div class="p-6">
                <h1 class="text-3xl font-bold">{{ $destination->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $destination->location }}</p>
                <div class="mt-4 text-gray-700">{!! nl2br(e($destination->description)) !!}</div>

                <h2 class="mt-8 text-2xl font-semibold">Tours in {{ $destination->name }}</h2>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($tours as $tour)
                        <div class="border rounded p-4">
                            <a href="{{ route('tours.show', $tour) }}">
                                <h3 class="text-lg font-semibold">{{ $tour->name }}</h3>
                            </a>
                            <p class="text-gray-500">{{ Str::limit($tour->description, 100) }}</p>
                            <div class="mt-2 font-bold text-emerald-600">${{ number_format($tour->price, 0) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $tours->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
