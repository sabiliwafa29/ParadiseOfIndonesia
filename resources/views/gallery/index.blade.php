@extends('layouts.app')

@section('title', __('messages.gallery') . ' - ' . config('app.name', 'PNB Travel'))

@section('content')
<div x-data="{ open: false, imageUrl: '', imageTitle: '' }">

    {{-- Hero Header --}}
    <div class="bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 relative overflow-hidden text-white py-16 md:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 bg-white/15 backdrop-blur-md rounded-full border border-white/25 mb-4 text-xs md:text-sm font-semibold uppercase tracking-wider">
                <span>📸 {{ __('messages.gallery') }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                {{ __('messages.gallery') }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
                {{ __('Capture the beauty of Indonesia through our lens') }}
            </p>
        </div>
    </div>

    {{-- Gallery Photo Grid --}}
    <div class="py-12 md:py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($galleries->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($galleries as $gallery)
                        <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1.5 cursor-pointer border border-gray-100 flex flex-col"
                             @click="open = true; imageUrl = '{{ $gallery->image_url }}'; imageTitle = '{{ addslashes($gallery->title ?? $gallery->name ?? '') }}'">
                            
                            <!-- Image Frame -->
                            <div class="aspect-square overflow-hidden bg-gray-100 relative">
                                <img src="{{ $gallery->image_url }}" 
                                     alt="{{ $gallery->title ?? $gallery->name }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                     loading="lazy">
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-white/25 backdrop-blur-md flex items-center justify-center text-white transform scale-75 group-hover:scale-100 transition duration-300 shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                        </svg>
                                    </div>
                                </div>

                                @if($gallery->destination)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-emerald-800 shadow-sm">
                                            {{ $gallery->destination->name_en ?? $gallery->destination->name_id }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Image Caption -->
                            <div class="p-4 bg-white flex-1 flex flex-col justify-between">
                                <h3 class="font-bold text-gray-900 text-sm md:text-base group-hover:text-emerald-600 transition-colors truncate">
                                    {{ $gallery->title ?? $gallery->name }}
                                </h3>
                                @if($gallery->description)
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                                        {{ $gallery->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                    <div class="w-16 h-16 mx-auto bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ __('messages.no_images_found') }}</h3>
                    <p class="text-sm text-gray-500">Check back soon for new photo additions from Indonesia</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="open" 
         @click="open = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 cursor-pointer backdrop-blur-md p-4" 
         style="display: none;"
         x-cloak>
        
        <div class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center justify-center" @click.stop>
            <img :src="imageUrl" 
                 :alt="imageTitle" 
                 class="max-w-full max-h-[80vh] w-auto h-auto rounded-2xl shadow-2xl object-contain">
            
            <p x-text="imageTitle" class="text-white text-base font-medium mt-3 text-center"></p>

            <button @click="open = false" 
                    class="absolute -top-4 -right-4 md:top-2 md:right-2 w-11 h-11 bg-white/90 hover:bg-white text-gray-800 rounded-full shadow-xl flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection
