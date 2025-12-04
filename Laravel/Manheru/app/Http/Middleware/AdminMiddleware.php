<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        // Verificar si el usuario es administrador (ID_Rol = 1 según tu seeder)
        if (Auth::user()->ID_Rol != 1) {
            return redirect()->route('inicio')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}