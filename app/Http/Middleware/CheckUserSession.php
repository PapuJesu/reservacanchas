<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserSession  
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login')
                           ->with('error', 'Debes iniciar sesión primero');
        }

        return $next($request);
    }
}