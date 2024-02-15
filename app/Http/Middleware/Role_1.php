<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role_1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        return redirect('login')->with('error', 'Anda harus menjadi superuser untuk mengakses halaman ini.');
    }
}
