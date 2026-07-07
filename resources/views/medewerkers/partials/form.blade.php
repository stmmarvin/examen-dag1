@php
    $gebruiker = $medewerker->gebruiker ?? null;
    $statusWaarde = old('status', isset($medewerker) ? $medewerker->statusTekst() : 'In dienst');
    $gekozenSpecialisaties = old(
        'specialisaties',
        isset($medewerker) ? $medewerker->behandelingen->pluck('id')->map(fn ($id) => (string) $id)->all() : []
    );
@endphp

<div class="rounded border border-gray-400 p-6">
    <section>
        <h2 class="text-xl font-bold">Persoonlijke gegevens</h2>

        <!-- required-attributen verzorgen de client-side validatie uit de opdracht. -->
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-4 lg:grid-cols-2">
            <label class="block text-sm font-bold">
                Voornaam *
                <input required name="voornaam" value="{{ old('voornaam', $gebruiker->voornaam ?? '') }}" placeholder="Bijv. Laura" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold">
                Achternaam *
                <input required name="achternaam" value="{{ old('achternaam', $gebruiker->achternaam ?? '') }}" placeholder="Bijv. Jansen" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold">
                Telefoonnummer *
                <input required name="telefoon" value="{{ old('telefoon', $gebruiker->telefoon ?? '') }}" placeholder="06 12345678" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold">
                E-mailadres *
                <input required type="email" name="email" value="{{ old('email', $gebruiker->email ?? '') }}" placeholder="naam@email.nl" class="mt-2 w-full rounded border-gray-400">
            </label>
        </div>
    </section>

    <hr class="my-6 border-gray-300">

    <section>
        <h2 class="text-xl font-bold">Werkgegevens</h2>

        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-4 lg:grid-cols-2">
            <label class="block text-sm font-bold">
                Personeelsnummer *
                <input required name="personeelsnummer" value="{{ old('personeelsnummer', $medewerker->personeelsnummer ?? '') }}" placeholder="MW-001" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold">
                Functie *
                <input required name="functie" value="{{ old('functie', $medewerker->functie ?? '') }}" placeholder="Medewerker" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold">
                Status *
                <select required name="status" class="mt-2 w-full rounded border-gray-400">
                    @foreach (['In dienst', 'Uit dienst', 'Ziek', 'Verlof'] as $status)
                        <option value="{{ $status }}" @selected($statusWaarde === $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block text-sm font-bold">
                Startdatum
                <input type="date" name="in_dienst_sinds" value="{{ old('in_dienst_sinds', optional($medewerker->in_dienst_sinds ?? null)->format('Y-m-d')) }}" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold">
                Werktijden
                <input name="werktijden" value="{{ old('werktijden', $medewerker->werktijden ?? '09:00 - 17:00') }}" placeholder="09:00 - 17:00" class="mt-2 w-full rounded border-gray-400">
            </label>

            <label class="block text-sm font-bold lg:col-span-2">
                Werkdagen
                <input name="werkdagen" value="{{ old('werkdagen', $medewerker->werkdagen ?? 'Maandag t/m vrijdag') }}" placeholder="Maandag t/m vrijdag" class="mt-2 w-full rounded border-gray-400">
            </label>
        </div>
    </section>

    <hr class="my-6 border-gray-300">

    <section>
        <h2 class="text-xl font-bold">Specialisaties</h2>
        <div class="mt-4 space-y-2 text-sm">
            @foreach ($specialisatieOpties as $specialisatie)
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="specialisaties[]" value="{{ $specialisatie->id }}" @checked(in_array((string) $specialisatie->id, $gekozenSpecialisaties, true)) class="rounded border-gray-400">
                    <span>{{ $specialisatie->naam }}</span>
                </label>
            @endforeach
        </div>
    </section>
</div>
