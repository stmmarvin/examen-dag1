<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedewerkerRequest;
use App\Http\Requests\UpdateMedewerkerRequest;
use App\Models\Medewerker;
use App\Models\Persoon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedewerkerController extends Controller
{
    private const SPECIALISATIES = ['Knippen', 'Kleuren', 'Styling', 'Extensions'];

    /**
     * Toon het overzicht met zoekfunctie en detailpaneel.
     */
    public function index(Request $request): View
    {
        $zoekterm = $request->string('zoek')->toString();

        $medewerkers = Medewerker::query()
            ->with('persoon')
            ->zoeken($zoekterm)
            ->join('personen', 'personen.id', '=', 'medewerkers.persoon_id')
            ->select('medewerkers.*')
            ->orderBy('personen.achternaam')
            ->orderBy('personen.voornaam')
            ->get();

        $geselecteerdeMedewerker = $medewerkers->first();

        if ($request->filled('medewerker')) {
            $geselecteerdeMedewerker = Medewerker::with('persoon')->find($request->integer('medewerker'))
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
            'specialisatieOpties' => self::SPECIALISATIES,
        ]);
    }

    /**
     * Sla de nieuwe medewerker op in een database-transactie.
     */
    public function store(StoreMedewerkerRequest $request): RedirectResponse
    {
        try {
            $medewerker = DB::transaction(function () use ($request): Medewerker {
                $persoon = Persoon::create($this->persoonData($request->validated()));

                return Medewerker::create($this->medewerkerData($request->validated(), $persoon->id));
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
        $medewerker->load('persoon');

        return view('medewerkers.edit', [
            'medewerker' => $medewerker,
            'specialisatieOpties' => self::SPECIALISATIES,
        ]);
    }

    /**
     * Werk medewerker- en persoonsgegevens samen bij.
     */
    public function update(UpdateMedewerkerRequest $request, Medewerker $medewerker): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $medewerker): void {
                $medewerker->load('persoon');
                $medewerker->persoon->update($this->persoonData($request->validated()));
                $medewerker->update($this->medewerkerData($request->validated(), $medewerker->persoon_id));
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
    public function delete(Medewerker $medewerker): View
    {
        $medewerker->load(['persoon', 'afspraken']);

        return view('medewerkers.delete', [
            'medewerker' => $medewerker,
            'toekomstigeAfspraken' => $medewerker->afspraken()
                ->where('starttijd', '>=', now())
                ->count(),
        ]);
    }

    /**
     * Verwijder alleen medewerkers zonder toekomstige afspraken.
     */
    public function destroy(Medewerker $medewerker): RedirectResponse
    {
        if ($medewerker->hasFutureAppointments()) {
            return back()->with(
                'error',
                'Deze medewerker kan niet worden verwijderd omdat er nog afspraken gepland staan'
            );
        }

        try {
            DB::transaction(function () use ($medewerker): void {
                $persoon = $medewerker->persoon;
                $medewerker->delete();
                $persoon?->delete();
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
     * Selecteer alleen de velden voor de persoon-tabel.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function persoonData(array $data): array
    {
        return [
            'voornaam' => $data['voornaam'],
            'achternaam' => $data['achternaam'],
            'telefoonnummer' => $data['telefoonnummer'],
            'emailadres' => $data['emailadres'],
        ];
    }

    /**
     * Selecteer alleen de velden voor de medewerkers-tabel.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function medewerkerData(array $data, int $persoonId): array
    {
        return [
            'persoon_id' => $persoonId,
            'functie' => $data['functie'],
            'specialisaties' => $data['specialisaties'],
            'status' => $data['status'],
            'startdatum' => $data['startdatum'] ?? null,
            'werkdagen' => ($data['werkdagen'] ?? null) ?: 'Maandag t/m vrijdag',
            'werktijden' => ($data['werktijden'] ?? null) ?: '09:00 - 17:00',
        ];
    }
}
