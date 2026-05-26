<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Solo usuario con ID 1 es admin
        if (session('usuario_id') !== env('ADMIN_USER_ID')) {
            return redirect()->route('home')
                           ->with('error', 'No tienes permisos para acceder al panel de administración');
        }

        return $next($request);
    }
}