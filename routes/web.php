<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Public Routes (Маршруты для всех пользователей, даже неавторизованных)
|--------------------------------------------------------------------------
*/

// Главная страница - отображает все товары для всех пользователей
Route::get('/', [ProductController::class, 'index'])->name('home');

// Страница со всеми товарами (можно использовать как альтернативу главной)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Маршруты для корзины
Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.index');
Route::delete('/cart/remove/{product}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Маршруты для авторизованных пользователей)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Профиль пользователя
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Маршрут /dashboard был удален ранее
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Маршруты для администраторов)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    // Теперь /admin будет вести на страницу со всеми товарами (public index)
    // Эта страница будет "точкой входа" для админа, но показывать она будет общие товары.
    Route::get('/admin', [ProductController::class, 'index'])->name('admin.dashboard');

    // Маршруты для управления товарами в админ-панели (доступны только админам)
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
});

// Маршруты аутентификации (вход, регистрация, выход и т.д.)
require __DIR__.'/auth.php';