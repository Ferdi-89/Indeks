<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak berhak, arahkan ke dashboard masing-masing sesuai role
        if ($user->role === 'admin') {
            return redirect('/admin');
        } elseif ($user->role === 'teknisi') {
            return redirect('/teknisi');
        } else {
            return redirect('/cek-status');
        }
    }
}
