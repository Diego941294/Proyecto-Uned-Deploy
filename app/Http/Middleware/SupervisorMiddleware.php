<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupervisorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user &&
            (
                $user->hasRole('supervisor') ||
                $user->hasRole('super-admin')
            )
        ) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado.');
    }
}