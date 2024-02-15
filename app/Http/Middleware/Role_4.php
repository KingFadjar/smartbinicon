<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role_4
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //if (Auth::check() && Auth::user()->role_id == 4 or ) {
        if (Auth::user()->role_id == 4 or Auth::user()->role_id == 2) {
            return $next($request);
        }

        return redirect('login')->with('error', 'Anda harus menjadi sales enterprise untuk mengakses halaman ini.');
    }
}
