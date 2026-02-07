<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
{
    // Cek apakah user sudah login dan punya role yang sesuai
    if (!Auth::check() || Auth::user()->role !== $role) {
        // Jika tidak sesuai, lempar balik ke dashboard masing-masing atau login
        return redirect()->route('dashboard')->with('error', 'Kamu tidak punya akses ke sini!');
    }

    return $next($request);
}
}
