<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AutenticarUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $necesitaLogin=0): Response
    {
        $necesitaLogin = (int) $necesitaLogin; // Convertir a entero
        $sessionLifetime = 300; // Tiempo máximo de inactividad en segundos (5 minutos)

        if ($necesitaLogin) {
            if (!Auth::check()) {
                return Redirect::route('login')->withErrors(['error' => 'Sesión expirada. Inicie sesión de nuevo.']);
            }

            // Verificar el tiempo de inactividad
            $lastActivity = session('lastActivityTime', now());
            if (now()->diffInSeconds($lastActivity) > $sessionLifetime) {
                Auth::logout(); // Cierra la sesión
                $request->session()->invalidate(); // Invalida la sesión
                $request->session()->regenerateToken(); // Regenera el token CSRF

                return Redirect::route('login')->withErrors(['error' => 'Tu sesión ha expirado por inactividad.']);
            }

            // Actualizar el tiempo de la última actividad
            session(['lastActivityTime' => now()]);
        }

        return $next($request);
    }
}
