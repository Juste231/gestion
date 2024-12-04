<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjetsController;
use App\Http\Controllers\TachesController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    // Projets routes
    Route::get('/projets/create', [ProjetsController::class, 'create'])->name('projets.create');
    Route::post('/projets', [ProjetsController::class, 'store'])->name('projets.store');
    Route::get('/projets/show', [ProjetsController::class, 'show'])->name('projets.show');
    Route::delete('/projets/destroy', [ProjetsController::class, 'destroy'])->name('projets.destroy');
    Route::patch('/projets/update-status', [ProjetsController::class, 'updateStatus'])->name('projets.updateStatus');
    Route::put('/projets/update', [ProjetsController::class, 'update'])->name('projets.update');
    Route::get('/projets/edit', [ProjetsController::class, 'edit'])->name('projets.edit');

    // Tâches routes

    Route::get('/taches/create', [TachesController::class, 'create'])->name('taches.create');
    Route::post('/taches', [TachesController::class, 'store'])->name('taches.store');
    Route::get('/taches/show', [TachesController::class, 'show'])->name('taches.show');
    Route::delete('/taches/destroy', [TachesController::class, 'destroy'])->name('taches.destroy');
    Route::get('/taches/edit', [TachesController::class, 'edit'])->name('taches.edit');
    Route::put('/taches/update', [TachesController::class, 'update'])->name('taches.update');
    Route::patch('/taches/update-statut', [TachesController::class, 'updateStatut'])->name('taches.updateStatut');
    Route::post('/taches/assign', [TachesController::class, 'editassign'])->name('taches.editassign');
    Route::patch('/taches/update-assign', [TachesController::class, 'assign'])->name('taches.updateassign');
});

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/taches', [TachesController::class, 'index'])->name('taches.index');
});






Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
