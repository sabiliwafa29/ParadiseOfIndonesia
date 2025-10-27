@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Manage Tours</h2>
                <a href="{{ route('admin.tours.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded">New Tour</a>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            <div class="grid gap-4">
                @foreach($tours as $tour)
                <div class="p-4 border rounded flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $tour->name }} <span class="text-sm text-gray-500">({{ $tour->slug }})</span></h3>
                        <div class="text-sm text-gray-600">{{ Str::limit($tour->description, 120) }}</div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.tours.edit', $tour) }}" class="px-3 py-1 bg-blue-500 text-white rounded">Edit</a>
                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Delete this tour?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $tours->links() }}</div>
        </div>
    </div>
</div>
@endsection
