<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Inactividad
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');

            if ($lastActivity && now()->diffInSeconds($lastActivity) > 300) { // 5 minutos
                // Guardar la URL actual antes de cerrar sesión
                Session::put('redirectAfterLogin', url()->current());
                
                Auth::logout();
                Session::flush();

                return redirect()->route('login')->with('error', 'Sesión expirada por inactividad.');
            }

            session(['lastActivityTime' => now()]);
        }

        return $next($request);
    }
}