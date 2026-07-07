<x-app-layout>
    <div class="mx-auto max-w-4xl px-6 py-10">
        <h1 class="text-3xl font-bold text-[#0f1f3a]">Afspraak</h1>
        <div class="mt-6 rounded-xl border border-[#d7c39a] bg-white p-6 shadow-sm">
            <p class="text-sm text-[#0f1f3a]">Klant: {{ $appointment->client?->full_name ?? 'Onbekend' }}</p>
            <p class="mt-2 text-sm text-[#0f1f3a]">Medewerker: {{ $appointment->employee?->name ?? 'Onbekend' }}</p>
            <p class="mt-2 text-sm text-[#0f1f3a]">Behandeling: {{ $appointment->treatment?->name ?? 'Onbekend' }}</p>
            <p class="mt-2 text-sm text-[#0f1f3a]">Datum: {{ $appointment->appointment_date }}</p>
        </div>
    </div>
</x-app-layout>
