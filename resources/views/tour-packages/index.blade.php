@extends('layouts.app')@extends('layouts.app')@extends('layouts.app')



@section('content')

<!-- Hero Section -->

<div class="bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 relative overflow-hidden">@section('content')@section('content')

    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative"><!-- Hero Section --><div class="py-12">

        <div class="text-center">

            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4"><div class="bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 relative overflow-hidden">    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <span class="text-white font-medium text-sm md:text-base">📦 {{ __('messages.best_packages_label') }}</span>

            </div>    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoLTJWMTRoMnYyMHptMCAxMGgtMlY0Mmgydjl6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.tour_packages') }}</h1>

            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('messages.best_packages_desc') }}</p>    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">            <div class="p-4 md:p-6 text-gray-900">

        </div>

    </div>        <div class="text-center">

</div>

            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-4">                <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">{{ __('messages.tour_packages') }}</h2>

<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                <span class="text-white font-medium text-sm md:text-base">📦 {{ __('messages.best_packages_label') }}</span>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

            @forelse ($packages as $package)            </div>                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">

            <div class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">

                <div class="relative h-56 overflow-hidden">            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">{{ __('messages.tour_packages') }}</h1>                    @forelse ($packages as $package)

                    <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">{{ __('messages.best_packages_desc') }}</p>    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">

                    <div class="absolute top-4 right-4 bg-emerald-500 text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg">

                        {{ __('messages.best_seller') }}        </div>        <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-40 md:h-48 object-cover">

                    </div>

                </div>    </div>        

                

                <div class="p-4 md:p-6"></div>        <div class="p-3 md:p-4">

                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">{{ $package->name }}</h3>

                    <p class="text-sm md:text-base text-gray-600 leading-relaxed line-clamp-2">{{ $package->description }}</p>            <h3 class="text-base md:text-lg font-semibold">{{ $package->name }}</h3>

                    

                    @if($package->includes_guide || $package->includes_transport)<div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white">            <p class="text-sm md:text-base text-gray-600 mt-2 line-clamp-2">{{ $package->description }}</p>

                        <div class="mt-3 flex flex-wrap gap-2">

                            @if($package->includes_guide)    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">            

                                <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">

                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">            <!-- Price -->

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>

                                    </svg>            @forelse ($packages as $package)            <div class="mt-3 md:mt-4">

                                    {{ __('messages.tour_guide') }}

                                </span>            <div class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">                <span class="font-bold text-lg md:text-xl text-emerald-600">{{ format_price(get_price($package)) }}</span>

                            @endif

                            @if($package->includes_transport)                <div class="relative h-56 overflow-hidden">            </div>

                                <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-medium">

                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">                    <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">            

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>

                                    </svg>                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>            <!-- Includes -->

                                    {{ __('messages.transport') }}

                                </span>                    <div class="absolute top-4 right-4 bg-emerald-500 text-white px-4 py-2 rounded-full font-bold text-sm shadow-lg">            @if($package->includes_guide || $package->includes_transport)

                            @endif

                        </div>                        {{ __('messages.best_seller') }}                <div class="mt-2 flex flex-wrap gap-2">

                    @endif

                                        </div>                    @if($package->includes_guide)

                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100">

                        <div>                </div>                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">📋 {{ __('messages.tour_guide') }}</span>

                            <span class="text-xs md:text-sm text-gray-500 block">{{ __('messages.starting_from') }}</span>

                            <span class="text-xl md:text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">                                    @endif

                                {{ format_price(get_price($package)) }}

                            </span>                <div class="p-4 md:p-6">                    @if($package->includes_transport)

                        </div>

                        @if($package->tours->isNotEmpty())                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">{{ $package->name }}</h3>                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">🚗 {{ __('messages.transport') }}</span>

                            <a href="{{ route('tour-packages.show', $package->id) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">

                                <span class="text-sm md:text-base">View</span>                    <p class="text-sm md:text-base text-gray-600 leading-relaxed line-clamp-2">{{ $package->description }}</p>                    @endif

                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>                                    </div>

                                </svg>

                            </a>                    <!-- Includes -->            @endif

                        @else

                            <span class="px-5 py-2.5 bg-gray-300 text-gray-600 rounded-full font-semibold text-sm cursor-not-allowed">                    @if($package->includes_guide || $package->includes_transport)            

                                {{ __('messages.sold_out') }}

                            </span>                        <div class="mt-3 flex flex-wrap gap-2">            <!-- Button -->

                        @endif

                    </div>                            @if($package->includes_guide)            <div class="mt-3 md:mt-4">

                </div>

            </div>                                <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">                @if($package->tours->isNotEmpty())

            @empty

            <div class="col-span-full text-center py-12">                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">                    <a href="{{ route('tour-packages.show', $package->id) }}" class="w-full py-2 text-sm md:text-base bg-emerald-600 text-white rounded-md font-semibold text-center block hover:bg-emerald-700 transition">

                <div class="inline-block p-6 bg-gray-50 rounded-2xl">

                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>                        {{ __('messages.view_details') }}

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>

                    </svg>                                    </svg>                    </a>

                    <p class="text-sm md:text-base text-gray-500">{{ __('messages.no_tour_packages') }}</p>

                </div>                                    {{ __('messages.tour_guide') }}                @else

            </div>

            @endforelse                                </span>                    <span class="w-full py-2 text-sm md:text-base bg-gray-400 text-white rounded-md font-semibold text-center block cursor-not-allowed">

        </div>

                            @endif                        {{ __('messages.no_tours_available') }}

        <div class="mt-8 md:mt-12">

            {{ $packages->links() }}                            @if($package->includes_transport)                    </span>

        </div>

    </div>                                <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-medium">                @endif

</div>

@endsection                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">            </div>


                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>        </div>

                                    </svg>    </div>

                                    {{ __('messages.transport') }}@empty

                                </span>    <div class="col-span-full text-center py-12">

                            @endif        <p class="text-sm md:text-base text-gray-500">{{ __('messages.no_tour_packages') }}</p>

                        </div>    </div>

                    @endif@endforelse

                                    </div>

                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100">

                        <div>                <div class="mt-6">

                            <span class="text-xs md:text-sm text-gray-500 block">{{ __('messages.starting_from') }}</span>                    {{ $packages->links() }}

                            <span class="text-xl md:text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">                </div>

                                {{ format_price(get_price($package)) }}            </div>

                            </span>        </div>

                        </div>    </div>

                        @if($package->tours->isNotEmpty())</div>

                            <a href="{{ route('tour-packages.show', $package->id) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-full hover:shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105 transition-all duration-300">@endsection

                                <span class="text-sm md:text-base">View</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="px-5 py-2.5 bg-gray-300 text-gray-600 rounded-full font-semibold text-sm cursor-not-allowed">
                                {{ __('messages.sold_out') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="inline-block p-6 bg-gray-50 rounded-2xl">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-sm md:text-base text-gray-500">{{ __('messages.no_tour_packages') }}</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-8 md:mt-12">
            {{ $packages->links() }}
        </div>
    </div>
</div>
@endsection
