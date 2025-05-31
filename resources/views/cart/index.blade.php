<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ваша корзина') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    @if(empty($cartItems))
                        <p class="text-center text-lg text-gray-600">Ваша корзина пуста.</p>
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Перейти к покупкам') }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg shadow-md mb-8">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Товар
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Цена
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Количество
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Сумма
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Действия
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $totalPrice = 0; @endphp
                                    @foreach ($cartItems as $item)
                                        @php
                                            $product = $item['product'];
                                            $quantity = $item['quantity'];
                                            $itemTotal = $product->price * $quantity;
                                            $totalPrice += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    @if ($product->image_url)
                                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover mr-4 shadow-sm">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-xs mr-4">
                                                            Нет фото
                                                        </div>
                                                    @endif
                                                    {{ $product->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($product->price, 2, ',', ' ') }} ₽
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($itemTotal, 2, ',', ' ') }} ₽
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 focus:outline-none font-semibold">
                                                        Удалить 1 шт.
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-4 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <h3 class="text-xl font-bold text-gray-800">Общая стоимость: {{ number_format($totalPrice, 2, ',', ' ') }} ₽</h3>
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto" onclick="return confirm('Вы уверены, что хотите очистить корзину?');">
                                        Очистить корзину
                                    </button>
                                </form>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto">
                                    Продолжить покупки
                                </a>
                                {{-- Кнопка оформления заказа, вызывающая модальное окно --}}
                                <button type="button" id="openPaymentModalButton" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto">
    Оформить заказ
</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

   {{-- Модальное окно --}}
    <div id="paymentModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-8 max-w-sm w-full relative">
            <button onclick="window.closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">
                &times;
            </button>
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Уведомление</h3>
            <p class="text-gray-700 text-lg text-center mb-6">На данный момент невозможно оплатить заказы.</p>
            <div class="flex justify-center">
                <button onclick="window.closeModal()" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Понятно
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Make functions globally accessible
        window.openModal = function() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        window.closeModal = function() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        // Закрытие модального окна по клику вне его
        // Используем window.closeModal при вызове
        document.getElementById('paymentModal').addEventListener('click', function(event) {
            if (event.target === this) {
                window.closeModal();
            }
        });
    </script>
    @endpush
</x-app-layout>