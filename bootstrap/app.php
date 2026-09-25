
<?php

use App\Http\Middleware\VerificarUsuarioActivo;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // Conserva la configuración actual del servidor.
        $middleware->trustProxies(at: '*');

        /*
        |--------------------------------------------------------------------------
        | Middleware para usuarios activos
        |--------------------------------------------------------------------------
        |
        | Se ejecuta en las solicitudes web.
        | Si existe una sesión de un usuario deshabilitado,
        | cierra la sesión y bloquea el acceso.
        |
        */

        $middleware->web(append: [
            VerificarUsuarioActivo::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Middleware de roles
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'supervisor' =>
                \App\Http\Middleware\SupervisorMiddleware::class,

            'administrador' =>
                \App\Http\Middleware\AdministradorMiddleware::class,

            'superadministrador' =>
                \App\Http\Middleware\SuperAdministradorMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();