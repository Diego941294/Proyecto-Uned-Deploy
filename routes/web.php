<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CheckItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Redirección principal después del login
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->hasRole('administrador')) {
        return redirect()->route('administrador.dashboard');
    }

    if ($user && $user->hasRole('supervisor')) {
        return redirect()->route('supervisor.dashboard');
    }

    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

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
|--Rutas------------------------------------------------------------------------
|  del Supervisor
|--------------------------------------------------------------------------
| El supervisor puede crear y guardar reportes preoperacionales.
*/

Route::middleware(['auth', 'supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', function () {
        $hoy = now()->toDateString();

        $reporteCaliente = Reporte::whereDate('fecha', $hoy)
            ->whereHas('area', function ($query) {
                $query->where('nombre', 'like', '%Caliente%');
            })
            ->exists();

        $reporteFrio = Reporte::whereDate('fecha', $hoy)
            ->whereHas('area', function ($query) {
                $query->where('nombre', 'like', '%Fría%')
                    ->orWhere('nombre', 'like', '%Fria%');
            })
            ->exists();

        return view('dashboard.supervisor', compact(
            'reporteCaliente',
            'reporteFrio'
        ));
    })->name('supervisor.dashboard');

    Route::get('/reportes/create', [ReporteController::class, 'create'])
        ->name('reportes.create');

    Route::post('/reportes', [ReporteController::class, 'store'])
        ->name('reportes.store');
});

/*
|--------------------------------------------------------------------------
| Rutas del Administrador
|--------------------------------------------------------------------------
| El administrador gestiona áreas, ítems, revisión, aprobación y exportación.
*/

Route::middleware(['auth', 'administrador'])->group(function () {
    Route::get('/administrador/dashboard', [ReporteController::class, 'dashboardAdmin'])
        ->name('administrador.dashboard');

    Route::resource('areas', AreaController::class);

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
});


/*
|--------------------------------------------------------------------------
| Reportes compartidos
|--------------------------------------------------------------------------
| Estas rutas pueden ser consultadas tanto por supervisor como administrador.
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

require __DIR__ . '/auth.php';