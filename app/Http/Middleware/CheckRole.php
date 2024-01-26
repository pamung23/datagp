<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {
        $user = Auth::user();

        // Jika pengguna tidak login atau tidak memiliki level yang sesuai
        if (!$user || !$this->hasLevel($user, $levels)) {
            // Simpan pesan error flash dan arahkan kembali ke dashboard
            Session::flash('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            return redirect()->back();
        }

        return $next($request);
    }

    private function hasLevel($user, $allowedLevels)
    {
        // Jika setidaknya satu dari roles yang diizinkan sesuai dengan role pengguna
        return count(array_intersect(explode(',', $user->level), $allowedLevels)) > 0;
    }
}
