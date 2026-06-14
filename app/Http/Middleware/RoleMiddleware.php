<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: middleware('role:admin')  atau  middleware('role:pengguna')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            // Jika pengguna biasa coba akses admin, lempar ke home
            if ($user->role !== 'admin') {
                abort(403, 'Akses ditolak.');
            }
            // Jika admin coba akses halaman pengguna, redirect ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
