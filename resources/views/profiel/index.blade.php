@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-[#c69a3e] bg-[#f8f4ea] px-6 py-4 text-[#0f1f3a]">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Card -->
        <div class="rounded-lg border border-[#d7c39a] bg-white p-8 shadow-lg">
            <div class="mb-8 flex items-center justify-between border-b border-[#d7c39a] pb-6">
                <h2 class="text-3xl font-bold text-[#0f1f3a]">Mijn Profiel</h2>
                <a href="{{ route('profiel.edit') }}" 
                   class="rounded-md px-6 py-3 text-sm font-bold text-white shadow-md transition hover:shadow-lg" 
                   style="background: #c69a3e;">
                    Bewerken
                </a>
            </div>

            <div class="space-y-8">
                <!-- Persoonlijke Info -->
                <div class="border-b border-[#d7c39a] pb-6">
                    <h3 class="mb-4 text-lg font-semibold text-[#c69a3e]">Persoonlijke Informatie</h3>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Voornaam</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->voornaam ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Achternaam</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->achternaam ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Email</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Telefoon</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->telefoon ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Geboortedatum</p>
                            <p class="mt-1 text-[#0f1f3a]">
                                {{ $user->geboortedatum ? \Carbon\Carbon::parse($user->geboortedatum)->format('d-m-Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Adres Info -->
                <div class="border-b border-[#d7c39a] pb-6">
                    <h3 class="mb-4 text-lg font-semibold text-[#c69a3e]">Adresgegevens</h3>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <p class="text-sm font-semibold text-[#0f1f3a]">Adres</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->adres ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Postcode</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->postcode ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Plaats</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->plaats ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Extra Info -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-[#c69a3e]">Extra Informatie</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Allergieën</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->allergieen ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0f1f3a]">Wensen</p>
                            <p class="mt-1 text-[#0f1f3a]">{{ $user->wensen ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
