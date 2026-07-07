<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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

    // Toon verwijderpagina met eigen styling
    public function delete($medewerker)
    {
        $this->checkEigenaar();

        $resolved = $this->resolveMedewerker($medewerker);

        if (! $resolved) {
            abort(404);
        }

        $hasAppointments = $this->heeftToekomstigeAfspraken($resolved['model'], $resolved['source']);

        return view('medewerkers.delete', [
            'medewerker' => $resolved['source'],
            'hasAppointments' => $hasAppointments,
        ]);
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
    public function destroy($medewerker)
    {
        $this->checkEigenaar();

        $resolved = $this->resolveMedewerker($medewerker);

        if (! $resolved) {
            abort(404);
        }

        $hasAppointments = $this->heeftToekomstigeAfspraken($resolved['model'], $resolved['source']);
            
        if ($hasAppointments) {
            return back()->with('error', 'Deze medewerker kan niet worden verwijderd omdat er nog afspraken gepland staan');
        }

        $resolved['model']->delete();
        
        return redirect()->route('medewerkers.index')
            ->with('success', 'Medewerker verwijderd!');
    }

    private function resolveMedewerker($medewerker): ?array
    {
        $id = is_object($medewerker) ? $medewerker->getKey() : $medewerker;

        if (Schema::hasTable('medewerkers')) {
            $medewerkerModel = \App\Models\Medewerker::find($id);

            if ($medewerkerModel) {
                return [
                    'model' => $medewerkerModel,
                    'source' => $medewerkerModel,
                ];
            }
        }

        $user = User::find($id);

        if ($user) {
            return [
                'model' => $user,
                'source' => $user,
            ];
        }

        return null;
    }

    private function heeftToekomstigeAfspraken($medewerkerModel, $source): bool
    {
        if ($medewerkerModel instanceof \App\Models\Medewerker && Schema::hasTable('afspraken')) {
            return DB::table('afspraken')
                ->where('medewerker_id', $medewerkerModel->id)
                ->where('start_datumtijd', '>=', now())
                ->exists();
        }

        if ($source instanceof User && Schema::hasTable('appointments')) {
            return DB::table('appointments')
                ->where('employee_id', $source->id)
                ->where('appointment_date', '>=', now())
                ->exists();
        }

        return false;
    }
}
