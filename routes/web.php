<?php

use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CheckItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rutas públicas principales del sitio.
Route::get('/', function () {
    return view('welcome');
});

// Dashboard accesible solo para usuarios autenticados y verificados.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas comunes para usuarios autenticados.
Route::middleware('auth')->group(function () {

    // Edición del perfil de usuario.
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Actualización de datos del perfil.
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Eliminación de la cuenta del usuario.
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Rutas para usuarios con rol supervisor.
Route::middleware(['auth', 'supervisor'])->group(function () {

    // Panel específico del supervisor.
    Route::get('/supervisor/dashboard', function () {
        return view('dashboard.supervisor');
    })->name('supervisor.dashboard');

    // CRUD básico de reportes permitidos para supervisores.
    Route::resource('reportes', ReporteController::class)
        ->only(['index', 'show', 'create', 'store']);
});

// Rutas para usuarios con rol administrador.
Route::middleware(['auth', 'administrador'])->group(function () {

    // Panel de control del administrador.
    Route::get(
        '/administrador/dashboard',
        [ReporteController::class, 'dashboardAdmin']
    )
        ->name('administrador.dashboard');

    // Gestión completa de áreas.
    Route::resource('areas', AreaController::class);

    // Gestión completa de check items.
    Route::resource('check-items', CheckItemController::class);

    // Visualización de reportes para administradores.
    Route::resource('reportes', ReporteController::class)
        ->only(['index', 'show']);

    // Aprobar un reporte específico.
    Route::post(
        '/reportes/{reporte}/aprobar',
        [ReporteController::class, 'aprobar']
    )
        ->name('reportes.aprobar');

    // Rechazar un reporte específico.
    Route::post(
        '/reportes/{reporte}/rechazar',
        [ReporteController::class, 'rechazar']
    )
        ->name('reportes.rechazar');

    // Generar o descargar PDF de un reporte.
    Route::get('/reportes/{reporte}/pdf', [ReporteController::class, 'pdf'])
        ->name('reportes.pdf');

    // Generar o descargar EXCEL de un reporte.
    Route::get('/reportes-excel', [ReporteController::class, 'excel'])
        ->name('reportes.excel');

    // Generar o descargar EXCEL detallado de un reporte.
    Route::get(
        '/reportes/{reporte}/excel',
        [ReporteController::class, 'excelDetalle']
    )
        ->name('reportes.excel-detalle');
});

require __DIR__ . '/auth.php';
