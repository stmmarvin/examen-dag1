<?php

namespace App\Http\Controllers\Behandelingen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Behandelingen\StoreBehandelingRequest;
use App\Http\Requests\Behandelingen\UpdateBehandelingRequest;
use App\Models\Behandelingen\Behandeling;
use App\Support\Behandelingen\BehandelingKeuzes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BehandelingController extends Controller
{
    // Laat alle behandelingen zien met zoeken en filteren.
    public function index(Request $request): View
    {
        $zoekterm = trim((string) $request->query('zoek'));
        $type = trim((string) $request->query('type'));

        // Deze types worden gebruikt voor de filter dropdown.
        $types = Behandeling::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        // Hier worden zoekterm en type-filter toegepast op de lijst.
        $behandelingen = Behandeling::query()
            ->when($zoekterm !== '', function ($query) use ($zoekterm) {
                $query->where(function ($query) use ($zoekterm) {
                    $query->where('naam', 'like', "%{$zoekterm}%")
                        ->orWhere('type', 'like', "%{$zoekterm}%")
                        ->orWhere('beschrijving', 'like', "%{$zoekterm}%");
                });
            })
            ->when($type !== '', fn ($query) => $query->where('type', $type))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('behandelingen.index', [
            'behandelingen' => $behandelingen,
            'types' => $types,
            'zoekterm' => $zoekterm,
            'geselecteerdType' => $type,
        ]);
    }

    public function create(): View
    {
        // Leeg formulier met standaard keuzes voor behandelingen.
        return view('behandelingen.create', [
            'behandeling' => new Behandeling(['actief' => true]),
            'behandelingKeuzes' => BehandelingKeuzes::standaard(),
        ]);
    }

    public function store(StoreBehandelingRequest $request): RedirectResponse
    {
        // Slaat een nieuwe behandeling op na validatie.
        $behandeling = Behandeling::create($request->validated());

        return redirect()
            ->route('behandelingen.show', $behandeling)
            ->with('status', 'Behandeling succesvol toegevoegd.');
    }

    public function show(Behandeling $behandeling): View
    {
        // Detailpagina van een behandeling.
        return view('behandelingen.show', [
            'behandeling' => $behandeling,
        ]);
    }

    public function edit(Behandeling $behandeling): View
    {
        // Formulier om een bestaande behandeling aan te passen.
        return view('behandelingen.edit', [
            'behandeling' => $behandeling,
            'behandelingKeuzes' => BehandelingKeuzes::standaard(),
        ]);
    }

    public function delete(Behandeling $behandeling): View
    {
        // Bevestigingspagina voordat een behandeling wordt verwijderd.
        return view('behandelingen.delete', [
            'behandeling' => $behandeling,
            'behandelingen' => Behandeling::query()->latest()->take(6)->get(),
        ]);
    }

    public function update(UpdateBehandelingRequest $request, Behandeling $behandeling): RedirectResponse
    {
        // Werkt een bestaande behandeling bij.
        $behandeling->update($request->validated());

        return redirect()
            ->route('behandelingen.show', $behandeling)
            ->with('status', 'Behandeling succesvol gewijzigd.');
    }

    public function destroy(Behandeling $behandeling): RedirectResponse
    {
        // Verwijdert de gekozen behandeling.
        $behandeling->delete();

        return redirect()
            ->route('behandelingen.index')
            ->with('status', 'Behandeling succesvol verwijderd.');
    }
}
