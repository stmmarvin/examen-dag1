@include('behandelingen.partials.page-start')

<main class="flex-1 bg-gradient-to-b from-white via-[#fbfaf7] to-[#f8f4ea] px-8 py-8">
    <div class="flex items-start justify-between gap-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-[#c69a3e]">Kniploket Tiko</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950">Behandelingen overzicht</h1>
            <p class="mt-2 text-sm text-slate-600">Bekijk, beheer en organiseer al onze behandelingen.</p>
        </div>

        <a href="{{ route('behandelingen.create') }}" class="inline-flex items-center gap-3 rounded-md bg-[#0f1f3a] px-6 py-4 text-sm font-bold text-white shadow-lg shadow-[#0f1f3a]/20 hover:bg-[#162b4d]">
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
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-[#0f1f3a]">Zoek</span>
            <input name="zoek" type="search" value="{{ $zoekterm }}" placeholder="Zoek een behandeling..." class="h-12 w-full rounded border-slate-300 pl-16 text-sm focus:border-[#0f1f3a] focus:ring-[#0f1f3a]">
        </label>

        <select name="type" class="h-12 w-full rounded border-slate-300 text-sm focus:border-[#0f1f3a] focus:ring-[#0f1f3a]">
            <option value="">Alle categorieen</option>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected($geselecteerdType === $type)>{{ $type }}</option>
            @endforeach
        </select>

        <select name="sorteer" class="h-12 w-full rounded border-slate-300 text-sm focus:border-[#0f1f3a] focus:ring-[#0f1f3a]">
            <option>Meest populair</option>
            <option>Naam A-Z</option>
            <option>Prijs laag-hoog</option>
        </select>

        <div class="flex gap-3">
            <button type="submit" class="h-12 rounded-xl border border-slate-200 bg-white shadow-sm px-5 text-sm font-bold text-slate-950 hover:bg-[#f8f4ea]">Meer filters</button>
            <a href="{{ route('behandelingen.index') }}" class="flex h-12 items-center rounded-xl border border-slate-200 bg-white shadow-sm px-5 text-sm font-bold text-slate-950 hover:bg-[#f8f4ea]">Reset</a>
        </div>
    </form>

    <div class="mt-7 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        @if ($behandelingen->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-950">
                    <thead class="border-b border-slate-200 bg-[#0f1f3a] text-white">
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
                                        @include('behandelingen.partials.service-icon', ['type' => $behandeling->type])
                                        <div>
                                            <div class="font-bold">{{ $behandeling->naam }}</div>
                                            <div class="mt-1 max-w-xs truncate text-sm">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $behandeling->type }}</td>
                                <td class="px-4 py-3">{{ $behandeling->duur_minuten }} min</td>
                                <td class="px-4 py-3">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-[#c69a3e]">&#9733;&#9733;&#9733;&#9733;&#9733; <span class="ml-1 text-xs text-slate-700">({{ 30 + $loop->iteration * 11 }})</span></td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-[#f3ead6] px-3 py-1 text-sm text-[#0f1f3a]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#c69a3e]"></span>
                                        {{ $behandeling->actief ? 'Actief' : 'Inactief' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-5">
                                        <a href="{{ route('behandelingen.show', $behandeling) }}" title="Bekijken" class="text-[#0f1f3a] hover:text-amber-600">
                                            @include('behandelingen.partials.action-icon', ['name' => 'view'])
                                        </a>
                                        <a href="{{ route('behandelingen.edit', $behandeling) }}" title="Wijzigen" class="text-[#0f1f3a] hover:text-amber-600">
                                            @include('behandelingen.partials.action-icon', ['name' => 'edit'])
                                        </a>
                                        <a href="{{ route('behandelingen.delete', $behandeling) }}" title="Verwijderen" class="text-[#0f1f3a] hover:text-red-700">
                                            @include('behandelingen.partials.action-icon', ['name' => 'trash'])
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-slate-200 px-4 py-4 text-sm">
                <span>{{ $behandelingen->firstItem() }} - {{ $behandelingen->lastItem() }} van {{ $behandelingen->total() }} behandelingen</span>
                <div>{{ $behandelingen->links() }}</div>
            </div>
        @else
            <p class="p-6 text-sm text-slate-950">
                {{ $zoekterm !== '' || $geselecteerdType !== '' ? 'Geen resultaten gevonden' : 'Geen behandelingen gevonden' }}
            </p>
        @endif
    </div>
</main>

@include('behandelingen.partials.page-end')
