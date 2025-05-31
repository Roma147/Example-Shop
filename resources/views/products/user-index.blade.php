<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Все товары') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Приветственное сообщение --}}
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-lg shadow-lg mb-8">
                <h3 class="text-3xl font-bold mb-2">Добро пожаловать в наш магазин!</h3>
                <p class="text-lg">Откройте для себя широкий ассортимент качественных товаров по привлекательным ценам. Приятных покупок!</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Форма фильтров и поиска --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
                    <div class="w-full sm:w-1/3">
                        <label for="category" class="block text-sm font-medium text-gray-700 sr-only">Фильтр по категории</label>
                        <select name="category" id="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                            <option value="">Все категории</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @if(request('category') == $category) selected @endif>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-1/3">
                        <label for="search" class="block text-sm font-medium text-gray-700 sr-only">Поиск</label>
                        <input type="text" name="search" id="search" placeholder="Поиск по названию или описанию..."
                               value="{{ request('search') }}"
                               class="mt-1 block w-full pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
                    </div>
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto">
                            {{ __('Применить') }}
                        </button>
                        @if(request('category') || request('search'))
                            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto">
                                {{ __('Сбросить') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($products->isEmpty())
                <p class="text-center text-lg text-gray-600">Нет товаров, соответствующих вашему запросу.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                            <div class="relative w-full h-48 sm:h-56 lg:h-64 overflow-hidden bg-gray-100"> {{-- Добавлен bg-gray-100 --}}
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain object-center p-2"> {{-- Изменено на object-contain и добавлен p-2 --}}
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                        Нет изображения
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex-grow flex flex-col">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    {{ $product->description ?? 'Описание отсутствует.' }}
                                </p>
                                <div class="mt-auto flex justify-between items-center pt-3 border-t border-gray-100">
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ number_format($product->price, 2, ',', ' ') }} ₽
                                    </span>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('В корзину') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>