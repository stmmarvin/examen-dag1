<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedewerkerRequest;
use App\Http\Requests\UpdateMedewerkerRequest;
use App\Models\Behandeling;
use App\Models\Gebruiker;
use App\Models\Medewerker;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MedewerkerController extends Controller
{
    /**
     * Toon het overzicht met zoekfunctie en detailpaneel.
     */
    public function index(Request $request): View
    {
        $zoekterm = $request->string('zoek')->toString();

        $medewerkers = Medewerker::query()
            ->with(['gebruiker', 'behandelingen'])
            ->zoeken($zoekterm)
            ->join('gebruikers', 'gebruikers.id', '=', 'medewerkers.gebruiker_id')
            ->select('medewerkers.*')
            ->orderBy('gebruikers.achternaam')
            ->orderBy('gebruikers.voornaam')
            ->get();

        $geselecteerdeMedewerker = $medewerkers->first();

        if ($request->filled('medewerker')) {
            $geselecteerdeMedewerker = Medewerker::with(['gebruiker', 'behandelingen'])
                ->find($request->integer('medewerker'))
                ?? $geselecteerdeMedewerker;
        }

        return view('medewerkers.index', [
            'medewerkers' => $medewerkers,
            'geselecteerdeMedewerker' => $geselecteerdeMedewerker,
            'zoekterm' => $zoekterm,
        ]);
    }

    /**
     * Toon het formulier voor een nieuwe medewerker.
     */
    public function create(): View
    {
        return view('medewerkers.create', [
            'specialisatieOpties' => $this->specialisatieOpties(),
        ]);
    }

    /**
     * Sla de nieuwe medewerker op in de tabellen gebruikers, medewerkers en medewerker_behandeling.
     */
    public function store(StoreMedewerkerRequest $request): RedirectResponse
    {
        try {
            $medewerker = DB::transaction(function () use ($request): Medewerker {
                $gebruiker = Gebruiker::create($this->gebruikerData($request->validated()));
                $medewerker = Medewerker::create($this->medewerkerData($request->validated(), $gebruiker->id));
                $medewerker->behandelingen()->sync($request->validated('specialisaties'));

                return $medewerker;
            });

            Log::info('Medewerker aangemaakt', ['medewerker_id' => $medewerker->id]);

            return redirect()
                ->route('medewerkers.index', ['medewerker' => $medewerker->id])
                ->with('success', 'De medewerker is succesvol aangemaakt.');
        } catch (\Throwable $exception) {
            Log::error('Medewerker aanmaken mislukt', ['error' => $exception->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'De medewerker kon niet worden opgeslagen.');
        }
    }

    /**
     * Toon de wijzigpagina voor een bestaande medewerker.
     */
    public function edit(Medewerker $medewerker): View
    {
        $medewerker->load(['gebruiker', 'behandelingen']);

        return view('medewerkers.edit', [
            'medewerker' => $medewerker,
            'specialisatieOpties' => $this->specialisatieOpties(),
        ]);
    }

    /**
     * Werk medewerker- en gebruikersgegevens samen bij.
     */
    public function update(UpdateMedewerkerRequest $request, Medewerker $medewerker): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $medewerker): void {
                $medewerker->load('gebruiker');
                $medewerker->gebruiker->update($this->gebruikerData($request->validated(), false));
                $medewerker->update($this->medewerkerData($request->validated(), $medewerker->gebruiker_id));
                $medewerker->behandelingen()->sync($request->validated('specialisaties'));
            });

            Log::info('Medewerker gewijzigd', ['medewerker_id' => $medewerker->id]);

            return redirect()
                ->route('medewerkers.index', ['medewerker' => $medewerker->id])
                ->with('success', 'De medewerkergegevens zijn opgeslagen.');
        } catch (\Throwable $exception) {
            Log::error('Medewerker wijzigen mislukt', [
                'medewerker_id' => $medewerker->id,
                'error' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'De medewerkergegevens konden niet worden opgeslagen.');
        }
    }

    /**
     * Toon het verwijder-scherm uit het wireframe.
     */
    public function delete(Medewerker $medewerker): View|RedirectResponse
    {
        $medewerker->load(['gebruiker', 'behandelingen']);

        if ($this->isEigenaarAccount($medewerker)) {
            return redirect()
                ->route('medewerkers.index', ['medewerker' => $medewerker->id])
                ->with('error', 'Het eigenaaraccount kan niet worden verwijderd.');
        }

        return view('medewerkers.delete', [
            'medewerker' => $medewerker,
            'toekomstigeAfspraken' => $medewerker->afspraken()
                ->where('start_datumtijd', '>=', now())
                ->count(),
        ]);
    }

    /**
     * Verwijder alleen medewerkers zonder toekomstige afspraken.
     */
    public function destroy(Medewerker $medewerker): RedirectResponse
    {
        $medewerker->loadMissing('gebruiker');

        if ($this->isEigenaarAccount($medewerker)) {
            return redirect()
                ->route('medewerkers.index', ['medewerker' => $medewerker->id])
                ->with('error', 'Het eigenaaraccount kan niet worden verwijderd.');
        }

        if ($medewerker->hasFutureAppointments()) {
            return back()->with(
                'error',
                'Deze medewerker kan niet worden verwijderd omdat er nog afspraken gepland staan'
            );
        }

        try {
            DB::transaction(function () use ($medewerker): void {
                $gebruiker = $medewerker->gebruiker;
                $medewerker->behandelingen()->detach();
                $medewerker->delete();
                $gebruiker?->delete();
            });

            Log::warning('Medewerker verwijderd', ['medewerker_id' => $medewerker->id]);

            return redirect()
                ->route('medewerkers.index')
                ->with('success', 'De medewerker is verwijderd.');
        } catch (\Throwable $exception) {
            Log::error('Medewerker verwijderen mislukt', [
                'medewerker_id' => $medewerker->id,
                'error' => $exception->getMessage(),
            ]);

            return back()->with('error', 'De medewerker kon niet worden verwijderd.');
        }
    }

    /**
     * Selecteer alleen de velden voor de gebruikers-tabel.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function gebruikerData(array $data, bool $metWachtwoord = true): array
    {
        $gebruikerData = [
            'rol_id' => $this->eigenaarRolId(),
            'voornaam' => $data['voornaam'],
            'achternaam' => $data['achternaam'],
            'telefoon' => $data['telefoon'],
            'email' => $data['email'],
            'actief' => $data['status'] === 'In dienst',
        ];

        if ($metWachtwoord) {
            // Tijdelijk wachtwoord voor medewerkers die via de CRUD worden aangemaakt.
            $gebruikerData['wachtwoord'] = Hash::make('Welkom123!');
        }

        return $gebruikerData;
    }

    /**
     * Selecteer alleen de velden voor de medewerkers-tabel.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function medewerkerData(array $data, int $gebruikerId): array
    {
        return [
            'gebruiker_id' => $gebruikerId,
            'personeelsnummer' => $data['personeelsnummer'],
            'functie' => $data['functie'],
            'in_dienst_sinds' => $data['in_dienst_sinds'] ?? null,
            'werkdagen' => ($data['werkdagen'] ?? null) ?: 'Maandag t/m vrijdag',
            'werktijden' => ($data['werktijden'] ?? null) ?: '09:00 - 17:00',
        ];
    }

    /**
     * De eigenaarrol wordt gebruikt als beheerrol.
     */
    private function eigenaarRolId(): int
    {
        DB::table('rollen')->updateOrInsert(
            ['naam' => 'eigenaar'],
            ['omschrijving' => 'Kan medewerkers beheren', 'updated_at' => now(), 'created_at' => now()]
        );

        return (int) DB::table('rollen')->where('naam', 'eigenaar')->value('id');
    }

    /**
     * Het vaste eigenaar-loginaccount mag nooit via medewerkerbeheer verdwijnen.
     */
    private function isEigenaarAccount(Medewerker $medewerker): bool
    {
        return strtolower((string) $medewerker->gebruiker?->email) === 'eigenaar@kniplokettiko.nl';
    }

    /**
     * Haal behandelingen op als specialisatie-opties.
     */
    private function specialisatieOpties()
    {
        return Behandeling::query()
            ->where('actief', true)
            ->orderBy('naam')
            ->get();
    }
}
