@include('behandelingen.partials.page-start')

<main class="mx-auto w-full max-w-[1700px] flex-1">
    <section class="px-8 py-7">
        <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-slate-950 hover:underline">Terug naar behandelingen overzicht</a>
        <h1 class="mt-4 text-3xl font-bold text-slate-950">Behandeling wijzigen</h1>
        <p class="mt-2 text-sm text-slate-950">Pas de details van de behandeling aan en sla je wijzigingen op.</p>

        <form method="POST" action="{{ route('behandelingen.update', $behandeling) }}" enctype="multipart/form-data" class="mt-8">
            @method('PUT')

            <div class="grid gap-5 lg:grid-cols-[1.1fr_0.9fr]">
                <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="p-5">
                        <h2 class="text-lg font-bold text-slate-950">Algemene informatie</h2>
                        <div class="mt-6">
                            @include('behandelingen.partials.form')
                        </div>
                    </div>
                </section>

                <section class="rounded-xl border border-slate-200 bg-white shadow-sm p-5">
                    <h2 class="text-lg font-bold text-slate-950">Afbeelding</h2>
                    <div class="mt-5 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        @if ($behandeling->afbeelding_pad)
                            <img src="{{ asset('storage/'.$behandeling->afbeelding_pad) }}" alt="{{ $behandeling->naam }}" class="h-64 w-full object-cover">
                        @else
                            <div class="flex h-64 items-center justify-center bg-[#f8f4ea] text-sm font-bold text-slate-600">Geen afbeelding ingesteld</div>
                        @endif
                    </div>
                    <input id="afbeelding" name="afbeelding" type="file" accept="image/jpeg,image/png,image/webp" class="mt-4 block w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 shadow-sm file:mr-4 file:rounded file:border-0 file:bg-[#0f1f3a] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white">
                    <x-input-error class="mt-2" :messages="$errors->get('afbeelding')" />
                    <p class="mt-3 text-xs text-slate-600">Upload alleen als je de afbeelding wilt vervangen. Max. 5MB.</p>

                    <h2 class="mt-8 text-lg font-bold text-slate-950">Voorbeeld</h2>
                    <div class="mt-5 rounded-xl border border-slate-200 bg-white shadow-sm p-6">
                        <div class="flex items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                @include('behandelingen.partials.service-icon', ['type' => $behandeling->type])
                                <div>
                                    <h3 class="text-xl font-bold text-slate-950">{{ $behandeling->naam }}</h3>
                                    <p class="mt-3 text-sm text-slate-950">{{ $behandeling->duur_minuten }} min</p>
                                    <p class="mt-3 text-sm text-slate-950">{{ $behandeling->type }}</p>
                                </div>
                            </div>
                            <p class="text-lg font-bold text-slate-950">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</p>
                        </div>

                        <div class="mt-8 border-t border-slate-200 pt-6">
                            <h4 class="text-sm font-bold text-slate-950">Beschrijving</h4>
                            <p class="mt-3 text-sm text-slate-950">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar.' }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <div class="mt-8 flex justify-end gap-5 border-t border-slate-200 px-0 py-5">
                <a href="{{ route('behandelingen.index') }}" class="flex h-11 min-w-32 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm px-6 text-sm font-bold text-slate-950 hover:bg-[#f8f4ea]">Annuleren</a>
                <button type="submit" class="h-11 min-w-44 rounded bg-[#0f1f3a] px-6 text-sm font-bold text-white hover:bg-[#162b4d]">Wijzigingen opslaan</button>
            </div>
        </form>
    </section>
</main>

@include('behandelingen.partials.page-end')
