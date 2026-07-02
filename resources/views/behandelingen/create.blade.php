@include('behandelingen.partials.page-start')

<main class="mx-auto w-full max-w-[1700px] flex-1">
    <section class="px-8 py-7">
        <a href="{{ route('behandelingen.index') }}" class="text-sm font-bold text-slate-950 hover:underline">Terug naar behandelingen overzicht</a>
        <h1 class="mt-4 text-3xl font-bold text-slate-950">Behandeling toevoegen</h1>
        <p class="mt-2 text-sm text-slate-950">Voeg een nieuwe behandeling toe aan je overzicht.</p>

        <form method="POST" action="{{ route('behandelingen.store') }}" enctype="multipart/form-data" class="mt-8">
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
                    <label for="afbeelding" class="mt-5 flex min-h-[340px] cursor-pointer items-center justify-center overflow-hidden rounded border-2 border-dashed border-slate-300 bg-white hover:border-[#c69a3e]">
                        <img id="afbeelding-preview" src="" alt="" class="hidden h-full min-h-[340px] w-full object-cover">
                        <div id="afbeelding-placeholder" class="text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded border border-[#0f1f3a] text-3xl text-[#0f1f3a]">+</div>
                            <p class="mt-6 text-sm font-bold text-slate-950">Klik om een afbeelding te uploaden</p>
                            <p class="mt-3 text-sm text-slate-600">of sleep een afbeelding hierheen</p>
                        </div>
                    </label>
                    <input id="afbeelding" name="afbeelding" type="file" accept="image/jpeg,image/png,image/webp" class="mt-4 block w-full rounded border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 shadow-sm file:mr-4 file:rounded file:border-0 file:bg-[#0f1f3a] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white">
                    <x-input-error class="mt-2" :messages="$errors->get('afbeelding')" />
                    <p class="mt-3 text-xs text-slate-600">Aanbevolen formaat: 1200x800px. Max. 5MB. JPG, PNG of WebP.</p>
                </section>
            </div>

            <div class="mt-8 flex justify-end gap-5 border-t border-slate-200 px-0 py-5">
                <a href="{{ route('behandelingen.index') }}" class="flex h-11 min-w-32 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm px-6 text-sm font-bold text-slate-950 hover:bg-[#f8f4ea]">Annuleren</a>
                <button type="submit" class="h-11 min-w-36 rounded bg-[#0f1f3a] px-6 text-sm font-bold text-white hover:bg-[#162b4d]">Opslaan</button>
            </div>
        </form>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('afbeelding');
        const preview = document.getElementById('afbeelding-preview');
        const placeholder = document.getElementById('afbeelding-placeholder');

        input?.addEventListener('change', () => {
            const bestand = input.files?.[0];

            if (!bestand) {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
                return;
            }

            preview.src = URL.createObjectURL(bestand);
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        });
    });
</script>

@include('behandelingen.partials.page-end')
