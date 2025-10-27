@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Tours</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tours as $tour)
                    <div class="rounded-lg overflow-hidden shadow">
                        <a href="{{ route('tours.show', $tour) }}">
                            <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold"><a href="{{ route('tours.show', $tour) }}">{{ $tour->name }}</a></h3>
                            <p class="text-gray-500">{{ Str::limit($tour->description, 120) }}</p>
                            <div class="mt-2 font-bold text-emerald-600">${{ number_format($tour->price, 0) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $tours->links() }}</div>
        </div>
    </div>
</div>
@endsection
