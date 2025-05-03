<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GuardarUltimaPagina
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Guardar la última URL visitada antes de cerrar sesión
            if (!$request->is('login') && !$request->is('logout')) {
                Session::put('redirectAfterLogin', $request->fullUrl());
            }
        }

        return $next($request);
    }
}
