@include('behandelingen.partials.page-start')

<main class="flex-1 bg-white">
    <section class="px-8 py-7">
        <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-black hover:underline">← Terug naar behandelingen overzicht</a>
        <h1 class="mt-4 text-3xl font-bold text-black">Behandeling toevoegen</h1>
        <p class="mt-2 text-sm text-black">Voeg een nieuwe behandeling toe aan je overzicht.</p>

        <form method="POST" action="{{ route('behandelingen.store') }}" class="mt-8">
            <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr]">
                <section class="rounded border border-gray-400">
                    <div class="p-5">
                        <h2 class="text-lg font-bold text-black">Algemene informatie</h2>
                        <div class="mt-6">
                            @include('behandelingen.partials.form')
                        </div>
                    </div>
                </section>

                <section class="rounded border border-gray-400 p-5">
                    <h2 class="text-lg font-bold text-black">Afbeelding <span class="text-sm font-normal">(optioneel)</span></h2>
                    <div class="mt-5 flex min-h-[340px] items-center justify-center rounded border border-dashed border-gray-400">
                        <div class="text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded border border-black text-3xl">▧</div>
                            <p class="mt-6 text-sm font-bold text-black">Klik om een afbeelding te uploaden</p>
                            <p class="mt-3 text-sm text-gray-600">of sleep een afbeelding hierheen</p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-600">Aanbevolen formaat: 1200x800px. Max. 5MB.</p>
                </section>
            </div>

            <div class="mt-8 flex justify-end gap-5 border-t border-gray-400 px-0 py-5">
                <a href="{{ route('behandelingen.index') }}" class="flex h-11 min-w-32 items-center justify-center rounded border border-gray-400 px-6 text-sm font-bold text-black hover:bg-gray-100">Annuleren</a>
                <button type="submit" class="h-11 min-w-36 rounded bg-black px-6 text-sm font-bold text-white hover:bg-gray-800">Opslaan</button>
            </div>
        </form>
    </section>
</main>

@include('behandelingen.partials.page-end')
