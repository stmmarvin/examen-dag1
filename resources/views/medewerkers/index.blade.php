<x-app-layout>
    <div class="flex min-h-[calc(100vh-76px)]">
        @include('medewerkers.partials.sidebar', ['active' => 'index'])

        <section class="min-w-0 flex-1 px-10 py-9">
            @include('medewerkers.partials.flash')

            <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Medewerkers</h1>
                    <p class="mt-2 text-sm">Bekijk welke medewerkers in dienst zijn.</p>
                </div>

                <form method="GET" action="{{ route('medewerkers.index') }}" class="flex flex-wrap gap-4">
                    <!-- Zoek op naam, telefoon, e-mail, personeelsnummer of functie. -->
                    <input name="zoek" value="{{ $zoekterm }}" placeholder="Zoek medewerker op naam, telefoon of e-mail..." class="h-11 w-full rounded border-gray-400 sm:w-[440px]">
                    <a href="{{ route('medewerkers.create') }}" class="flex h-11 items-center rounded bg-black px-5 text-sm font-bold text-white">
                        + Nieuwe medewerker
                    </a>
                </form>
            </div>

            <div class="mt-5 grid min-h-[590px] grid-cols-1 rounded border border-gray-400 xl:grid-cols-[300px_minmax(0,1fr)]">
                <div class="border-b border-gray-400 xl:border-b-0 xl:border-r">
                    <h2 class="px-5 py-5 text-sm font-bold">Alle medewerkers ({{ $medewerkers->count() }})</h2>

                    @forelse ($medewerkers as $medewerker)
                        <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id, 'zoek' => $zoekterm]) }}" class="flex min-w-0 gap-4 border-t border-gray-300 px-5 py-4 {{ optional($geselecteerdeMedewerker)->id === $medewerker->id ? 'bg-gray-200' : '' }}">
                            <span class="mt-1 h-9 w-9 rounded-full border border-black"></span>
                            <span class="min-w-0">
                                <span class="block truncate font-bold">{{ $medewerker->gebruiker->volledige_naam }}</span>
                                <span class="block truncate text-sm">{{ $medewerker->functie }} · {{ $medewerker->statusTekst() }}</span>
                                <span class="block truncate text-xs text-gray-700">{{ $medewerker->gebruiker->email }}</span>
                                <span class="block truncate text-xs text-gray-700">{{ $medewerker->specialisatiesTekst() ?: 'Geen specialisatie' }}</span>
                            </span>
                        </a>
                    @empty
                        <p class="border-t border-gray-300 px-5 py-4 text-sm font-semibold">Er zijn nog geen medewerkers geregistreerd</p>
                    @endforelse
                </div>

                <div class="min-w-0 px-6 py-6">
                    @if ($geselecteerdeMedewerker)
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div class="flex min-w-0 gap-6">
                                <span class="h-20 w-20 rounded-full border border-black"></span>
                                <div class="min-w-0">
                                    <h2 class="break-words text-2xl font-bold">{{ $geselecteerdeMedewerker->gebruiker->volledige_naam }}</h2>
                                    <p class="mt-3 break-words text-sm">
                                        {{ $geselecteerdeMedewerker->gebruiker->telefoon }} · {{ $geselecteerdeMedewerker->gebruiker->email }}
                                    </p>
                                    <p class="mt-4 text-sm">
                                        In dienst sinds:
                                        {{ optional($geselecteerdeMedewerker->in_dienst_sinds)->translatedFormat('d F Y') ?? 'Onbekend' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex shrink-0 flex-wrap gap-3">
                                <a href="{{ route('medewerkers.edit', $geselecteerdeMedewerker) }}" class="rounded border border-gray-400 px-10 py-3 text-sm font-bold">
                                    Wijzigen
                                </a>
                                <a href="{{ route('medewerkers.delete', $geselecteerdeMedewerker) }}" class="rounded border border-gray-400 px-8 py-3 text-sm font-bold text-red-600">
                                    Verwijderen
                                </a>
                            </div>
                        </div>

                        <div class="mt-8 border-y border-gray-400 py-5 text-sm font-bold">
                            Overzicht
                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-4 2xl:grid-cols-2">
                            <div class="rounded border border-gray-400 p-5">
                                <h3 class="text-lg font-bold">Persoonlijke gegevens</h3>
                                <dl class="mt-5 grid grid-cols-[110px_minmax(0,1fr)] gap-x-4 gap-y-3 text-sm">
                                    <dt class="font-bold">Naam</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->gebruiker->volledige_naam }}</dd>
                                    <dt class="font-bold">Telefoon</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->gebruiker->telefoon }}</dd>
                                    <dt class="font-bold">E-mail</dt>
                                    <dd class="min-w-0 break-all">{{ $geselecteerdeMedewerker->gebruiker->email }}</dd>
                                    <dt class="font-bold">Status</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->statusTekst() }}</dd>
                                </dl>
                            </div>

                            <div class="rounded border border-gray-400 p-5">
                                <h3 class="text-lg font-bold">Werkgegevens</h3>
                                <dl class="mt-5 grid grid-cols-[110px_minmax(0,1fr)] gap-x-4 gap-y-3 text-sm">
                                    <dt class="font-bold">Functie</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->functie }}</dd>
                                    <dt class="font-bold">Specialisatie</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->specialisatiesTekst() ?: 'Geen' }}</dd>
                                    <dt class="font-bold">Werkdagen</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->werkdagen }}</dd>
                                    <dt class="font-bold">Werktijd</dt>
                                    <dd class="min-w-0 break-words">{{ $geselecteerdeMedewerker->werktijden }}</dd>
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
