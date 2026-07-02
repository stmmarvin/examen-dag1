<x-app-layout>
    <div class="flex min-h-[calc(100vh-76px)]">
        @include('medewerkers.partials.sidebar', ['active' => 'delete', 'actieMedewerker' => $medewerker])

        <section class="min-w-0 flex-1 px-10 py-9">
            @include('medewerkers.partials.flash')

            <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id]) }}" class="text-sm">← Terug naar medewerkers</a>

            <div class="mt-6">
                <h1 class="text-3xl font-bold">Medewerker verwijderen</h1>
                <p class="mt-2 text-sm">Weet je zeker dat je deze medewerker wilt verwijderen?</p>
            </div>

            <div class="mt-6 max-w-[760px] rounded border border-gray-400 p-6">
                <h2 class="text-2xl font-bold">Medewerkerdetails</h2>

                <div class="mt-6 flex min-w-0 gap-6">
                    <span class="h-20 w-20 shrink-0 rounded-full border border-black"></span>
                    <div class="min-w-0">
                        <h3 class="break-words text-2xl font-bold">{{ $medewerker->name }}</h3>
                        <p class="mt-3 break-words text-sm">{{ $medewerker->telefoon ?? '-' }} · <span class="break-all">{{ $medewerker->email }}</span></p>
                        <p class="mt-4 text-sm">Rol: {{ $medewerker->rolename }}</p>
                    </div>
                </div>

                <dl class="mt-8 grid grid-cols-[140px_minmax(0,1fr)] gap-x-4 gap-y-3 text-sm">
                    <dt class="font-bold">Status</dt>
                    <dd class="min-w-0 break-words">Actief</dd>
                    <dt class="font-bold">Toekomstige afspraken</dt>
                    <dd class="min-w-0 break-words">{{ $hasAppointments ? 'Ja' : 'Nee' }}</dd>
                </dl>

                @if($hasAppointments)
                    <div class="mt-7 rounded border border-orange-400 bg-orange-50 px-6 py-5 text-sm text-orange-900">
                        Deze medewerker heeft nog toekomstige afspraken en kan daarom niet worden verwijderd.
                    </div>
                @endif

+                <div class="mt-7 rounded-2xl border border-amber-300 bg-amber-50 px-6 py-5 text-sm text-amber-950 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-200 text-base font-bold text-amber-900">!</span>
                        <div>
                            <p class="text-base font-bold">Verwijderen bevestigen</p>
                            <p class="mt-2 leading-6">Deze medewerker verdwijnt uit het overzicht en kan daarna niet meer worden ingepland.</p>
                            @if(! $hasAppointments)
                                <p class="mt-2 leading-6">Als je doorgaat, wordt het account direct verwijderd.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('medewerkers.destroy', $medewerker) }}" class="mt-6 flex justify-end gap-4">
                @csrf
                @method('DELETE')
                <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id]) }}" class="rounded border border-gray-400 px-10 py-3 text-sm font-bold">
                    Annuleren
                </a>
                <button @disabled($hasAppointments) class="rounded bg-red-600 px-8 py-3 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-50">
                    Medewerker verwijderen
                </button>
            </form>
        </section>
    </div>
</x-app-layout>
