<?php

use App\Http\Controllers\Behandelingen\BehandelingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->resource('behandelingen', BehandelingController::class)
    ->parameters(['behandelingen' => 'behandeling'])
    ->missing(function () {
        return redirect()
            ->route('behandelingen.index')
            ->with('error', 'Behandeling niet gevonden.');
    });
