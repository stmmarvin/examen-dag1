@include('behandelingen.partials.page-start')

<main class="bg-white px-8 py-7">
    <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-black hover:underline">← Terug naar behandelingen overzicht</a>
    <h1 class="mt-4 text-3xl font-bold text-black">Behandeling verwijderen</h1>
    <p class="mt-2 text-sm text-black">Weet je zeker dat je deze behandeling wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-[1.35fr_0.9fr]">
        <section>
            <form method="GET" action="{{ route('behandelingen.delete', $behandeling) }}" class="grid gap-5 md:grid-cols-[1.2fr_0.6fr_0.6fr]">
                <label class="relative block">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl text-black">⌕</span>
                    <input name="zoek" type="search" placeholder="Zoek een behandeling..." class="h-12 w-full rounded border-gray-400 pl-12 text-sm focus:border-black focus:ring-black">
                </label>

                <select class="h-12 w-full rounded border-gray-400 text-sm focus:border-black focus:ring-black">
                    <option>Alle categorieën</option>
                </select>

                <select class="h-12 w-full rounded border-gray-400 text-sm focus:border-black focus:ring-black">
                    <option>Meest populair</option>
                </select>
            </form>

            <div class="mt-7 overflow-hidden rounded border border-gray-400">
                <table class="min-w-full text-left text-sm text-black">
                    <thead>
                        <tr>
                            <th class="px-4 py-4 font-bold">Behandeling</th>
                            <th class="px-4 py-4 font-bold">Categorie</th>
                            <th class="px-4 py-4 font-bold">Duur</th>
                            <th class="px-4 py-4 font-bold">Prijs</th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @foreach ($behandelingen as $rij)
                            <tr class="{{ $rij->is($behandeling) ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-4">
                                        <span class="flex h-5 w-5 items-center justify-center rounded border border-gray-500 text-xs">{{ $rij->is($behandeling) ? '✓' : '' }}</span>
                                        @include('behandelingen.partials.icon', ['type' => $rij->type])
                                        <span class="font-bold">{{ $rij->naam }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-bold">{{ $rij->type }}</td>
                                <td class="px-4 py-3">◷ {{ $rij->duur_minuten }} min</td>
                                <td class="px-4 py-3">&euro; {{ number_format((float) $rij->prijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('behandelingen.delete', $rij) }}" class="text-xl">→</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="rounded border border-gray-400 p-5">
            <h2 class="text-lg font-bold text-black">Geselecteerde behandeling</h2>

            <div class="mt-8 flex items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    @include('behandelingen.partials.icon', ['type' => $behandeling->type])
                    <div>
                        <h3 class="text-2xl font-bold text-black">{{ $behandeling->naam }}</h3>
                        <p class="mt-3 text-sm text-black">◷ {{ $behandeling->duur_minuten }} min</p>
                        <p class="mt-3 text-sm text-black">{{ $behandeling->type }}</p>
                    </div>
                </div>
                <p class="text-lg font-bold text-black">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</p>
            </div>

            <div class="mt-8 border-t border-gray-400 pt-6">
                <h3 class="text-sm font-bold text-black">Beschrijving</h3>
                <p class="mt-3 text-sm text-black">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</p>
            </div>

            <div class="mt-8 border-t border-gray-400 pt-6 text-sm text-black">
                <h3 class="font-bold">Wat gebeurt er bij verwijderen?</h3>
                <ul class="mt-3 list-disc space-y-2 pl-5">
                    <li>Deze behandeling wordt permanent verwijderd.</li>
                    <li>Klanten kunnen deze behandeling niet meer boeken.</li>
                    <li>Deze actie kan niet ongedaan worden gemaakt.</li>
                </ul>
            </div>

            <div class="mt-8 rounded border border-gray-400 p-4 text-sm font-bold text-black">⚠ Deze actie kan niet ongedaan worden gemaakt.</div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('behandelingen.index') }}" class="flex h-11 min-w-32 items-center justify-center rounded border border-gray-400 px-6 text-sm font-bold text-black hover:bg-gray-100">Annuleren</a>
                <form method="POST" action="{{ route('behandelingen.destroy', $behandeling) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="h-11 min-w-36 rounded bg-black px-6 text-sm font-bold text-white hover:bg-gray-800">Verwijderen</button>
                </form>
            </div>
        </aside>
    </div>
</main>

@include('behandelingen.partials.page-end')
