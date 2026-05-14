
<?php

use App\Http\Controllers\AreaController;
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

});

Route::middleware(['auth', 'administrador'])->group(function () {

    Route::get('/administrador/dashboard', function () {
        return view('dashboard.administrador');
    })->name('administrador.dashboard');

    Route::resource('areas', AreaController::class);

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