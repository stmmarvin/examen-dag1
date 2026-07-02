<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class KlantController extends Controller
{
    /**
     * Show the form for creating a new klant.
     * 
     * Requirements: 1.4
     */
    public function create(): View
    {
        return view('klanten.create');
    }
}
