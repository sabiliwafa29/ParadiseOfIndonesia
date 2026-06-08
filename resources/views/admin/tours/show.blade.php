@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $tour->name ?? 'Tour Detail' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">ID: {{ $tour->id }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.tours.edit', $tour) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-md">Edit</a>
                    <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md">Back</a>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="w-full h-56 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                        @if($tour->image)
                            @include('components.responsive-image', ['path' => $tour->image, 'alt' => $tour->name ?? '', 'class' => 'w-full h-full object-cover', 'derivatives' => $tour->image_derivatives ?? null])
                        @else
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"/></svg>
                        @endif
                    </div>

                    <div class="mt-4 text-sm text-gray-600">
                        <p><strong>Destination:</strong> {{ $tour->destination->name ?? '—' }}</p>
                        <p class="mt-2"><strong>Duration:</strong> {{ $tour->duration ?? '—' }}</p>
                        <p class="mt-2"><strong>Min Guests:</strong> {{ $tour->min_guests ?? 1 }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="prose max-w-none text-gray-700">
                        <h3 class="text-lg font-semibold">Description</h3>
                        <p class="mt-2">{!! nl2br(e($tour->description ?? 'No description')) !!}</p>

                        <h3 class="text-lg font-semibold mt-6">Itinerary</h3>
                        @if(!empty($tour->itinerary_decoded))
                            <ul class="list-disc pl-6 mt-2 text-sm text-gray-700">
                                @foreach($tour->itinerary_decoded as $item)
                                    <li>{{ $item['title_en'] ?? $item['title_id'] ?? 'Untitled' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-2 text-sm text-gray-600">No itinerary available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
