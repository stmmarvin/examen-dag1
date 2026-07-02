<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SimpleMedewerkerController extends Controller
{
    // Check if user is eigenaar
    private function checkEigenaar()
    {
        if (auth()->user()->rolename !== 'eigenaar') {
            abort(403, 'Toegang geweigerd. Alleen voor eigenaren.');
        }
    }
    
    // Overzicht van medewerkers
    public function index()
    {
        $this->checkEigenaar();
        
        $medewerkers = User::where('rolename', 'medewerker')
            ->orderBy('name')
            ->get();
            
        return view('medewerkers.index', compact('medewerkers'));
    }

    // Toon formulier voor nieuwe medewerker
    public function create()
    {
        $this->checkEigenaar();
        
        return view('medewerkers.create');
    }

    // Opslaan nieuwe medewerker
    public function store(Request $request)
    {
        $this->checkEigenaar();
        $validated = $request->validate([
            'voornaam' => ['required', 'string', 'max:255'],
            'achternaam' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'telefoon' => ['nullable', 'regex:/^(06|\+316)[0-9]{8}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['voornaam'] . ' ' . $validated['achternaam'],
            'voornaam' => $validated['voornaam'],
            'achternaam' => $validated['achternaam'],
            'email' => $validated['email'],
            'telefoon' => $validated['telefoon'],
            'password' => Hash::make($validated['password']),
            'rolename' => 'medewerker',
        ]);

        return redirect()->route('medewerkers.index')
            ->with('success', 'Medewerker succesvol toegevoegd!');
    }

    // Toon bewerkingsformulier
    public function edit(User $medewerker)
    {
        $this->checkEigenaar();
        
        if ($medewerker->rolename !== 'medewerker') {
            abort(403, 'Dit is geen medewerker account.');
        }
        
        return view('medewerkers.edit', compact('medewerker'));
    }

    // Update medewerker
    public function update(Request $request, User $medewerker)
    {
        $this->checkEigenaar();
        if ($medewerker->rolename !== 'medewerker') {
            abort(403, 'Dit is geen medewerker account.');
        }
        
        $validated = $request->validate([
            'voornaam' => ['required', 'string', 'max:255'],
            'achternaam' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $medewerker->id],
            'telefoon' => ['nullable', 'regex:/^(06|\+316)[0-9]{8}$/'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $medewerker->update([
            'name' => $validated['voornaam'] . ' ' . $validated['achternaam'],
            'voornaam' => $validated['voornaam'],
            'achternaam' => $validated['achternaam'],
            'email' => $validated['email'],
            'telefoon' => $validated['telefoon'],
        ]);

        if ($request->filled('password')) {
            $medewerker->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return redirect()->route('medewerkers.index')
            ->with('success', 'Medewerker gegevens bijgewerkt!');
    }

    // Verwijder medewerker
    public function destroy(User $medewerker)
    {
        $this->checkEigenaar();
        
        if ($medewerker->rolename !== 'medewerker') {
            abort(403, 'Dit is geen medewerker account.');
        }
        
        // Check if medewerker has future appointments
        $hasAppointments = \App\Models\Appointment::where('employee_id', $medewerker->id)
            ->where('appointment_date', '>=', now())
            ->exists();
            
        if ($hasAppointments) {
            return back()->with('error', 'Deze medewerker heeft nog toekomstige afspraken en kan niet worden verwijderd.');
        }
        
        $medewerker->delete();
        
        return redirect()->route('medewerkers.index')
            ->with('success', 'Medewerker verwijderd!');
    }
}
