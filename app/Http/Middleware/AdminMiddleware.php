<?php

namespace App\Http\Middleware; // <-- ЭТО ОЧЕНЬ ВАЖНО, ДОЛЖНО БЫТЬ ИМЕННО ТАК

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Эта строка тоже важна

class AdminMiddleware // <-- ИМЯ КЛАССА ДОЛЖНО БЫТЬ AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        return redirect('/');
    }
}