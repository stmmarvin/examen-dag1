<?php

use App\Http\Controllers\Behandelingen\BehandelingController;
use Illuminate\Support\Facades\Route;

// Routes voor mijn behandeling CRUD.
Route::middleware('auth')->group(function () {
    Route::get('/behandelingen/{behandeling}/verwijderen', [BehandelingController::class, 'delete'])
        ->name('behandelingen.delete');

    Route::resource('behandelingen', BehandelingController::class)
        ->parameters(['behandelingen' => 'behandeling'])
        ->missing(function () {
            // Als een behandeling niet bestaat, ga terug naar het overzicht.
            return redirect()
                ->route('behandelingen.index')
                ->with('error', 'Behandeling niet gevonden.');
        });
});
