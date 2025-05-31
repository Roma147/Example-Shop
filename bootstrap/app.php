<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


const HOME = '/dashboard'; // Для обычных пользователей
const ADMIN_HOME = '/admin/dashboard'; // Для админов

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // **ВОТ СЮДА НУЖНО ДОБАВИТЬ РЕГИСТРАЦИЮ MIDDLEWARE**
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Если у вас уже есть какие-то другие псевдонимы middleware,
        // они должны быть здесь, например:
        // 'auth' => \App\Http\Middleware\Authenticate::class,
        // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // и т.д.
        // Ваш 'admin' должен быть добавлен к ним.

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();