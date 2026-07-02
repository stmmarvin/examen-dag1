<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Appointment routes - Main pages
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/manage', [AppointmentController::class, 'manage'])->name('appointments.manage');
    Route::get('/appointments/overview', [AppointmentController::class, 'overview'])->name('appointments.overview');
    Route::get('/appointments/create-as-client', [AppointmentController::class, 'createAsClient'])->name('appointments.create-as-client');
    Route::get('/appointments/delete-as-employee', [AppointmentController::class, 'deleteAsEmployee'])->name('appointments.delete-as-employee');
    Route::get('/appointments/view-as-employee', [AppointmentController::class, 'viewAsEmployee'])->name('appointments.view-as-employee');
    Route::get('/appointments/edit-as-client', [AppointmentController::class, 'editAsClient'])->name('appointments.edit-as-client');
    Route::get('/appointments/test-unhappy-paths', [AppointmentController::class, 'testUnhappyPaths'])->name('appointments.test-unhappy-paths');
    
    // Appointment CRUD
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});

require __DIR__.'/auth.php';
