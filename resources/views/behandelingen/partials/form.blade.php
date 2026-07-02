@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="naam" class="text-sm font-bold text-slate-950">Naam behandeling *</label>
        <input id="naam" name="naam" type="text" value="{{ old('naam', $behandeling->naam) }}" placeholder="Bijv. Dames knippen" required class="mt-2 h-11 w-full rounded border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">
        <x-input-error class="mt-2" :messages="$errors->get('naam')" />
    </div>

    <div>
        <label for="beschrijving" class="text-sm font-bold text-slate-950">Korte omschrijving *</label>
        <textarea id="beschrijving" name="beschrijving" rows="4" placeholder="Beschrijf kort de behandeling" class="mt-2 w-full rounded border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">{{ old('beschrijving', $behandeling->beschrijving) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('beschrijving')" />
    </div>

    <div>
        <label for="behandeling_keuze" class="text-sm font-bold text-slate-950">Standaardkeuze</label>
        <select id="behandeling_keuze" class="mt-2 h-11 w-full rounded border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">
            <option value="">Zelf invullen</option>
            @foreach ($behandelingKeuzes as $index => $keuze)
                <option value="{{ $index }}">{{ $keuze['naam'] }} - {{ $keuze['type'] }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="type" class="text-sm font-bold text-slate-950">Categorie *</label>
        <input id="type" name="type" type="text" value="{{ old('type', $behandeling->type) }}" placeholder="Bijv. Knippen" required class="mt-2 h-11 w-full rounded border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">
        <x-input-error class="mt-2" :messages="$errors->get('type')" />
    </div>

    <div>
        <label for="duur_minuten" class="text-sm font-bold text-slate-950">Duur *</label>
        <input id="duur_minuten" name="duur_minuten" type="number" min="1" value="{{ old('duur_minuten', $behandeling->duur_minuten) }}" placeholder="Bijv. 45" required class="mt-2 h-11 w-full rounded border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">
        <x-input-error class="mt-2" :messages="$errors->get('duur_minuten')" />
    </div>

    <div>
        <label for="prijs" class="text-sm font-bold text-slate-950">Prijs *</label>
        <div class="mt-2 flex">
            <input id="prijs" name="prijs" type="number" min="0" step="0.01" value="{{ old('prijs', $behandeling->prijs) }}" placeholder="Bijv. 37,50" required class="h-11 w-full rounded-l border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">
            <span class="flex h-11 w-11 items-center justify-center rounded-r border border-l-0 border-slate-300 text-sm font-bold">&euro;</span>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('prijs')" />
    </div>

    <div class="md:col-span-2">
        <label for="volgorde" class="text-sm font-bold text-slate-950">Volgorde <span class="font-normal">(optioneel)</span></label>
        <input id="volgorde" type="number" placeholder="Bijv. 1" class="mt-2 h-11 w-full rounded border-slate-300 text-sm focus:border-[#152844] focus:ring-[#152844]">
        <p class="mt-2 text-xs text-slate-600">Wordt gebruikt om de volgorde van behandelingen te bepalen.</p>
    </div>
</div>

<div class="mt-6 flex items-center justify-between border-t border-slate-300 pt-4">
    <div>
        <div class="text-sm font-bold text-slate-950">Actief</div>
        <p class="mt-1 text-sm text-slate-950">Maak deze behandeling zichtbaar voor klanten.</p>
    </div>
    <label class="relative inline-flex cursor-pointer items-center">
        <input type="checkbox" name="actief" value="1" class="peer sr-only" @checked(old('actief', $behandeling->actief))>
        <span class="h-6 w-12 rounded-full border border-black bg-white after:absolute after:left-1 after:top-1 after:h-4 after:w-4 after:rounded-full after:bg-black after:transition peer-checked:after:translate-x-6"></span>
    </label>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const keuzes = @js($behandelingKeuzes);
        const keuzeSelect = document.getElementById('behandeling_keuze');
        const velden = {
            naam: document.getElementById('naam'),
            type: document.getElementById('type'),
            duur_minuten: document.getElementById('duur_minuten'),
            prijs: document.getElementById('prijs'),
            beschrijving: document.getElementById('beschrijving'),
        };

        keuzeSelect.addEventListener('change', () => {
            const keuze = keuzes[keuzeSelect.value];
            if (!keuze) {
                return;
            }

            Object.entries(velden).forEach(([naam, veld]) => {
                veld.value = keuze[naam] ?? '';
            });
        });
    });
</script>
