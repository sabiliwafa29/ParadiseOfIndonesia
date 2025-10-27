@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" class="w-full h-64 object-cover">
            <div class="p-6">
                <h1 class="text-3xl font-bold">{{ $tour->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $tour->destination->name }}</p>
                <div class="mt-4 text-gray-700">{!! nl2br(e($tour->description)) !!}</div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-semibold">Duration</h3>
                        <p>{{ $tour->duration }} days</p>
                    </div>
                    <div>
                        <h3 class="font-semibold">Price</h3>
                        <p class="text-emerald-600 font-bold">${{ number_format($tour->price, 2) }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <form action="{{ route('bookings.store', $tour) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Guests</label>
                                <input type="number" name="guests" value="1" min="1" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-md">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
