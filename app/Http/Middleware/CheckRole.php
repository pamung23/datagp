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
    public function handle(Request $request, Closure $next, $level)
    {
        $user = Auth::user();

        // Jika pengguna tidak login atau tidak memiliki level yang sesuai
        if (!$user || !$this->hasLevel($user, $level)) {
            // Simpan pesan error flash dan arahkan kembali ke dashboard
            Session::flash('error', 'Anda tidak memiliki izin untuk mengakses halaman Tersebut.');
            return redirect()->back();
        }

        return $next($request);
    }

    /**
     * Check if the user has a specific level.
     *
     * @param \App\Models\User $user
     * @param string $level
     * @return bool
     */
    private function hasLevel($user, $level)
    {
        // Jika level pengguna sesuai dengan yang diminta
        return $user->level === $level;
    }
}
