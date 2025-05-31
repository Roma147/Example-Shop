<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index') || request()->routeIs('home')">
                        {{ __('Все товары') }}
                    </x-nav-link>

                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.183 1.71.707 1.71H17m0 0A2 2 0 1021 17a2 2 0 00-4 0m0 0h1.022c.068.004.128.02.19.04M5.4 5H9m1.022 13.04H17m0 0a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('Корзина') }}
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="ml-1 px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full">
                                {{ array_sum(array_column(session('cart'), 'quantity')) }}
                            </span>
                        @endif
                    </x-nav-link>

                    @auth
                        @if (Auth::user()->is_admin)
                            {{-- ССЫЛКА "Админ-панель" УДАЛЕНА ЗДЕСЬ ИЗ-ЗА УДАЛЕНИЯ admin.blade.php --}}

                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit')">
                                {{ __('Управление товарами') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.products.create')" :active="request()->routeIs('admin.products.create')">
                                {{ __('Создать товар') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
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
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Auth::user()->is_admin)
                                {{-- ССЫЛКА "Админ-панель" УДАЛЕНА ЗДЕСЬ ИЗ-ЗА УДАЛЕНИЯ admin.blade.php --}}

                                <x-dropdown-link :href="route('admin.products.index')">
                                    {{ __('Управление товарами') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.products.create')">
                                    {{ __('Создать товар') }}
                                </x-dropdown-link>
                            @endif

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
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Войти') }}
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Регистрация') }}
                        </a>
                    </div>
                @endauth
            </div>

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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index') || request()->routeIs('home')">
                {{ __('Все товары') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.183 1.71.707 1.71H17m0 0A2 2 0 1021 17a2 2 0 00-4 0m0 0h1.022c.068.004.128.02.19.04M5.4 5H9m1.022 13.04H17m0 0a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ __('Корзина') }}
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="ml-1 px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full">
                        {{ array_sum(array_column(session('cart'), 'quantity')) }}
                    </span>
                @endif
            </x-responsive-nav-link>

            @auth
                @if (Auth::user()->is_admin)
                    {{-- ССЫЛКА "Админ-панель" УДАЛЕНА ЗДЕСЬ ИЗ-ЗА УДАЛЕНИЯ admin.blade.php --}}

                    <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit')">
                        {{ __('Управление товарами') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.products.create')" :active="request()->routeIs('admin.products.create')">
                        {{ __('Создать товар') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Auth::user()->is_admin)
                        {{-- ССЫЛКА "Админ-панель" УДАЛЕНА ЗДЕСЬ ИЗ-ЗА УДАЛЕНИЯ admin.blade.php --}}

                        <x-responsive-nav-link :href="route('admin.products.index')">
                            {{ __('Управление товарами') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.products.create')">
                            {{ __('Создать товар') }}
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Войти') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Регистрация') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>