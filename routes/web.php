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
    
    // Klant Profiel routes
    Route::get('/profiel', [App\Http\Controllers\KlantProfielController::class, 'index'])->name('profiel.index');
    Route::get('/profiel/bewerken', [App\Http\Controllers\KlantProfielController::class, 'edit'])->name('profiel.edit');
    Route::patch('/profiel', [App\Http\Controllers\KlantProfielController::class, 'update'])->name('profiel.update');
    Route::delete('/profiel', [App\Http\Controllers\KlantProfielController::class, 'destroy'])->name('profiel.destroy');
});

require __DIR__.'/auth.php';
