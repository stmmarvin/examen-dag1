@include('behandelingen.partials.page-start')

<main class="mx-auto w-full max-w-[1700px] flex-1">
    <section class="px-8 py-7">
        <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-slate-950 hover:underline">Terug naar behandelingen overzicht</a>
        <h1 class="mt-4 text-3xl font-bold text-slate-950">Behandeling toevoegen</h1>
        <p class="mt-2 text-sm text-slate-950">Voeg een nieuwe behandeling toe aan je overzicht.</p>

        <form method="POST" action="{{ route('behandelingen.store') }}" class="mt-8">
            <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr]">
                <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="p-5">
                        <h2 class="text-lg font-bold text-slate-950">Algemene informatie</h2>
                        <div class="mt-6">
                            @include('behandelingen.partials.form')
                        </div>
                    </div>
                </section>

                <section class="rounded-xl border border-slate-200 bg-white shadow-sm p-5">
                    <h2 class="text-lg font-bold text-slate-950">Afbeelding <span class="text-sm font-normal">(optioneel)</span></h2>
                    <div class="mt-5 flex min-h-[340px] items-center justify-center rounded border border-dashed border-slate-300">
                        <div class="text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded border border-black text-3xl">▧</div>
                            <p class="mt-6 text-sm font-bold text-slate-950">Klik om een afbeelding te uploaden</p>
                            <p class="mt-3 text-sm text-slate-600">of sleep een afbeelding hierheen</p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-slate-600">Aanbevolen formaat: 1200x800px. Max. 5MB.</p>
                </section>
            </div>

            <div class="mt-8 flex justify-end gap-5 border-t border-slate-200 px-0 py-5">
                <a href="{{ route('behandelingen.index') }}" class="flex h-11 min-w-32 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm px-6 text-sm font-bold text-slate-950 hover:bg-[#f8f4ea]">Annuleren</a>
                <button type="submit" class="h-11 min-w-36 rounded bg-[#0f1f3a] px-6 text-sm font-bold text-white hover:bg-[#162b4d]">Opslaan</button>
            </div>
        </form>
    </section>
</main>

@include('behandelingen.partials.page-end')
