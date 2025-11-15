<nav x-data="{ open: false, megaMenu: null, languageOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'bg-white backdrop-blur-md h-20' : 'bg-white shadow-sm h-18'"
     class="fixed top-0 left-0 w-full border-b border-gray-100 transition-all duration-300 z-50"
     role="navigation"
     aria-label="Main navigation">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" aria-label="Paradise Of Indonesia - Home">
                        <img src="{{ asset('images/logo-paradise.jpg') }}" 
                             alt="Paradise Of Indonesia Logo" 
                             class="h-10 w-auto"
                             loading="eager">
                    </a>
                </div>

                <!-- Navigation Links with Mega Menu -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('messages.home') }}
                    </x-nav-link>

                    <!-- Explore Mega Menu -->
                    <div class="relative" 
                         @mouseenter="megaMenu = 'explore'" 
                         @mouseleave="megaMenu = null">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-emerald-600 focus:outline-none transition ease-in-out duration-150"
                                :class="{'text-emerald-600': megaMenu === 'explore'}">
                            {{ __('messages.explore') }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Mega Menu Dropdown -->
                        <div x-show="megaMenu === 'explore'" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-2 w-screen max-w-md bg-white rounded-lg shadow-xl z-50">
                            <div class="p-4 grid grid-cols-1 gap-2">
                                <a href="{{ route('destinations.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-emerald-600">{{ __('messages.destinations') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('Explore beautiful places') }}</p>
                                    </div>
                                </a>

                                <a href="{{ route('tour-activities.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-emerald-600">{{ __('messages.destination_highlights') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('Featured activities & attractions') }}</p>
                                    </div>
                                </a>

                                <a href="{{ route('gallery.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-emerald-600">{{ __('messages.gallery') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('Browse amazing photos') }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tours Mega Menu -->
                    <div class="relative" 
                         @mouseenter="megaMenu = 'tours'" 
                         @mouseleave="megaMenu = null">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-emerald-600 focus:outline-none transition ease-in-out duration-150"
                                :class="{'text-emerald-600': megaMenu === 'tours'}">
                            {{ __('messages.tours') }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Mega Menu Dropdown -->
                        <div x-show="megaMenu === 'tours'" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-2 w-screen max-w-md bg-white rounded-lg shadow-xl z-50">
                            <div class="p-4 grid grid-cols-1 gap-2">
                                <a href="{{ route('tour-packages.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-emerald-600">{{ __('messages.tour_packages') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('All-inclusive travel packages') }}</p>
                                    </div>
                                </a>

                                <a href="{{ route('tour-sessions.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-emerald-600">{{ __('messages.tour_sessions') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('Available tour schedules') }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <x-nav-link :href="route('travel-services.index')" :active="request()->routeIs('travel-services.*')">
                        {{ __('messages.travel_services') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Search Bar, Language Switcher & User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="relative" role="search" aria-label="Search tours and destinations">
                    <input type="text" 
                           name="query" 
                           placeholder="{{ __('messages.search_placeholder') }}" 
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                           aria-label="Search query">
                    <button type="submit" 
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-emerald-600"
                            aria-label="Submit search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>

                <!-- Language Switcher -->
                <div class="relative" @click.away="languageOpen = false">
                    <button @click="languageOpen = !languageOpen" 
                            class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:text-emerald-600 rounded-md hover:bg-gray-50 transition"
                            aria-label="Change language"
                            aria-expanded="languageOpen"
                            aria-haspopup="true">
                        @php
                            $currentLang = app()->getLocale();
                            $flags = ['en' => '🇬🇧', 'id' => '🇮🇩', 'zh' => '🇨🇳'];
                            $names = ['en' => 'EN', 'id' => 'ID', 'zh' => '中文'];
                        @endphp
                        <span class="text-xl" aria-hidden="true">{{ $flags[$currentLang] ?? '🇬🇧' }}</span>
                        <span class="font-medium">{{ $names[$currentLang] ?? 'EN' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Language Dropdown -->
                    <div x-show="languageOpen"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
                         role="menu"
                         aria-orientation="vertical"
                         aria-label="Language selection">
                        <form action="{{ route('language.switch') }}" method="POST">
                            @csrf
                            <button type="submit" name="locale" value="en" 
                                    class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 transition {{ app()->getLocale() === 'en' ? 'bg-emerald-50' : '' }}"
                                    role="menuitem"
                                    aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}">
                                <span class="text-2xl" aria-hidden="true">🇬🇧</span>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-900">English</p>
                                    <p class="text-xs text-gray-500">English</p>
                                </div>
                                @if(app()->getLocale() === 'en')
                                <svg class="w-5 h-5 ml-auto text-emerald-600" fill="currentColor" viewBox="0 0 20 20" aria-label="Selected">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </button>

                            <button type="submit" name="locale" value="id" 
                                    class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 transition border-t border-gray-100 {{ app()->getLocale() === 'id' ? 'bg-emerald-50' : '' }}">
                                <span class="text-2xl">🇮🇩</span>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-900">Indonesia</p>
                                    <p class="text-xs text-gray-500">Bahasa Indonesia</p>
                                </div>
                                @if(app()->getLocale() === 'id')
                                <svg class="w-5 h-5 ml-auto text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </button>

                            <button type="submit" name="locale" value="zh" 
                                    class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 transition border-t border-gray-100 {{ app()->getLocale() === 'zh' ? 'bg-emerald-50' : '' }}">
                                <span class="text-2xl">🇨🇳</span>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-900">中文</p>
                                    <p class="text-xs text-gray-500">简体中文</p>
                                </div>
                                @if(app()->getLocale() === 'zh')
                                <svg class="w-5 h-5 ml-auto text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

                @guest
                    <a href="{{ route('login', ['return_to' => url()->current()]) }}" 
                       class="inline-flex items-center px-4 py-2 border-2 border-emerald-500 text-sm font-medium rounded-md text-emerald-500 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        {{ __('messages.login') }}
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-4 py-2 bg-emerald-500 border border-transparent text-sm font-medium rounded-md text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        {{ __('messages.register') }}
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
                            {{ __('messages.my_bookings') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('messages.profile') }}
                        </x-dropdown-link>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="border-t border-gray-100"></div>
                            <x-dropdown-link :href="route('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('admin.tours.index')">
                                {{ __('Admin: Tours') }}
                            </x-dropdown-link>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('messages.logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        aria-label="Toggle navigation menu"
                        aria-expanded="open"
                        aria-controls="mobile-menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1" role="menu">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" role="menuitem">
                {{ __('messages.home') }}
            </x-responsive-nav-link>
            
            <!-- Explore Group -->
            <div class="px-4 py-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.explore') }}</p>
            </div>
            <x-responsive-nav-link :href="route('destinations.index')" :active="request()->routeIs('destinations.*')">
                {{ __('messages.destinations') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tour-activities.index')" :active="request()->routeIs('tour-activities.*')">
                {{ __('messages.destination_highlights') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.*')">
                {{ __('messages.gallery') }}
            </x-responsive-nav-link>
            
            <!-- Tours Group -->
            <div class="px-4 py-2 mt-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.tours') }}</p>
            </div>
            <x-responsive-nav-link :href="route('tour-packages.index')" :active="request()->routeIs('tour-packages.*')">
                {{ __('messages.tour_packages') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tour-sessions.index')" :active="request()->routeIs('tour-sessions.*')">
                {{ __('messages.tour_sessions') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('travel-services.index')" :active="request()->routeIs('travel-services.*')">
                {{ __('messages.travel_services') }}
            </x-responsive-nav-link>
        </div>
        
        <!-- Mobile Search Bar -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <form action="{{ route('search') }}" method="GET" class="px-4">
                <div class="flex items-center">
                    <input type="text" 
                           name="query" 
                           placeholder="{{ __('messages.search_placeholder') }}" 
                           class="w-full rounded-l-md border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-r-md hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Mobile Language Switcher -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="px-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ __('Language') }}</p>
                <form action="{{ route('language.switch') }}" method="POST" class="space-y-2">
                    @csrf
                    @php
                        $languages = [
                            'en' => ['flag' => '🇬🇧', 'name' => 'English', 'native' => 'English'],
                            'id' => ['flag' => '🇮🇩', 'name' => 'Indonesia', 'native' => 'Bahasa Indonesia'],
                            'zh' => ['flag' => '🇨🇳', 'name' => '中文', 'native' => '简体中文'],
                        ];
                    @endphp
                    @foreach($languages as $code => $lang)
                    <button type="submit" name="locale" value="{{ $code }}" 
                            class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-emerald-50 transition {{ app()->getLocale() === $code ? 'bg-emerald-50' : '' }}">
                        <span class="text-xl">{{ $lang['flag'] }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ $lang['name'] }}</span>
                        @if(app()->getLocale() === $code)
                        <svg class="w-4 h-4 ml-auto text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        @endif
                    </button>
                    @endforeach
                </form>
            </div>
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
                    {{ __('messages.my_bookings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('messages.profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('messages.logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
        
        @guest
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 py-2 space-y-3">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border-2 border-emerald-500 text-sm font-medium rounded-md text-emerald-500 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('messages.login') }}
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-emerald-500 border border-transparent text-sm font-medium rounded-md text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('messages.register') }}
                </a>
            </div>
        </div>
        @endguest
    </div>
</nav>