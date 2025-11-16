@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="py-12">

<div class="bg-gradient-to-br from-orange-600 via-red-600 to-pink-600 relative overflow-hidden">    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">            

        <div class="text-center">            <h2 class="text-2xl font-bold mb-6">Destination Highlight</h2>

            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">

                <span class="text-white font-medium text-sm md:text-base">✨ {{ __('messages.destination_highlights') }}</span>            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            </div>                

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.destination_highlights') }}</h1>                @forelse($activities as $activity)

            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('Featured activities & attractions') }}</p>                    <div class="rounded-lg overflow-hidden shadow">

        </div>                        

    </div>                        <img src="{{ asset($activity->photo) }}" alt="{{ $activity->name }}" class="w-full h-48 object-cover">

</div>                        

                        <div class="p-4">

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">                            <h3 class="text-lg font-semibold">{{ $activity->name }}</h3>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                            <p class="text-gray-500">{{ $activity->location }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">                            <p class="text-gray-500 text-sm">{{ $activity->time }}</p>

            @forelse($activities as $activity)                        </div>

            <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">                    </div>

                <div class="relative h-56 overflow-hidden">                @empty

                    <img src="{{ asset($activity->photo) }}" alt="{{ $activity->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">                    <p>No tour activities found.</p>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>                @endforelse

                    <div class="absolute bottom-4 left-4 right-4">            </div>

                        <div class="flex items-center text-white/90 text-xs md:text-sm mb-2">

                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">            <div class="mt-6">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>                {{ $activities->links() }}

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>            </div>

                            </svg>

                            {{ $activity->location }}        </div>

                        </div>    </div>

                    </div></div>

                </div>@endsection
                
                <div class="p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">{{ $activity->name }}</h3>
                    
                    <div class="flex items-center text-gray-500 text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $activity->time }}</span>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="#" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold text-sm md:text-base transition-colors">
                            {{ __('messages.learn_more') }}
                            <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="inline-block p-6 bg-gray-50 rounded-2xl">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                    </svg>
                    <p class="text-sm md:text-base text-gray-500">No tour activities found.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-8 md:mt-12">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
