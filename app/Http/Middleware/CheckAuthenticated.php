<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah terautentikasi
        if (Auth::guard('api')->check()) {
            return $next($request); // Jika autentikasi berhasil, lanjutkan permintaan
        }

        // Jika tidak terautentikasi, kirimkan respons JSON
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
