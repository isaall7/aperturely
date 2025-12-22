<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // jika belum login
        if (!Auth::check()) {
            return redirect('/login');
        }

        if ($request->routeIs('')&&Auth::user()->role !== 'admin' ) {
            abort(403, 'Tidak memiliki akses ke halaman ini');
        }
        return $next($request);
    }
}
