@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="py-12" x-data="{ open: false, imageUrl: '' }">

<div class="bg-gradient-to-br from-teal-600 via-cyan-600 to-blue-600 relative overflow-hidden">    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">            <div class="p-6 text-gray-900">

        <div class="text-center">                

            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">                <h2 class="text-2xl font-bold mb-6">{{ __('messages.gallery') }}</h2>

                <span class="text-white font-medium text-sm md:text-base">📸 {{ __('Browse amazing photos') }}</span>

            </div>                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.gallery') }}</h1>                    @forelse ($galleries as $gallery)

            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('Capture the beauty of Indonesia through our lens') }}</p>                        <div @click="open = true; imageUrl = '{{ asset($gallery->path) }}'">

        </div>                            <img src="{{ asset($gallery->path) }}" alt="{{ $gallery->name }}" class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity">

    </div>                        </div>

</div>                    @empty

                        <p>{{ __('messages.no_images_found') }}</p>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white" x-data="{ open: false, imageUrl: '' }">                    @endforelse

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">

            @forelse ($galleries as $gallery)                <div class="mt-6">

                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 cursor-pointer"                     {{ $galleries->links() }}

                     @click="open = true; imageUrl = '{{ asset($gallery->path) }}'">                </div>

                    <div class="aspect-square overflow-hidden">            </div>

                        <img src="{{ asset($gallery->path) }}"         </div>

                             alt="{{ $gallery->name }}"     </div>

                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>    <div x-show="open" 

                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">         @click="open = false" 

                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 cursor-pointer" 

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>         style="display: none;">

                            </svg>        

                        </div>        <div class="relative p-4" @click.stop>

                    </div>            <img :src="imageUrl" alt="Zoomed Image" class="max-w-full max-h-screen">

                </div>            

            @empty            <button @click="open = false" 

                <div class="col-span-full text-center py-12">                    class="absolute top-2 right-0 text-white text-5xl font-bold leading-none">&times;</button>

                    <div class="inline-block p-6 bg-gray-50 rounded-2xl">        </div>

                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">    </div>

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></div>

                        </svg>@endsection
                        <p class="text-sm md:text-base text-gray-500">{{ __('messages.no_images_found') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-8 md:mt-12">
            {{ $galleries->links() }}
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
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 cursor-pointer backdrop-blur-sm" 
         style="display: none;">
        
        <div class="relative p-4 max-w-6xl w-full" @click.stop>
            <img :src="imageUrl" 
                 alt="Zoomed Image" 
                 class="w-full h-auto rounded-2xl shadow-2xl">
            
            <button @click="open = false" 
                    class="absolute -top-4 -right-4 w-12 h-12 bg-white rounded-full text-gray-800 hover:bg-gray-100 transition-colors shadow-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection
