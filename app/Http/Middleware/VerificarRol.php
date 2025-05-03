<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerificarRol
{
    /**
     * Manejar una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Verificar si el rol del usuario está entre los permitidos
        // Asumiendo que $user->rol->name retorna el nombre del rol del usuario
        if (!in_array($user->rol->nombre_r, $roles)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
