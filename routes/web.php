<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\PreguntasController;

// Ruta principal que redirige a Tests/TestsIndex usando el controlador correspondiente
Route::get('/Tests', [TestsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Tests');

    Route::get('/', function () {
        return auth()->check() ? redirect('/Tests') : redirect('/login');
    });

// Mantenimiento preguntas, carga el índice.
Route::get('/Preguntas', [PreguntasController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Preguntas');

// Creado el middleware de auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/añadir-pregunta', [PreguntasController::class, 'AñadirPregunta']);
    Route::post('/eliminar-pregunta', [PreguntasController::class, 'eliminarPregunta']);
    Route::post('/editar-pregunta', [PreguntasController::class, 'editarPregunta']);
    Route::post('/editar-respuesta', [PreguntasController::class, 'editarRespuesta']);
    Route::get('/preguntas', [PreguntasController::class, 'getAllPreguntas']);
    Route::get('/pregunta/{id}', [PreguntasController::class, 'getPreguntaById']);
    Route::get('/respuesta/{id}', [PreguntasController::class, 'getRespuestaById']);
    Route::post('/añadir-respuesta', [PreguntasController::class, 'AñadirRespuesta']);
    Route::post('/eliminar-respuesta', [PreguntasController::class, 'eliminarRespuesta']);
    Route::post('/get-respuestas-idpregunta', [PreguntasController::class, 'getRespuestasByIdPregunta']);
});

// Mantener las rutas de autenticación (login y register)
require __DIR__.'/auth.php';
