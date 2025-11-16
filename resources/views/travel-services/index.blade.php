@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="py-12">

<div class="bg-gradient-to-br from-amber-600 via-orange-600 to-red-600 relative overflow-hidden">    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">            <div class="p-6 text-gray-900">

        <div class="text-center">

            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">                <h2 class="text-2xl font-bold mb-6">Travel Services - Pilih Unit</h2>

                <span class="text-white font-medium text-sm md:text-base">🚗 {{ __('messages.travel_services') }}</span>

            </div>                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.travel_services') }}</h1>                    @forelse ($services as $service)

            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('Choose your perfect travel companion') }}</p>                        <div class="bg-gray-100 rounded-lg shadow-md">

        </div>                            <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover rounded-t-lg">

    </div>                            <div class="p-4">

</div>                                <span class="inline-block bg-emerald-200 text-emerald-800 text-xs px-2 rounded-full uppercase font-semibold tracking-wide">{{ $service->type }}</span>

                                <h3 class="text-lg font-semibold mt-2">{{ $service->name }}</h3>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">                                <p class="text-gray-600 mt-2">{{ $service->description }}</p>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                                <div class="mt-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">                                    <span class="font-bold text-xl">Rp {{ number_format($service->price, 0, ',', '.') }}</span>

            @forelse ($services as $service)                                    </div>

            <div class="group bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">                                    <div class="mt-4">

                <div class="relative h-56 overflow-hidden">                                        <a href="{{ route('travel-services.booking', $service) }}" class="w-full py-2 bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">

                    <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">                                            Select

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>                                        </a>

                    <div class="absolute top-4 right-4">                                    </div>

                        <span class="inline-block bg-amber-500 text-white text-xs md:text-sm px-4 py-2 rounded-full uppercase font-bold tracking-wide shadow-lg">                                </div>

                            {{ $service->type }}                            </div>

                        </span>                        @empty

                    </div>                            <p>No travel services found.</p>

                </div>                        @endforelse

                                </div>

                <div class="p-4 md:p-6">

                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">{{ $service->name }}</h3>                <div class="mt-6">

                    <p class="text-sm md:text-base text-gray-600 leading-relaxed line-clamp-2 mb-4">{{ $service->description }}</p>                    {{ $services->links() }}

                                    </div>

                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100">            </div>

                        <div>        </div>

                            <span class="text-xs md:text-sm text-gray-500 block">{{ __('messages.starting_from') }}</span>    </div>

                            <span class="text-xl md:text-2xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent"></div>

                                Rp {{ number_format($service->price, 0, ',', '.') }}@endsection

                            </span>
                        </div>
                        <a href="{{ route('travel-services.booking', $service) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-amber-500/50 transform hover:scale-105 transition-all duration-300">
                            <span class="text-sm md:text-base">{{ __('Select') }}</span>
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    <p class="text-sm md:text-base text-gray-500">No travel services found.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-8 md:mt-12">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
