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
            'voornaam' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s\'-]+$/u'],
            'achternaam' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s\'-]+$/u'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email,' . $user->id],
            'telefoon' => ['nullable', 'regex:/^(06|\\+316)[0-9]{8}$/'],
            'geboortedatum' => ['nullable', 'date', 'before:today'],
            'adres' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\'-]+$/u'],
            'postcode' => ['nullable', 'regex:/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/'],
            'plaats' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s\'-]+$/u'],
            'allergieen' => ['nullable', 'string', 'max:1000'],
            'wensen' => ['nullable', 'string', 'max:1000'],
        ], [
            'voornaam.regex' => 'Voornaam mag alleen letters bevatten.',
            'voornaam.min' => 'Voornaam moet minimaal 2 letters zijn.',
            'achternaam.regex' => 'Achternaam mag alleen letters bevatten.',
            'achternaam.min' => 'Achternaam moet minimaal 2 letters zijn.',
            'telefoon.regex' => 'Telefoonnummer moet beginnen met 06 gevolgd door 8 cijfers (bijv. 0612345678).',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'geboortedatum.before' => 'Geboortedatum moet in het verleden liggen.',
            'postcode.regex' => 'Postcode moet het Nederlandse formaat hebben (bijv. 1234AB).',
            'adres.regex' => 'Adres mag alleen letters, cijfers en normale leestekens bevatten.',
            'plaats.regex' => 'Plaats mag alleen letters bevatten.',
        ]);

        $user->update([
            'voornaam' => $validated['voornaam'],
            'achternaam' => $validated['achternaam'],
            'name' => $validated['voornaam'] . ' ' . $validated['achternaam'],
            'email' => $validated['email'],
            'telefoon' => $validated['telefoon'],
            'geboortedatum' => $validated['geboortedatum'],
            'adres' => $validated['adres'],
            'postcode' => $validated['postcode'] ? strtoupper(str_replace(' ', '', $validated['postcode'])) : null,
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
