<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('logo/logo.png') }}" alt=""
                            class="block h-14 w-auto rounded hidden sm:block">
                        <span class="block sm:hidden text-lg font-semibold dark:text-white">Expense Tracker</span>
                        {{-- <img src="{{ asset('logo/logo.png') }}" alt="" class="block h-14 w-auto rounded"> --}}
                        <!-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" /> -->
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                        {{ __('Expense') }}
                    </x-nav-link>
                    <x-nav-link :href="route('income.index')" :active="request()->routeIs('income.*')">
                        {{ __('Income') }}
                    </x-nav-link>
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        {{ __('Category') }}</x-nav-link>
                    <x-nav-link :href="route('currency.exchange')" :active="request()->routeIs('currency.exchange')">
                        {{ __('Currency Exchange') }}</x-nav-link>
                    <x-nav-link :href="route('calendar')" :active="request()->routeIs('calendar')">
                        {{ __('Calendar') }}
                    </x-nav-link>

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Start dark mode -->
                <x-darkmode />
                <!-- End dark mode -->
                <!-- Start Notification icon -->
                <x-notification />
                <!-- End Notification icon -->
                <!-- Chat Notification Area -->
                <x-chat />
                <!-- Chat Notification Area -->
                <div x-data="{ open: false }" @keydown.escape="open = false" class="relative">
                    <button @click="open = !open" class="px-4 py-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" role="img"
                            xmlns="http://www.w3.org/2000/svg" aria-labelledby="languageIconTitle"
                            :stroke="darkMode ? '#ffffff' : '#000000'" stroke-width="1" stroke-linecap="square"
                            stroke-linejoin="miter" fill="none" :color="darkMode ? '#ffffff' : '#000000'">
                            <title id="languageIconTitle">Language</title>
                            <circle cx="12" cy="12" r="10" />
                            <path stroke-linecap="round"
                                d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z" />
                            <path stroke-linecap="round" d="M2.5 9L21.5 9M2.5 15L21.5 15" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-30 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10">
                        <a href="{{ route('language.switch', ['locale' => 'en']) }}"
                            class="block px-4 py-2 hover:bg-gray-100 text-sm font-md"> <img
                                src="{{ asset('logo/en.png') }}" alt=""></a>
                        <a href="{{ route('language.switch', ['locale' => 'ja']) }}"
                            class="block px-4 py-2 hover:bg-gray-100 text-sm font-md"> <img
                                src="{{ asset('logo/jp.png') }}" alt=""></a>
                        <!-- Add more language options as needed -->
                    </div>
                </div>
                <!-- Start Language switch -->
                <x-language />
                <!-- End Language switch -->
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <!-- dark mode in mobile !-->
                <x-darkmode />
                <!-- dark mode in mobile !-->
                {{-- <x-notification></x-notification>
                <x-chat></x-chat> --}}
                <!-- switch language in moble ! -->
                <x-language />
                <!-- switch language in moble ! -->
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                {{ __('Expense') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('income.index')" :active="request()->routeIs('income.*')">
                {{ __('Income') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Category') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('currency.exchange')" :active="request()->routeIs('currency.exchange')">
                {{ __('Currency Exchange') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendar')" :active="request()->routeIs('calendar')">
                {{ __('Calendar') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
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
    </div>
</nav>
