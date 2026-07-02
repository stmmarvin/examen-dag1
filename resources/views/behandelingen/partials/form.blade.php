@csrf

{{-- Formulier voor behandeling toevoegen en wijzigen. --}}
<div class="grid gap-6 md:grid-cols-2">
    {{-- Keuze vult automatisch de velden in. --}}
    <div class="md:col-span-2">
        <x-input-label for="behandeling_keuze" value="Kies standaardbehandeling" />
        <select id="behandeling_keuze" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Zelf invullen</option>
            @foreach ($behandelingKeuzes as $index => $keuze)
                <option value="{{ $index }}">{{ $keuze['naam'] }} - {{ $keuze['type'] }} (&euro; {{ number_format((float) $keuze['prijs'], 2, ',', '.') }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="naam" value="Naam" />
        <x-text-input id="naam" name="naam" type="text" class="mt-1 block w-full" :value="old('naam', $behandeling->naam)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('naam')" />
    </div>

    <div>
        <x-input-label for="type" value="Type" />
        <x-text-input id="type" name="type" type="text" class="mt-1 block w-full" :value="old('type', $behandeling->type)" required />
        <x-input-error class="mt-2" :messages="$errors->get('type')" />
    </div>

    <div>
        <x-input-label for="duur_minuten" value="Duur in minuten" />
        <x-text-input id="duur_minuten" name="duur_minuten" type="number" min="1" class="mt-1 block w-full" :value="old('duur_minuten', $behandeling->duur_minuten)" required />
        <x-input-error class="mt-2" :messages="$errors->get('duur_minuten')" />
    </div>

    <div>
        <x-input-label for="prijs" value="Prijs" />
        <x-text-input id="prijs" name="prijs" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('prijs', $behandeling->prijs)" required />
        <x-input-error class="mt-2" :messages="$errors->get('prijs')" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="beschrijving" value="Beschrijving" />
        <textarea id="beschrijving" name="beschrijving" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('beschrijving', $behandeling->beschrijving) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('beschrijving')" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="aanvullende_informatie" value="Aanvullende informatie" />
        <textarea id="aanvullende_informatie" name="aanvullende_informatie" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('aanvullende_informatie', $behandeling->aanvullende_informatie) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('aanvullende_informatie')" />
    </div>

    <label class="flex items-center gap-2 md:col-span-2">
        <input type="checkbox" name="actief" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('actief', $behandeling->actief))>
        <span class="text-sm text-gray-700">Actief zichtbaar maken</span>
    </label>
</div>

{{-- Knoppen om op te slaan of terug te gaan. --}}
<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Opslaan</x-primary-button>
    <a href="{{ route('behandelingen.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuleren</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Vult het formulier met de gekozen standaardbehandeling.
        const keuzes = @js($behandelingKeuzes);
        const keuzeSelect = document.getElementById('behandeling_keuze');

        const velden = {
            naam: document.getElementById('naam'),
            type: document.getElementById('type'),
            duur_minuten: document.getElementById('duur_minuten'),
            prijs: document.getElementById('prijs'),
            beschrijving: document.getElementById('beschrijving'),
            aanvullende_informatie: document.getElementById('aanvullende_informatie'),
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
