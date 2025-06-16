<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Проверка, является ли пользователь администратором
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        return redirect('home')->with('error', 'Доступ запрещен');
    }
}