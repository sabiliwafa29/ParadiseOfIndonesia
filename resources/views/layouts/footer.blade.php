<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About Section -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">{{ config('app.name') }}</h3>
                <p class="text-gray-400">{{ __('messages.about_paradise') }}</p>
            </div>

            <!-- Quick Links -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">{{ __('messages.quick_links') }}</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('destinations.index') }}" class="text-gray-400 hover:text-white">{{ __('messages.destinations') }}</a></li>
                    <li><a href="{{ route('tours.index') }}" class="text-gray-400 hover:text-white">{{ __('messages.tours') }}</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">{{ __('messages.about_us') }}</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">{{ __('messages.contact') }}</a></li>
                </ul>
            </div>

            <!-- Popular Destinations -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">{{ __('messages.popular_destinations') }}</h3>
<ul class="space-y-2">
    <li><a href="#" class="text-gray-400 hover:text-white">{{ __('messages.bali') }}</a></li>
    <li><a href="#" class="text-gray-400 hover:text-white">{{ __('messages.raja_ampat') }}</a></li>
    <li><a href="#" class="text-gray-400 hover:text-white">{{ __('messages.yogyakarta') }}</a></li>
    <li><a href="#" class="text-gray-400 hover:text-white">{{ __('messages.komodo_island') }}</a></li>
</ul>
            </div>

            <!-- Contact Info -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">{{ __('messages.contact_us') }}</h3>
<ul class="space-y-2">
    <li class="text-gray-400"><i class="fas fa-phone mr-2"></i> WhatsApp +62 8158 5333 325</li>
    <li class="text-gray-400"><i class="fas fa-envelope mr-2"></i> cs@paradiseofindonesia.com</li>
    <li class="text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i> {{ __('messages.address') }}: {{ __('messages.address_detail') }}</li>
</ul>

                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-gray-800 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Paradise Of Indonesia {{ __('messages.by_company') }}. {{ __('messages.all_rights_reserved') }}.</p>
        </div>
    </div>
</footer>