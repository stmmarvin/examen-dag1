<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class KlantProfielController extends Controller
{
    // Toon klant profiel
    public function index()
    {
        $user = Auth::user();
        return view('profiel.index', compact('user'));
    }

    // Toon edit form
    public function edit()
    {
        $user = Auth::user();
        return view('profiel.edit', compact('user'));
    }

    // Update profiel
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'voornaam' => ['required', 'string', 'max:255'],
            'achternaam' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telefoon' => ['nullable', 'string', 'max:20'],
            'geboortedatum' => ['nullable', 'date'],
            'adres' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:10'],
            'plaats' => ['nullable', 'string', 'max:255'],
            'allergieen' => ['nullable', 'string'],
            'wensen' => ['nullable', 'string'],
        ]);

        $user->update([
            'voornaam' => $validated['voornaam'],
            'achternaam' => $validated['achternaam'],
            'name' => $validated['voornaam'] . ' ' . $validated['achternaam'],
            'email' => $validated['email'],
            'telefoon' => $validated['telefoon'],
            'geboortedatum' => $validated['geboortedatum'],
            'adres' => $validated['adres'],
            'postcode' => $validated['postcode'],
            'plaats' => $validated['plaats'],
            'allergieen' => $validated['allergieen'],
            'wensen' => $validated['wensen'],
        ]);

        return redirect()->route('profiel.index')->with('success', 'Profiel bijgewerkt!');
    }

    // Verwijder account
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account verwijderd');
    }
}
