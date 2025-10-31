<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/logo-paradise.jpg') }}" alt="Paradise Of Indonesia" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('destinations.index')" :active="request()->routeIs('destinations.*')">
                        {{ __('Destinations') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tour-activities.index')" :active="request()->routeIs('tour-activities.*')">
                        {{ __('Dest. Highlight') }}
                    </x-nav-link>
                    <x-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.*')">
                        {{ __('Gallery') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tour-packages.index')" :active="request()->routeIs('tour-packages.*')">
                        {{ __('Tour Packages') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tour-sessions.index')" :active="request()->routeIs('tour-sessions.*')">
                        {{ __('Tour Sessions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('travel-services.index')" :active="request()->routeIs('travel-services.*')">
                        {{ __('Travel Services') }}
                    </x-nav-link>
                </div>
                <!-- Search Bar -->
                <!-- <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <form action="{{ route('search') }}" method="GET" class="flex items-center">
                        <input type="text" name="query" placeholder="Search..." class="rounded-l-md border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                        <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-r-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div> -->
            </div>

            <!-- Cart and User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- <a href="#" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="ml-1">Cart (0)</span>
                </a> -->

                @guest
                    <a href="{{ route('login', ['return_to' => url()->current()]) }}" class="inline-flex items-center px-4 py-2 border-2 border-emerald-500 text-sm font-medium rounded-md text-emerald-500 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out mr-3">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 border border-transparent text-sm font-medium rounded-md text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        {{ __('Register') }}
                    </a>
                @else
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('my-bookings')">
                            {{ __('My Bookings') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('destinations.index')" :active="request()->routeIs('destinations.*')">
                {{ __('Destinations') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tour-activities.index')" :active="request()->routeIs('tour-activities.*')">
                {{ __('Dest. Highlight') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.*')">
                {{ __('Gallery') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tour-packages.index')" :active="request()->routeIs('tour-packages.*')">
                {{ __('Tour Packages') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tour-sessions.index')" :active="request()->routeIs('tour-sessions.*')">
                {{ __('Tour Sessions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('travel-services.index')" :active="request()->routeIs('travel-services.*')">
                {{ __('Travel Services') }}
            </x-responsive-nav-link>
        </div>
        <!-- Mobile Search Bar -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <form action="{{ route('search') }}" method="GET" class="px-4">
                <div class="flex items-center">
                    <input type="text" name="query" placeholder="Search..." class="w-full rounded-l-md border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-r-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('my-bookings')">
                    {{ __('My Bookings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
        @guest
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 py-2 space-y-3">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border-2 border-emerald-500 text-sm font-medium rounded-md text-emerald-500 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-emerald-500 border border-transparent text-sm font-medium rounded-md text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('Register') }}
                </a>
            </div>
        </div>
        @endguest
    </div>
</nav>
