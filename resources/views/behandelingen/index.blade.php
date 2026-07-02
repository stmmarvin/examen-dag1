<x-app-layout>
    <x-slot name="header">
        {{-- Header van mijn behandeling overzicht. --}}
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Behandelingsoverzicht</h2>
            <a href="{{ route('behandelingen.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Nieuwe behandeling
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{{ session('error') }}</div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                {{-- Zoek en filter formulier. --}}
                <form method="GET" action="{{ route('behandelingen.index') }}" class="grid gap-4 md:grid-cols-[1fr_220px_auto]">
                    <div>
                        <x-input-label for="zoek" value="Zoeken" />
                        <x-text-input id="zoek" name="zoek" type="search" class="mt-1 block w-full" :value="$zoekterm" placeholder="Zoek op naam, type of beschrijving" />
                    </div>

                    <div>
                        <x-input-label for="type" value="Type" />
                        <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Alle types</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" @selected($geselecteerdType === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <x-primary-button>Zoeken</x-primary-button>
                        <a href="{{ route('behandelingen.index') }}" class="pb-2 text-sm text-gray-600 hover:text-gray-900">Reset</a>
                    </div>
                </form>

                <div class="mt-6 overflow-x-auto">
                    @if ($behandelingen->count())
                        {{-- Tabel met alle behandelingen. --}}
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Naam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Duur</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prijs</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($behandelingen as $behandeling)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900">{{ $behandeling->naam }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $behandeling->type }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $behandeling->duur_minuten }} min</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">&euro; {{ number_format((float) $behandeling->prijs, 2, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $behandeling->actief ? 'Actief' : 'Inactief' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                            <a href="{{ route('behandelingen.show', $behandeling) }}" class="text-indigo-600 hover:text-indigo-900">Bekijken</a>
                                            <a href="{{ route('behandelingen.edit', $behandeling) }}" class="ml-3 text-indigo-600 hover:text-indigo-900">Wijzigen</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">{{ $behandelingen->links() }}</div>
                    @else
                        {{-- Melding als er geen behandelingen zijn. --}}
                        <p class="rounded-md bg-gray-50 p-4 text-sm text-gray-700">
                            {{ $zoekterm !== '' || $geselecteerdType !== '' ? 'Geen resultaten gevonden' : 'Geen behandelingen gevonden' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
