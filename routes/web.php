<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CheckItemController;
use App\Http\Controllers\EditarReporteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\InfraestructuraController;
use App\Http\Controllers\UsuarioController;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GmailController;


/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Redirección principal después del login
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $user = Auth::user();

    if ($user && $user->hasRole('Super Administrador')) {
        return redirect()->route('super-admin.dashboard');
    }

    if ($user && $user->hasRole('Administrador')) {
        return redirect()->route('administrador.dashboard');
    }

    if ($user && $user->hasRole('Supervisor')) {
        return redirect()->route('supervisor.dashboard');
    }

    Auth::logout();

    return redirect()
        ->route('login')
        ->with(
            'error',
            'El usuario no tiene un rol asignado.'
        );
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Perfil de usuario autenticado
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| Rutas del Superadministrador
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'superadministrador',
])->group(function () {

    Route::get('/super-admin/dashboard', function () {

        $distribucion = [
            'superAdministradores' => \App\Models\User::role('Super Administrador')->count(),
            'administradores' => \App\Models\User::role('Administrador')->count(),
            'supervisores' => \App\Models\User::role('Supervisor')->count(),
        ];

        return view('dashboard.super-admin', compact('distribucion'));
    })->name('super-admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Administración de usuarios
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'usuarios',
        UsuarioController::class
    );

    /*
    | Habilitar usuarios deshabilitados.
    | Conserva su rol y sus reportes históricos.
    */
    Route::patch(
        '/usuarios/{usuario}/habilitar',
        [UsuarioController::class, 'habilitar']
    )->name('usuarios.habilitar');
});


/*
|--------------------------------------------------------------------------
| Rutas del Supervisor
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'supervisor'
])->group(function () {


    Route::get(
        '/supervisor/dashboard',
        [ReporteController::class, 'dashboardSupervisor']
    )->name('supervisor.dashboard');


    Route::get(
        '/reportes/create',
        [ReporteController::class, 'create']
    )->name('reportes.create');


    Route::post(
        '/reportes',
        [ReporteController::class, 'store']
    )->name('reportes.store');


    Route::get(
        '/supervisor/edit',
        [EditarReporteController::class, 'editHoy']
    )->name('supervisor.edit_supervisor');


    Route::get(
        '/reportes/{reporte}/edit',
        [EditarReporteController::class, 'edit']
    )->name('reportes.edit');


    /*
    |--------------------------------------------------------------------------
    | Editar reporte del Supervisor
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/supervisor/reportes/{reporte}/edit',
        [EditarReporteController::class, 'edit']
    )->name('supervisor.reportes.edit');


    Route::put(
        '/supervisor/reportes/{reporte}',
        [EditarReporteController::class, 'update']
    )->name('supervisor.reportes.update');
});


/*
|--------------------------------------------------------------------------
| Rutas del Administrador
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'administrador'
])->group(function () {


    Route::get(
        '/administrador/dashboard',
        [ReporteController::class, 'dashboardAdmin']
    )->name('administrador.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Áreas
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'areas',
        AreaController::class
    );


    Route::patch(
        '/areas/{area}/toggle-activo',
        [AreaController::class, 'toggleActivo']
    )->name('areas.toggle-activo');


    /*
    |--------------------------------------------------------------------------
    | Infraestructuras
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'infraestructuras',
        InfraestructuraController::class
    );


    Route::patch(
        '/infraestructuras/{infraestructura}/toggle-activo',
        [InfraestructuraController::class, 'toggleActivo']
    )->name('infraestructuras.toggle-activo');


    /*
    |--------------------------------------------------------------------------
    | Check Items
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'check-items',
        CheckItemController::class
    );


    Route::patch(
        '/check-items/{checkItem}/toggle-activo',
        [CheckItemController::class, 'toggleActivo']
    )->name('check-items.toggle-activo');


    /*
    |--------------------------------------------------------------------------
    | Gestión de Reportes
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/reportes/{reporte}/aprobar',
        [ReporteController::class, 'aprobar']
    )->name('reportes.aprobar');


    Route::post(
        '/reportes/{reporte}/rechazar',
        [ReporteController::class, 'rechazar']
    )->name('reportes.rechazar');


    Route::get(
        '/reportes/{reporte}/pdf',
        [ReporteController::class, 'pdf']
    )->name('reportes.pdf');


    Route::get(
        '/reportes-excel',
        [ReporteController::class, 'excel']
    )->name('reportes.excel');


    Route::get(
        '/reportes/{reporte}/excel',
        [ReporteController::class, 'excelDetalle']
    )->name('reportes.excel-detalle');


    Route::get(
        '/reportes-pdf',
        [ReporteController::class, 'pdfGeneral']
    )->name('reportes.pdf-general');
});


/*
|--------------------------------------------------------------------------
| Reportes compartidos
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/reportes',
        [ReporteController::class, 'index']
    )->name('reportes.index');


    Route::get(
        '/reportes/{reporte}',
        [ReporteController::class, 'show']
    )->name('reportes.show');
});


/*
|--------------------------------------------------------------------------
| Mis reportes del Supervisor
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'supervisor'
])->group(function () {

    Route::get(
        '/supervisor/mis-reportes',
        [ReporteController::class, 'misReportes']
    )->name('supervisor.mis_reportes');
});


/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

Route::get('/google/auth', [GmailController::class, 'redirectToGoogle'])
    ->name('google.auth');

Route::get('/google/callback', [GmailController::class, 'handleGoogleCallback'])
    ->name('google.callback');


require __DIR__ . '/auth.php';
