<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        // Memeriksa apakah pengguna ada dan memiliki peran Admin
        if (!$user || $user->role !== 'Admin') {
            // Jika bukan admin, arahkan ke halaman lain atau tampilkan pesan error
            return redirect('/'); // Ganti dengan route yang sesuai
        }

        return $next($request);
    }
}
