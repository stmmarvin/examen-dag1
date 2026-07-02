@include('behandelingen.partials.page-start')

<main class="flex-1 bg-white px-8 py-7">
    <div class="flex items-start justify-between gap-6">
        <div>
            <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-black hover:underline">← Terug naar behandelingen overzicht</a>
            <h1 class="mt-4 text-3xl font-bold text-black">{{ $behandeling->naam }}</h1>
            <p class="mt-2 text-sm text-black">Bekijk de details van deze behandeling.</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('behandelingen.edit', $behandeling) }}" class="rounded border border-gray-400 px-5 py-3 text-sm font-bold text-black hover:bg-gray-100">Wijzigen</a>
            <a href="{{ route('behandelingen.delete', $behandeling) }}" class="rounded bg-black px-5 py-3 text-sm font-bold text-white hover:bg-gray-800">Verwijderen</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded border border-green-300 bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    <section class="mt-8 rounded border border-gray-400 p-6">
        <div class="flex items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                @include('behandelingen.partials.icon', ['type' => $behandeling->type])
                <div>
                    <h2 class="text-2xl font-bold text-black">{{ $behandeling->naam }}</h2>
                    <p class="mt-3 text-sm text-black">◷ {{ $behandeling->duur_minuten }} min</p>
                    <p class="mt-3 text-sm text-black">{{ $behandeling->type }}</p>
                </div>
            </div>
            <p class="text-xl font-bold text-black">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</p>
        </div>

        <div class="mt-8 border-t border-gray-400 pt-6">
            <h3 class="text-sm font-bold text-black">Beschrijving</h3>
            <p class="mt-3 text-sm text-black">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</p>
        </div>

        <div class="mt-8 border-t border-gray-400 pt-6">
            <h3 class="text-sm font-bold text-black">Status</h3>
            <p class="mt-3 text-sm text-black">{{ $behandeling->actief ? 'Actief zichtbaar voor klanten' : 'Niet zichtbaar voor klanten' }}</p>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
