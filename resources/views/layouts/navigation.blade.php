<nav data-nav
	class="fixed top-0 left-0 w-full bg-white border-b border-gray-100 shadow-sm h-20 transition-all duration-300 z-50"
     role="navigation"
     aria-label="Main navigation">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo & Accreditation -->
                <div class="shrink-0 flex items-center space-x-3">
                    <a href="{{ route('home') }}" aria-label="PNB Travel - Home">
                         <img src="{{ asset('logo-pnbtravel.jpeg') }}" 
                              alt="PNB Travel Logo" 
                              class="h-10 w-auto rounded-md"
                              loading="eager">
                    </a>
                    <div class="hidden lg:flex items-center space-x-2 px-3 py-1 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-full shadow-2xs transition hover:border-emerald-300" title="Official ASITA Member (Association of The Indonesian Tours and Travel Agencies)">
                        <div class="bg-white p-0.5 rounded-full shadow-2xs flex items-center justify-center">
                            <img src="{{ asset('images/logo-ASITA.png') }}" alt="ASITA Logo" class="h-5 w-auto object-contain">
                        </div>
                        <span class="text-xs font-bold text-emerald-950 tracking-tight">ASITA Member</span>
                    </div>
                </div>

                <!-- Navigation Links with Mega Menu -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('messages.home') }}
                    </x-nav-link>

                    <!-- Explore Mega Menu -->
                    <div class="relative nav-mega" data-mega="explore">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-emerald-600 focus:outline-none transition ease-in-out duration-150 nav-mega-toggle"
                                data-mega-toggle="explore"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-label="Explore menu">
                            {{ __('messages.explore') }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Mega Menu Dropdown -->
                        <div class="absolute left-0 mt-2 w-screen max-w-md bg-white rounded-lg shadow-xl z-50 hidden nav-mega-panel"
                             data-mega-panel="explore"
                             role="menu"
                             aria-label="Explore destinations and activities">
                            <div class="p-4 grid grid-cols-1 gap-2">
                                <a href="{{ route('destinations.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group"
                                   role="menuitem">
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
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group"
                                   role="menuitem">
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
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group"
                                   role="menuitem">
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
                    <div class="relative nav-mega" data-mega="tours">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-emerald-600 focus:outline-none transition ease-in-out duration-150 nav-mega-toggle"
                                data-mega-toggle="tours"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-label="Tours menu">
                            {{ __('messages.tours') }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Mega Menu Dropdown -->
                        <div class="absolute left-0 mt-2 w-screen max-w-md bg-white rounded-lg shadow-xl z-50 hidden nav-mega-panel"
                             data-mega-panel="tours"
                             role="menu"
                             aria-label="Tour packages and sessions">
                            <div class="p-4 grid grid-cols-1 gap-2">
                                <a href="{{ route('tour-packages.index') }}" 
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group"
                                   role="menuitem">
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
                                   class="flex items-center p-3 rounded-lg hover:bg-emerald-50 transition group"
                                   role="menuitem">
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
                <div class="relative nav-lang" data-lang>
                    <button class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:text-emerald-600 rounded-md hover:bg-gray-50 transition nav-lang-toggle"
                            data-lang-toggle
                            aria-label="Change language"
                            aria-expanded="false"
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
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 hidden nav-lang-panel"
                         data-lang-panel
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
                <div class="relative" data-user-dropdown>
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            data-user-toggle
                            aria-haspopup="true"
                            aria-expanded="false">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-40 hidden" data-user-menu role="menu" aria-orientation="vertical">
                        <a href="{{ route('my-bookings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            {{ __('messages.my_bookings') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            {{ __('messages.profile') }}
                        </a>
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                {{ __('Admin Dashboard') }}
                            </a>
                            <a href="{{ route('admin.tours.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                {{ __('Admin: Tours') }}
                            </a>
                        @endif
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                {{ __('messages.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    data-nav-toggle
                    aria-label="Toggle navigation menu"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            class="icon-menu inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            class="icon-close hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div class="hidden sm:hidden fixed inset-0 z-40 bg-white/95 backdrop-blur-md overflow-y-auto" id="mobile-menu" data-nav-mobile>
        <div class="pt-20 pb-6 border-b border-gray-200 bg-white/95">
            <div class="px-4 pb-3 space-y-1" role="menu">
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
        </div>
        
        <!-- Mobile Search Bar -->
        <div class="pt-4 pb-3 border-b border-gray-200 bg-white/95">
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
    <div class="pt-4 pb-3 border-b border-gray-200 bg-white/95">
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
    <div class="pt-4 pb-1 border-b border-gray-200 bg-white/95">
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
    <div class="pt-4 pb-1 bg-white/95">
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