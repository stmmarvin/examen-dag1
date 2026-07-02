<x-app-layout>
    <x-slot name="header">
        {{-- Detailpagina van een behandeling. --}}
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $behandeling->naam }}</h2>
            <a href="{{ route('behandelingen.edit', $behandeling) }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Wijzigen
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                {{-- Alle gegevens van de behandeling. --}}
                <dl class="grid gap-6 md:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-gray-900">{{ $behandeling->type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-gray-900">{{ $behandeling->actief ? 'Actief' : 'Inactief' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Duur</dt>
                        <dd class="mt-1 text-gray-900">{{ $behandeling->duur_minuten }} minuten</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Prijs</dt>
                        <dd class="mt-1 text-gray-900">€ {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Beschrijving</dt>
                        <dd class="mt-1 whitespace-pre-line text-gray-900">{{ $behandeling->beschrijving ?: 'Geen beschrijving beschikbaar' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Aanvullende informatie</dt>
                        <dd class="mt-1 whitespace-pre-line text-gray-900">{{ $behandeling->aanvullende_informatie ?: 'Geen aanvullende informatie beschikbaar' }}</dd>
                    </div>
                </dl>

                {{-- Terug en verwijderen acties. --}}
                <div class="mt-8 flex items-center justify-between border-t border-gray-200 pt-6">
                    <a href="{{ route('behandelingen.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Terug naar overzicht</a>

                    <form method="POST" action="{{ route('behandelingen.destroy', $behandeling) }}" onsubmit="return confirm('Weet je zeker dat je deze behandeling wilt verwijderen?')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Verwijderen</x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
