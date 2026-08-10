<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministradorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user &&
            (
                $user->hasRole('administrador') ||
                $user->hasRole('super-admin')
            )
        ) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado.');
    }
}