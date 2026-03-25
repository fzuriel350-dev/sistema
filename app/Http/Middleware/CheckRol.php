<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRol
{
    /**
     * Maneja la solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $rol  Rol requerido (ej: 'admin')
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        // 1. Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Verificar si el rol del usuario coincide con el requerido
        if (auth()->user()->rol !== $rol) {
            // Lanza un error 403 si los roles no coinciden
            // Esta es la evidencia clave para tu reporte de la Práctica 6
            abort(403, 'No tienes permiso para acceder a esta sección de administrador.');
        }

        return $next($request);
    }
}