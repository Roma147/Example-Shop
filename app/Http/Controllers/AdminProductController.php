<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminProductController extends Controller
{
    /**
     * Показать список всех товаров для администраторов.
     */
    public function index(): View
    {
        $products = Product::all();
        // ИЗМЕНЕНО: теперь view('products.index') вместо view('admin.products.index')
        return view('products.index', compact('products'));
    }

    /**
     * Показать форму для создания нового товара.
     */
    public function create(): View
    {
        // ИЗМЕНЕНО: теперь view('products.create') вместо view('admin.products.create')
        return view('products.create');
    }

    /**
     * Сохранить новый товар в базе данных.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен!');
    }

    /**
     * Показать форму для редактирования существующего товара.
     */
    public function edit(Product $product): View
    {
        // ИЗМЕНЕНО: теперь view('products.edit') вместо view('admin.products.edit')
        return view('products.edit', compact('product'));
    }

    /**
     * Обновить товар в базе данных.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image_url' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно обновлен!');
    }

    /**
     * Удалить товар из базы данных.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно удален!');
    }
}