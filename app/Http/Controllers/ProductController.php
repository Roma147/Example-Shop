<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        // Фильтрация по категории
        if ($request->filled('category')) { // Используем filled() для проверки наличия и непустоты
            $query->where('category', $request->input('category'));
        }

        // Поиск по названию или описанию (делаем его регистронезависимым)
        if ($request->filled('search')) { // Используем filled()
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                // Используем ILIKE для регистронезависимого поиска в PostgreSQL
                // Для MySQL/SQLite просто LIKE работает регистронезависимо по умолчанию,
                // но можно использовать LOWER() для явной регистронезависимости.
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $products = $query->where('stock_quantity', '>', 0)->get(); // Отображаем только те, что в наличии
        $categories = Product::getUniqueCategories(); // Получаем категории для фильтра

        return view('products.user-index', compact('products', 'categories'));
    }

    // ... (остальные методы ProductController, такие как viewCart, addToCart, removeFromCart, clearCart)

    /**
     * Показать содержимое корзины.
     */
    public function viewCart(Request $request): View
    {
        $cartItems = $request->session()->get('cart', []);
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Добавить товар в корзину.
     */
    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            // Проверяем, чтобы не добавить больше, чем есть на складе
            if ($cart[$product->id]['quantity'] < $product->stock_quantity) {
                $cart[$product->id]['quantity']++;
                $request->session()->put('cart', $cart);
                return redirect()->back()->with('success', $product->name . ' добавлен в корзину.');
            } else {
                return redirect()->back()->with('error', 'Недостаточно ' . $product->name . ' на складе.');
            }
        } else {
            if ($product->stock_quantity > 0) {
                $cart[$product->id] = [
                    "product" => $product,
                    "quantity" => 1
                ];
                $request->session()->put('cart', $cart);
                return redirect()->back()->with('success', $product->name . ' добавлен в корзину.');
            } else {
                return redirect()->back()->with('error', 'Товара ' . $product->name . ' нет в наличии.');
            }
        }
    }

    /**
     * Удалить товар из корзины.
     */
    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] > 1) {
                $cart[$product->id]['quantity']--;
                $request->session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Одна единица ' . $product->name . ' удалена из корзины.');
            } else {
                unset($cart[$product->id]);
                $request->session()->put('cart', $cart);
                return redirect()->back()->with('success', $product->name . ' удален из корзины.');
            }
        }

        return redirect()->back()->with('error', 'Товар не найден в корзине.');
    }

    /**
     * Очистить корзину.
     */
    public function clearCart(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        return redirect()->back()->with('success', 'Корзина очищена.');
    }
}