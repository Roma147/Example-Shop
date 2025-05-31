<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Попытка аутентификации пользователя

        $request->session()->regenerate(); // Пересоздание ID сессии для безопасности

        // **ИЗМЕНЁННАЯ ЛОГИКА ПЕРЕНАПРАВЛЕНИЯ**
        // Проверяем, является ли текущий авторизованный пользователь админом
        if (Auth::user()->is_admin) {
            // Если да, перенаправляем его на админскую панель
            // Убедитесь, что маршрут 'admin.dashboard' существует и корректен
            return redirect()->intended('/admin');
        }

        // Если пользователь НЕ админ, перенаправляем его на страницу товаров
        // Убедитесь, что маршрут 'products.index' существует и корректен
        return redirect()->intended('/products');
        // **КОНЕЦ ИЗМЕНЁННОЙ ЛОГИКИ**
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}