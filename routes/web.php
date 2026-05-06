<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
        return 'Dashboard del Supervisor';
    })->name('supervisor.dashboard');
});

Route::middleware(['auth', 'administrador'])->group(function () {
    Route::get('/administrador/dashboard', function () {
        return 'Dashboard del Administrador';
    })->name('administrador.dashboard');
});


require __DIR__.'/auth.php';
