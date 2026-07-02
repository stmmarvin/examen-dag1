@include('behandelingen.partials.page-start')

<main class="bg-white px-8 py-7">
    <div class="flex items-start justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-black">Behandelingen overzicht</h1>
            <p class="mt-2 text-sm text-black">Bekijk, beheer en organiseer al onze behandelingen.</p>
        </div>

        <a href="{{ route('behandelingen.create') }}" class="inline-flex items-center gap-3 rounded bg-black px-6 py-4 text-sm font-bold text-white shadow hover:bg-gray-800">
            <span class="text-2xl leading-none">+</span>
            Behandeling toevoegen
        </a>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded border border-green-300 bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    @if (session('error'))
        <div class="mt-6 rounded border border-red-300 bg-red-50 p-4 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    {{-- Zoek en filter formulier. --}}
    <form method="GET" action="{{ route('behandelingen.index') }}" class="mt-8 grid gap-5 lg:grid-cols-[1.4fr_1fr_1fr_auto]">
        <label class="relative block">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl text-black">⌕</span>
            <input name="zoek" type="search" value="{{ $zoekterm }}" placeholder="Zoek een behandeling..." class="h-12 w-full rounded border-gray-400 pl-12 text-sm focus:border-black focus:ring-black">
        </label>

        <select name="type" class="h-12 w-full rounded border-gray-400 text-sm focus:border-black focus:ring-black">
            <option value="">Alle categorieën</option>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected($geselecteerdType === $type)>{{ $type }}</option>
            @endforeach
        </select>

        <select name="sorteer" class="h-12 w-full rounded border-gray-400 text-sm focus:border-black focus:ring-black">
            <option>Meest populair</option>
            <option>Naam A-Z</option>
            <option>Prijs laag-hoog</option>
        </select>

        <div class="flex gap-3">
            <button type="submit" class="h-12 rounded border border-gray-400 px-5 text-sm font-bold text-black hover:bg-gray-100">Meer filters</button>
            <a href="{{ route('behandelingen.index') }}" class="flex h-12 items-center rounded border border-gray-400 px-5 text-sm font-bold text-black hover:bg-gray-100">Reset</a>
        </div>
    </form>

    <div class="mt-7 overflow-hidden rounded border border-gray-400">
        @if ($behandelingen->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-black">
                    <thead class="border-b border-gray-300 bg-white">
                        <tr>
                            <th class="px-4 py-4 font-bold">Behandeling</th>
                            <th class="px-4 py-4 font-bold">Categorie</th>
                            <th class="px-4 py-4 font-bold">Duur</th>
                            <th class="px-4 py-4 font-bold">Prijs</th>
                            <th class="px-4 py-4 font-bold">Populair</th>
                            <th class="px-4 py-4 font-bold">Status</th>
                            <th class="px-4 py-4 text-right font-bold">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @foreach ($behandelingen as $behandeling)
                            <tr class="bg-white">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-4">
                                        @include('behandelingen.partials.icon', ['type' => $behandeling->type])
                                        <div>
                                            <div class="font-bold">{{ $behandeling->naam }}</div>
                                            <div class="mt-1 max-w-xs truncate text-sm">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $behandeling->type }}</td>
                                <td class="px-4 py-3">◷ {{ $behandeling->duur_minuten }} min</td>
                                <td class="px-4 py-3">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">★★★★★ <span class="ml-1 text-xs">({{ 30 + $loop->iteration * 11 }})</span></td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-200 px-3 py-1 text-sm">
                                        <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                                        {{ $behandeling->actief ? 'Actief' : 'Inactief' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-5 text-xl">
                                        <a href="{{ route('behandelingen.show', $behandeling) }}" title="Bekijken" class="hover:opacity-60">◎</a>
                                        <a href="{{ route('behandelingen.edit', $behandeling) }}" title="Wijzigen" class="hover:opacity-60">✎</a>
                                        <a href="{{ route('behandelingen.delete', $behandeling) }}" title="Verwijderen" class="hover:opacity-60">▥</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-gray-300 px-4 py-4 text-sm">
                <span>{{ $behandelingen->firstItem() }} - {{ $behandelingen->lastItem() }} van {{ $behandelingen->total() }} behandelingen</span>
                <div>{{ $behandelingen->links() }}</div>
            </div>
        @else
            <p class="p-6 text-sm text-black">
                {{ $zoekterm !== '' || $geselecteerdType !== '' ? 'Geen resultaten gevonden' : 'Geen behandelingen gevonden' }}
            </p>
        @endif
    </div>
</main>

@include('behandelingen.partials.page-end')
