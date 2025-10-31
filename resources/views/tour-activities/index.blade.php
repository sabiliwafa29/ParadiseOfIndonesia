@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <h2 class="text-2xl font-bold mb-6">Destination Highlight</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse($activities as $activity)
                    <div class="rounded-lg overflow-hidden shadow">
                        
                        <img src="{{ asset($activity->photo) }}" alt="{{ $activity->name }}" class="w-full h-48 object-cover">
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $activity->name }}</h3>
                            <p class="text-gray-500">{{ $activity->location }}</p>
                            <p class="text-gray-500 text-sm">{{ $activity->time }}</p>
                        </div>
                    </div>
                @empty
                    <p>No tour activities found.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $activities->links() }}
            </div>

        </div>
    </div>
</div>
@endsection