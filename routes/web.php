<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CheckItemController;
use App\Http\Controllers\EditarReporteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfraestructuraController;

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

    if ($user && $user->hasAnyRole(['administrador', 'Administrador'])) {
        return redirect()->route('administrador.dashboard');
    }

    if ($user && $user->hasAnyRole(['supervisor', 'Supervisor'])) {
        return redirect()->route('supervisor.dashboard');
    }

    Auth::logout();

    return redirect()
        ->route('login')
        ->with('error', 'El usuario no tiene un rol asignado.');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil de usuario autenticado
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas del Supervisor
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'supervisor'])->group(function () {
    Route::middleware(['auth', 'supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', [ReporteController::class, 'dashboardSupervisor'])
        ->name('supervisor.dashboard');
});


    Route::get('/reportes/create', [ReporteController::class, 'create'])
        ->name('reportes.create');

    Route::post('/reportes', [ReporteController::class, 'store'])
        ->name('reportes.store');

    Route::get('/supervisor/edit', [EditarReporteController::class, 'editHoy'])
        ->name('supervisor.edit_supervisor');

    Route::get('/reportes/{reporte}/edit', [EditarReporteController::class, 'edit'])
        ->name('reportes.edit');
});

/*
|--------------------------------------------------------------------------
| Rutas del Administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'administrador'])->group(function () {
    Route::get('/administrador/dashboard', [ReporteController::class, 'dashboardAdmin'])
        ->name('administrador.dashboard');

    Route::resource('areas', AreaController::class);

    Route::resource('infraestructuras', InfraestructuraController::class);

    Route::resource('check-items', CheckItemController::class);

    Route::post('/reportes/{reporte}/aprobar', [ReporteController::class, 'aprobar'])
        ->name('reportes.aprobar');

    Route::post('/reportes/{reporte}/rechazar', [ReporteController::class, 'rechazar'])
        ->name('reportes.rechazar');

    Route::get('/reportes/{reporte}/pdf', [ReporteController::class, 'pdf'])
        ->name('reportes.pdf');

    Route::get('/reportes-excel', [ReporteController::class, 'excel'])
        ->name('reportes.excel');

    Route::get('/reportes/{reporte}/excel', [ReporteController::class, 'excelDetalle'])
        ->name('reportes.excel-detalle');

    Route::get('/reportes-pdf', [ReporteController::class, 'pdfGeneral'])
        ->name('reportes.pdf-general');

    Route::post('/reportes/{reporte}/firmas', [ReporteController::class, 'guardarFirmas'])
        ->name('reportes.firmas');
});

/*
|--------------------------------------------------------------------------
| Reportes compartidos
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');

    Route::get('/reportes/{reporte}', [ReporteController::class, 'show'])
        ->name('reportes.show');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/


//supervisor 
// Formulario de edición de un reporte específico
Route::get('/supervisor/reportes/{reporte}/edit', [EditarReporteController::class, 'edit'])
    ->name('supervisor.reportes.edit');

// Guardar cambios
Route::put('/supervisor/reportes/{reporte}', [EditarReporteController::class, 'update'])
    ->name('supervisor.reportes.update');


require __DIR__ . '/auth.php';
