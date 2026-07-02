<x-app-layout>
    <div class="flex min-h-[calc(100vh-76px)]">
        @include('medewerkers.partials.sidebar', ['active' => 'delete'])

        <section class="flex-1 px-10 py-9">
            @include('medewerkers.partials.flash')

            <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id]) }}" class="text-sm">← Terug naar medewerkers</a>

            <div class="mt-6">
                <h1 class="text-3xl font-bold">Medewerker verwijderen</h1>
                <p class="mt-2 text-sm">Weet je zeker dat je deze medewerker wilt verwijderen?</p>
            </div>

            <div class="mt-6 max-w-[760px] rounded border border-gray-400 p-6">
                <h2 class="text-2xl font-bold">Medewerkerdetails</h2>

                <div class="mt-6 flex gap-6">
                    <span class="h-20 w-20 shrink-0 rounded-full border border-black"></span>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $medewerker->volledige_naam }}</h3>
                        <p class="mt-3 text-sm">{{ $medewerker->telefoon }} · {{ $medewerker->email }}</p>
                        <p class="mt-4 text-sm">
                            In dienst sinds:
                            {{ optional($medewerker->in_dienst_sinds)->translatedFormat('d F Y') ?? 'Onbekend' }}
                        </p>
                    </div>
                </div>

                <dl class="mt-8 grid grid-cols-[160px_1fr] gap-y-3 text-sm">
                    <dt class="font-bold">Functie</dt>
                    <dd>{{ $medewerker->functie }}</dd>
                    <dt class="font-bold">Status</dt>
                    <dd>{{ $medewerker->status }}</dd>
                    <dt class="font-bold">Specialisatie</dt>
                    <dd>{{ $medewerker->specialisatiesTekst() ?: 'Geen' }}</dd>
                    <dt class="font-bold">Toekomstige afspraken</dt>
                    <dd>{{ $toekomstigeAfspraken }}</dd>
                </dl>

                <div class="mt-7 flex gap-5 rounded border border-red-500 px-6 py-5 text-sm">
                    <span class="flex h-7 w-7 items-center justify-center border border-red-500 font-bold text-red-600">!</span>
                    <div>
                        <p class="font-bold">Let op: deze actie is onomkeerbaar</p>
                        <p class="mt-3">De medewerker wordt verwijderd uit het overzicht en kan niet meer worden ingepland.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('medewerkers.destroy', $medewerker) }}" class="mt-6 flex justify-end gap-4">
                @csrf
                @method('DELETE')
                <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id]) }}" class="rounded border border-gray-400 px-10 py-3 text-sm font-bold">
                    Annuleren
                </a>
                <button class="rounded bg-red-600 px-8 py-3 text-sm font-bold text-white">
                    Medewerker verwijderen
                </button>
            </form>
        </section>
    </div>
</x-app-layout>
