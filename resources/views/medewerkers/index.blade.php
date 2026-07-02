@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <div class="mb-8 flex items-center justify-between border-b border-[#d7c39a] pb-6">
            <div>
                <h1 class="text-4xl font-bold text-[#0f1f3a]">Medewerkers Beheer</h1>
                <p class="mt-2 text-lg text-[#0f1f3a] opacity-80">Voeg medewerkers toe, bewerk of verwijder ze</p>
            </div>
            <a href="{{ route('medewerkers.create') }}" 
               class="rounded-md px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:shadow-xl" 
               style="background: #c69a3e;">
                + Nieuwe Medewerker
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg border-2 border-green-500 bg-green-50 px-6 py-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg border-2 border-red-500 bg-red-50 px-6 py-4 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-lg border border-[#d7c39a] bg-white shadow-lg overflow-hidden">
            @if($medewerkers->count())
                <table class="w-full">
                    <thead class="bg-[#0f1f3a] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">Naam</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Telefoon</th>
                            <th class="px-6 py-4 text-right text-sm font-bold">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#d7c39a]">
                        @foreach($medewerkers as $medewerker)
                            <tr class="hover:bg-[#f8f4ea]">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#0f1f3a]">{{ $medewerker->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-[#0f1f3a]">{{ $medewerker->email }}</td>
                                <td class="px-6 py-4 text-[#0f1f3a]">{{ $medewerker->telefoon ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('medewerkers.edit', $medewerker) }}" 
                                           class="text-[#c69a3e] hover:text-[#0f1f3a] font-semibold">
                                            Bewerken
                                        </a>
                                        <form method="POST" action="{{ route('medewerkers.destroy', $medewerker) }}" 
                                              onsubmit="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center">
                    <p class="text-lg text-[#0f1f3a] opacity-70">Nog geen medewerkers toegevoegd.</p>
                    <a href="{{ route('medewerkers.create') }}" 
                       class="mt-4 inline-block rounded-md px-6 py-3 text-sm font-bold text-white shadow-lg" 
                       style="background: #c69a3e;">
                        Voeg eerste medewerker toe
                    </a>
                </div>
            @endif
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
