<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class RedirectIfNotAdmin
{
    // public function handle($request, Closure $next)
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('admin.login')->withErrors(['error' => 'Access denied. You must log in to continue.']);
    //     }

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Akses Ditolak. Harap Login Terlebih Dahulu.']);
        }

        $user = Auth::user();

        if ($user->role !== 'admin' && $user->role !== 'global_admin') {
            abort(403);
        }

        return $next($request);
    }
}
