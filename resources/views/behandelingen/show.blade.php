@include('behandelingen.partials.page-start')

<main class="mx-auto w-full max-w-[1700px] flex-1 px-8 py-8">
    <div class="flex items-start justify-between gap-6">
        <div>
            <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-slate-950 hover:underline">Terug naar behandelingen overzicht</a>
            <h1 class="mt-4 text-3xl font-bold text-slate-950">{{ $behandeling->naam }}</h1>
            <p class="mt-2 text-sm text-slate-950">Bekijk de details van deze behandeling.</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('behandelingen.edit', $behandeling) }}" class="rounded-xl border border-slate-200 bg-white shadow-sm px-5 py-3 text-sm font-bold text-slate-950 hover:bg-[#f8f4ea]">Wijzigen</a>
            <a href="{{ route('behandelingen.delete', $behandeling) }}" class="rounded bg-black px-5 py-3 text-sm font-bold text-white hover:bg-[#162b4d]">Verwijderen</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded border border-green-300 bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    <section class="mt-8 rounded-xl border border-slate-200 bg-white shadow-sm p-6">
        @if ($behandeling->afbeelding_pad)
            <img src="{{ asset('storage/'.$behandeling->afbeelding_pad) }}" alt="{{ $behandeling->naam }}" class="mb-8 h-80 w-full rounded-lg object-cover">
        @endif

        <div class="flex items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                @include('behandelingen.partials.service-icon', ['type' => $behandeling->type])
                <div>
                    <h2 class="text-2xl font-bold text-slate-950">{{ $behandeling->naam }}</h2>
                    <p class="mt-3 text-sm text-slate-950">{{ $behandeling->duur_minuten }} min</p>
                    <p class="mt-3 text-sm text-slate-950">{{ $behandeling->type }}</p>
                </div>
            </div>
            <p class="text-xl font-bold text-slate-950">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</p>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <h3 class="text-sm font-bold text-slate-950">Beschrijving</h3>
            <p class="mt-3 text-sm text-slate-950">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</p>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <h3 class="text-sm font-bold text-slate-950">Status</h3>
            <p class="mt-3 text-sm text-slate-950">{{ $behandeling->actief ? 'Actief zichtbaar voor klanten' : 'Niet zichtbaar voor klanten' }}</p>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
