@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 800px;">
        <div class="mb-8 flex items-center justify-between border-b border-[#d7c39a] pb-6">
            <div>
                <h1 class="text-4xl font-bold text-[#0f1f3a]">Nieuwe Medewerker</h1>
                <p class="mt-2 text-lg text-[#0f1f3a] opacity-80">Voeg een nieuwe medewerker toe</p>
            </div>
            <a href="{{ route('medewerkers.index') }}" 
               class="text-sm font-semibold text-[#0f1f3a] hover:text-[#c69a3e]">
                ← Terug
            </a>
        </div>

        <div class="rounded-lg border border-[#d7c39a] bg-white p-8 shadow-lg">
            <form method="POST" action="{{ route('medewerkers.store') }}">
                @csrf

                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="voornaam" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Voornaam <span class="text-red-500">*</span>
                            </label>
                            <input id="voornaam" type="text" name="voornaam" value="{{ old('voornaam') }}" required 
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('voornaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="achternaam" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Achternaam <span class="text-red-500">*</span>
                            </label>
                            <input id="achternaam" type="text" name="achternaam" value="{{ old('achternaam') }}" required 
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('achternaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telefoon" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Telefoon
                        </label>
                        <input id="telefoon" type="tel" name="telefoon" value="{{ old('telefoon') }}" 
                               placeholder="0612345678"
                               class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                        @error('telefoon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Wachtwoord <span class="text-red-500">*</span>
                        </label>
                        <input id="password" type="password" name="password" required 
                               class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Bevestig Wachtwoord <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                               class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-[#d7c39a] pt-6">
                    <a href="{{ route('medewerkers.index') }}" 
                       class="rounded-md border-2 border-[#d7c39a] px-6 py-3 text-sm font-bold text-[#0f1f3a] transition hover:bg-[#f8f4ea]">
                        Annuleren
                    </a>
                    <button type="submit" 
                            class="rounded-md px-8 py-4 text-sm font-bold text-white shadow-lg transition hover:shadow-xl" 
                            style="background: #c69a3e;">
                        Medewerker Toevoegen
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
