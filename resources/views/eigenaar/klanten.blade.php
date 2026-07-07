@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <div class="mb-8 flex flex-col gap-4 border-b border-[#d7c39a] pb-6 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-bold text-[#0f1f3a]">Klanten Overzicht</h1>
                <p class="mt-2 text-lg text-[#0f1f3a] opacity-80">Bekijk alle geregistreerde klanten van Kniploket Tiko</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center rounded-md border border-[#d7c39a] px-5 py-3 text-sm font-bold text-[#0f1f3a] transition hover:bg-[#f8f4ea]">
                Terug naar dashboard
            </a>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-[#d7c39a] bg-white p-5 shadow">
                <p class="text-sm font-semibold text-[#0f1f3a] opacity-70">Totaal klanten</p>
                <p class="mt-2 text-3xl font-bold text-[#0f1f3a]">{{ $klanten->count() }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-[#d7c39a] bg-white shadow-lg">
            @if($klanten->count())
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px]">
                        <thead class="bg-[#0f1f3a] text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold">Naam</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Telefoon</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Woonplaats</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Geregistreerd</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#d7c39a]">
                            @foreach($klanten as $klant)
                                @php
                                    $volledigeNaam = trim(($klant->voornaam ?? '') . ' ' . ($klant->achternaam ?? ''));
                                    $weergaveNaam = $volledigeNaam !== '' ? $volledigeNaam : 'Klant #' . $klant->id;
                                @endphp
                                <tr class="hover:bg-[#f8f4ea]">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-[#0f1f3a]">{{ $weergaveNaam }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-[#0f1f3a]">{{ $klant->email }}</td>
                                    <td class="px-6 py-4 text-[#0f1f3a]">{{ $klant->telefoon ?? '-' }}</td>
                                    <td class="px-6 py-4 text-[#0f1f3a]">
                                        @if($klant->postcode || $klant->plaats)
                                            {{ trim(($klant->postcode ?? '') . ' ' . ($klant->plaats ?? '')) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-[#0f1f3a]">
                                        {{ $klant->created_at ? \Carbon\Carbon::parse($klant->created_at)->format('d-m-Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <p class="text-lg font-semibold text-[#0f1f3a]">Nog geen klanten gevonden.</p>
                    <p class="mt-2 text-sm text-[#0f1f3a] opacity-70">Zodra klanten zich registreren, verschijnen ze hier.</p>
                </div>
            @endif
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
