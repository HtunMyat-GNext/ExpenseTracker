<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 w-full z-10">
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
                <!-- Start Language switch -->
                <x-language />
                <!-- End Language switch -->
                <x-profile />
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
                <x-profile />
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
