@include('behandelingen.partials.page-start')

<main class="flex-1 bg-white">
    <section class="px-8 py-7">
        <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-black hover:underline">← Terug naar behandelingen overzicht</a>
        <h1 class="mt-4 text-3xl font-bold text-black">Behandeling wijzigen</h1>
        <p class="mt-2 text-sm text-black">Pas de details van de behandeling aan en sla je wijzigingen op.</p>

        <form method="POST" action="{{ route('behandelingen.update', $behandeling) }}" class="mt-8">
            @method('PUT')

            <div class="grid gap-5 lg:grid-cols-[1.1fr_0.9fr]">
                <section class="rounded border border-gray-400">
                    <div class="p-5">
                        <h2 class="text-lg font-bold text-black">Algemene informatie</h2>
                        <div class="mt-6">
                            @include('behandelingen.partials.form')
                        </div>
                    </div>
                </section>

                <section class="rounded border border-gray-400 p-5">
                    <h2 class="text-lg font-bold text-black">Voorbeeld</h2>
                    <div class="mt-8 rounded border border-gray-400 p-6">
                        <div class="flex items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                @include('behandelingen.partials.icon', ['type' => $behandeling->type])
                                <div>
                                    <h3 class="text-xl font-bold text-black">{{ $behandeling->naam }}</h3>
                                    <p class="mt-3 text-sm text-black">◷ {{ $behandeling->duur_minuten }} min</p>
                                    <p class="mt-3 text-sm text-black">{{ $behandeling->type }}</p>
                                </div>
                            </div>
                            <p class="text-lg font-bold text-black">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</p>
                        </div>

                        <div class="mt-8 border-t border-gray-400 pt-6">
                            <h4 class="text-sm font-bold text-black">Beschrijving</h4>
                            <p class="mt-3 text-sm text-black">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <div class="mt-8 flex justify-end gap-5 border-t border-gray-400 px-0 py-5">
                <a href="{{ route('behandelingen.index') }}" class="flex h-11 min-w-32 items-center justify-center rounded border border-gray-400 px-6 text-sm font-bold text-black hover:bg-gray-100">Annuleren</a>
                <button type="submit" class="h-11 min-w-44 rounded bg-black px-6 text-sm font-bold text-white hover:bg-gray-800">Wijzigingen opslaan</button>
            </div>
        </form>
    </section>
</main>

@include('behandelingen.partials.page-end')
