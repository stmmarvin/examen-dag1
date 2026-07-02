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
    public function index(Request $request): View
    {
        $zoekterm = trim((string) $request->query('zoek'));
        $type = trim((string) $request->query('type'));

        $types = Behandeling::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

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
        return view('behandelingen.create', [
            'behandeling' => new Behandeling(['actief' => true]),
            'behandelingKeuzes' => BehandelingKeuzes::standaard(),
        ]);
    }

    public function store(StoreBehandelingRequest $request): RedirectResponse
    {
        $behandeling = Behandeling::create($request->validated());

        return redirect()
            ->route('behandelingen.show', $behandeling)
            ->with('status', 'Behandeling succesvol toegevoegd.');
    }

    public function show(Behandeling $behandeling): View
    {
        return view('behandelingen.show', [
            'behandeling' => $behandeling,
        ]);
    }

    public function edit(Behandeling $behandeling): View
    {
        return view('behandelingen.edit', [
            'behandeling' => $behandeling,
            'behandelingKeuzes' => BehandelingKeuzes::standaard(),
        ]);
    }

    public function update(UpdateBehandelingRequest $request, Behandeling $behandeling): RedirectResponse
    {
        $behandeling->update($request->validated());

        return redirect()
            ->route('behandelingen.show', $behandeling)
            ->with('status', 'Behandeling succesvol gewijzigd.');
    }

    public function destroy(Behandeling $behandeling): RedirectResponse
    {
        $behandeling->delete();

        return redirect()
            ->route('behandelingen.index')
            ->with('status', 'Behandeling succesvol verwijderd.');
    }
}
