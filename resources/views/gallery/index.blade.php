@extends('layouts.app')

@section('content')
<div class="py-12" x-data="{ open: false, imageUrl: '' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                
                <h2 class="text-2xl font-bold mb-6">Gallery</h2>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($galleries as $gallery)
                        <div @click="open = true; imageUrl = '{{ asset($gallery->path) }}'">
                            <img src="{{ asset($gallery->path) }}" alt="{{ $gallery->name }}" class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity">
                        </div>
                    @empty
                        <p>No images found in the gallery.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>

    <div x-show="open" 
         @click="open = false" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 cursor-pointer" 
         style="display: none;">
        
        <div class="relative p-4" @click.stop>
            <img :src="imageUrl" alt="Zoomed Image" class="max-w-full max-h-screen">
            
            <button @click="open = false" 
                    class="absolute top-2 right-0 text-white text-5xl font-bold leading-none">&times;</button>
        </div>
    </div>
</div>
@endsection