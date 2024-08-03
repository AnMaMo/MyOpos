<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TestsController;

Route::get('/', function () {
    if (Auth::check()) {
        return Inertia::render('Dashboard', [
            'user' => Auth::user(),
        ]);
    } else {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Tests', function () {
    return Inertia::render('Tests/TestsIndex');
})->middleware(['auth', 'verified'])->name('Tests');

Route::get('/Fisiques', function () {
    return Inertia::render('Fisiques/FisiquesIndex');
})->middleware(['auth', 'verified'])->name('Fisiques');

Route::get('/TestActivo', [TestsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('TestActivo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
