
<?php
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CheckItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Ruta pública para la página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Ruta del dashboard principal protegida por autenticación y verificación
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas que requieren autenticación de usuario
Route::middleware('auth')->group(function () {

    // Mostrar el formulario para editar el perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Actualizar la información del perfil del usuario
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Eliminar la cuenta del usuario autenticado
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Grupo de rutas para usuarios con rol de supervisor
Route::middleware(['auth', 'supervisor'])->group(function () {

    // Dashboard específico para supervisores
    Route::get('/supervisor/dashboard', function () {
        return view('dashboard.supervisor');
    })->name('supervisor.dashboard');

    // Recursos de reportes gestionados por el controlador ReporteController
    Route::resource('reportes', ReporteController::class);

});

// Grupo de rutas para usuarios con rol de administrador
Route::middleware(['auth', 'administrador'])->group(function () {

    // Dashboard específico para administradores
    Route::get('/administrador/dashboard', function () {
        return view('dashboard.administrador');
    })->name('administrador.dashboard');

    // Recursos de áreas gestionados por el controlador AreaController
    Route::resource('areas', AreaController::class);

    // Recursos de elementos de verificación gestionados por el controlador CheckItemController
    Route::resource('check-items', CheckItemController::class);

});

require __DIR__.'/auth.php';

























/*
|--------------------------------------------------------------------------

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', function () {
        return view('dashboard.supervisor');
    })->name('supervisor.dashboard');
});

Route::middleware(['auth', 'administrador'])->group(function () {
    Route::get('/administrador/dashboard', function () {
        return view('dashboard.administrador');
    })->name('administrador.dashboard');

    Route::resource('areas', AreaController::class);
});

require __DIR__.'/auth.php';
*/