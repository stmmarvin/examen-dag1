<x-app-layout>
    <div class="flex min-h-[calc(100vh-76px)]">
        @include('medewerkers.partials.sidebar', ['active' => 'index'])

        <section class="flex-1 px-10 py-9">
            @include('medewerkers.partials.flash')

            <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Medewerkers</h1>
                    <p class="mt-2 text-sm">Bekijk welke medewerkers in dienst zijn.</p>
                </div>

                <form method="GET" action="{{ route('medewerkers.index') }}" class="flex gap-4">
                    <!-- Zoek op naam, telefoon, e-mail, personeelsnummer of functie. -->
                    <input name="zoek" value="{{ $zoekterm }}" placeholder="Zoek medewerker op naam, telefoon of e-mail..." class="h-11 w-[440px] rounded border-gray-400">
                    <a href="{{ route('medewerkers.create') }}" class="flex h-11 items-center rounded bg-black px-5 text-sm font-bold text-white">
                        + Nieuwe medewerker
                    </a>
                </form>
            </div>

            <div class="mt-5 grid min-h-[590px] grid-cols-[300px_1fr] rounded border border-gray-400">
                <div class="border-r border-gray-400">
                    <h2 class="px-5 py-5 text-sm font-bold">Alle medewerkers ({{ $medewerkers->count() }})</h2>

                    @forelse ($medewerkers as $medewerker)
                        <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id, 'zoek' => $zoekterm]) }}" class="flex gap-5 border-t border-gray-300 px-5 py-4 {{ optional($geselecteerdeMedewerker)->id === $medewerker->id ? 'bg-gray-200' : '' }}">
                            <span class="mt-1 h-9 w-9 rounded-full border border-black"></span>
                            <span>
                                <span class="block font-bold">{{ $medewerker->gebruiker->volledige_naam }}</span>
                                <span class="block text-sm">{{ $medewerker->functie }}</span>
                            </span>
                        </a>
                    @empty
                        <p class="border-t border-gray-300 px-5 py-4 text-sm font-semibold">Er zijn nog geen medewerkers geregistreerd</p>
                    @endforelse
                </div>

                <div class="px-6 py-6">
                    @if ($geselecteerdeMedewerker)
                        <div class="flex items-start justify-between">
                            <div class="flex gap-6">
                                <span class="h-20 w-20 rounded-full border border-black"></span>
                                <div>
                                    <h2 class="text-2xl font-bold">{{ $geselecteerdeMedewerker->gebruiker->volledige_naam }}</h2>
                                    <p class="mt-3 text-sm">
                                        {{ $geselecteerdeMedewerker->gebruiker->telefoon }} · {{ $geselecteerdeMedewerker->gebruiker->email }}
                                    </p>
                                    <p class="mt-4 text-sm">
                                        In dienst sinds:
                                        {{ optional($geselecteerdeMedewerker->in_dienst_sinds)->translatedFormat('d F Y') ?? 'Onbekend' }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('medewerkers.edit', $geselecteerdeMedewerker) }}" class="rounded border border-gray-400 px-10 py-3 text-sm font-bold">
                                Bewerken
                            </a>
                        </div>

                        <div class="mt-8 border-y border-gray-400">
                            <div class="flex gap-8 text-sm font-bold">
                                <span class="border-b-2 border-black py-5">Overzicht</span>
                                <span class="py-5">Specialisaties</span>
                                <span class="py-5">Afspraken</span>
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div class="rounded border border-gray-400 p-5">
                                <h3 class="text-lg font-bold">Persoonlijke gegevens</h3>
                                <dl class="mt-5 grid grid-cols-[160px_1fr] gap-y-3 text-sm">
                                    <dt class="font-bold">Naam</dt>
                                    <dd>{{ $geselecteerdeMedewerker->gebruiker->volledige_naam }}</dd>
                                    <dt class="font-bold">Telefoon</dt>
                                    <dd>{{ $geselecteerdeMedewerker->gebruiker->telefoon }}</dd>
                                    <dt class="font-bold">E-mail</dt>
                                    <dd>{{ $geselecteerdeMedewerker->gebruiker->email }}</dd>
                                    <dt class="font-bold">Status</dt>
                                    <dd>{{ $geselecteerdeMedewerker->statusTekst() }}</dd>
                                </dl>
                            </div>

                            <div class="rounded border border-gray-400 p-5">
                                <h3 class="text-lg font-bold">Werkgegevens</h3>
                                <dl class="mt-5 grid grid-cols-[160px_1fr] gap-y-3 text-sm">
                                    <dt class="font-bold">Functie</dt>
                                    <dd>{{ $geselecteerdeMedewerker->functie }}</dd>
                                    <dt class="font-bold">Specialisatie</dt>
                                    <dd>{{ $geselecteerdeMedewerker->specialisatiesTekst() ?: 'Geen' }}</dd>
                                    <dt class="font-bold">Werkdagen</dt>
                                    <dd>{{ $geselecteerdeMedewerker->werkdagen }}</dd>
                                    <dt class="font-bold">Werktijd</dt>
                                    <dd>{{ $geselecteerdeMedewerker->werktijden }}</dd>
                                </dl>
                            </div>
                        </div>
                    @else
                        <div class="flex h-full items-center justify-center text-sm font-semibold">
                            Er zijn nog geen medewerkers geregistreerd
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
