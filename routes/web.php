<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\PreguntasController;

// Ruta principal que redirige a Tests/TestsIndex usando el controlador correspondiente
Route::get('/', [TestsController::class, 'index'])
    ->name('Tests');

// Mantenimiento preguntas, carga el índice.
Route::get('/Preguntas', [PreguntasController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Preguntas');

// Creado el middleware de auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/crear-pregunta', [PreguntasController::class, 'crearPregunta']);
Route::post('/eliminar-pregunta', [PreguntasController::class, 'eliminarPregunta']);
Route::get('/preguntas', [PreguntasController::class, 'getAllPreguntas']);
Route::get('/pregunta/{id}', [PreguntasController::class, 'getSinglePregunta']);


// Mantener las rutas de autenticación (login y register)
require __DIR__.'/auth.php';
