<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\PreguntasController;

// Ruta principal, en caso que estemos logueados nos envia a la ruta tests, en caso contrario al login.
Route::get('/', function () {
    return auth()->check() ? redirect('/Tests') : redirect('/login');
});

// Middleware de Auth, se necesita estar logueado para entrar a todas las siguientes paginas.
Route::middleware('auth')->group(function () {
    // TESTS
    Route::get('/Tests', [TestsController::class, 'index'])->middleware(['auth', 'verified'])->name('Tests');

    // PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PREGUNTAS
    Route::get('/Preguntas', [PreguntasController::class, 'index'])->middleware(['auth', 'verified'])->name('Preguntas');
    Route::post('/añadir-pregunta', [PreguntasController::class, 'AñadirPregunta']);
    Route::post('/eliminar-pregunta', [PreguntasController::class, 'eliminarPregunta']);
    Route::post('/editar-pregunta', [PreguntasController::class, 'editarPregunta']);
    Route::get('/preguntas', [PreguntasController::class, 'getAllPreguntas']);
    Route::get('/pregunta/{id}', [PreguntasController::class, 'getPreguntaById']);

    // RESPUESTAS
    Route::post('/editar-respuesta', [PreguntasController::class, 'editarRespuesta']);
    Route::get('/respuesta/{id}', [PreguntasController::class, 'getRespuestaById']);
    Route::post('/añadir-respuesta', [PreguntasController::class, 'AñadirRespuesta']);
    Route::post('/eliminar-respuesta', [PreguntasController::class, 'eliminarRespuesta']);
    Route::post('/get-respuestas-idpregunta', [PreguntasController::class, 'getRespuestasByIdPregunta']);
});

// Mantener las rutas de autenticación (login y register)
require __DIR__.'/auth.php';
