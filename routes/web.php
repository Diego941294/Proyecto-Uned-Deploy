<?php

use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CheckItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'supervisor'])->group(function () {

    Route::get('/supervisor/dashboard', function () {
        return view('dashboard.supervisor');
    })->name('supervisor.dashboard');

    Route::resource('reportes', ReporteController::class)
        ->only(['index', 'show', 'create', 'store']);
});

Route::middleware(['auth', 'administrador'])->group(function () {

    Route::get('/administrador/dashboard', function () {
        return view('dashboard.administrador');
    })->name('administrador.dashboard');

    Route::resource('areas', AreaController::class);

    Route::resource('check-items', CheckItemController::class);

    Route::resource('reportes', ReporteController::class)
        ->only(['index', 'show']);

    Route::post(
        '/reportes/{reporte}/aprobar',
        [ReporteController::class, 'aprobar']
    )
        ->name('reportes.aprobar');

    Route::post(
        '/reportes/{reporte}/rechazar',
        [ReporteController::class, 'rechazar']
    )
        ->name('reportes.rechazar');

    Route::get('/reportes/{reporte}/pdf', [ReporteController::class, 'pdf'])
        ->name('reportes.pdf');
});

require __DIR__ . '/auth.php';
