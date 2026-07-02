<x-app-layout>
    <div class="flex min-h-[calc(100vh-76px)]">
        @include('medewerkers.partials.sidebar', ['active' => 'edit', 'actieMedewerker' => $medewerker])

        <section class="flex-1 px-10 py-9">
            @include('medewerkers.partials.flash')

            <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id]) }}" class="text-sm">← Terug naar medewerkers</a>

            <div class="mt-20">
                <h1 class="text-3xl font-bold">Medewerkergegevens bewerken</h1>
                <p class="mt-2 text-sm">Pas de gegevens en specialisaties van de medewerker aan.</p>
            </div>

            <form method="POST" action="{{ route('medewerkers.update', $medewerker) }}" class="mt-6">
                @csrf
                @method('PUT')
                @include('medewerkers.partials.form')

                <div class="mt-6 flex justify-end gap-4">
                    <a href="{{ route('medewerkers.index', ['medewerker' => $medewerker->id]) }}" class="rounded border border-gray-400 px-10 py-3 text-sm font-bold">
                        Annuleren
                    </a>
                    <button class="rounded bg-black px-8 py-3 text-sm font-bold text-white">
                        Opslaan
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
