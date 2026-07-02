@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <h1 class="mb-2 text-4xl font-bold text-[#0f1f3a]">Welkom bij Kniploket Tiko</h1>
        <p class="mb-8 text-lg text-[#0f1f3a] opacity-80">Beheer je afspraken, behandelingen en profiel</p>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Mijn Afspraken -->
            <a href="{{ route('appointments.edit-as-client') }}" class="group block rounded-lg border-2 border-[#d7c39a] bg-white p-8 shadow-md transition hover:border-[#c69a3e] hover:shadow-xl">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#f8f4ea]">
                    <svg class="h-8 w-8 text-[#c69a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-[#0f1f3a]">Mijn Afspraken</h3>
                <p class="text-sm text-[#0f1f3a] opacity-70">Bekijk en beheer je gemaakte afspraken</p>
            </a>

            <!-- Afspraak Maken -->
            <a href="{{ route('appointments.create-as-client') }}" class="group block rounded-lg border-2 border-[#d7c39a] bg-white p-8 shadow-md transition hover:border-[#c69a3e] hover:shadow-xl">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#f8f4ea]">
                    <svg class="h-8 w-8 text-[#c69a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-[#0f1f3a]">Afspraak Maken</h3>
                <p class="text-sm text-[#0f1f3a] opacity-70">Maak een nieuwe afspraak bij Kniploket Tiko</p>
            </a>

            <!-- Behandelingen -->
            <a href="{{ route('behandelingen.index') }}" class="group block rounded-lg border-2 border-[#d7c39a] bg-white p-8 shadow-md transition hover:border-[#c69a3e] hover:shadow-xl">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#f8f4ea]">
                    <svg class="h-8 w-8 text-[#c69a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-[#0f1f3a]">Behandelingen</h3>
                <p class="text-sm text-[#0f1f3a] opacity-70">Bekijk ons aanbod aan behandelingen</p>
            </a>

            <!-- Mijn Profiel -->
            <a href="{{ route('profiel.index') }}" class="group block rounded-lg border-2 border-[#d7c39a] bg-white p-8 shadow-md transition hover:border-[#c69a3e] hover:shadow-xl">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#f8f4ea]">
                    <svg class="h-8 w-8 text-[#c69a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-[#0f1f3a]">Mijn Profiel</h3>
                <p class="text-sm text-[#0f1f3a] opacity-70">Beheer je persoonlijke gegevens</p>
            </a>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
