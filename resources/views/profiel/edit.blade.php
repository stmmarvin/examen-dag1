@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <!-- Edit Form -->
        <div class="rounded-lg border border-[#d7c39a] bg-white p-8 shadow-lg">
            <div class="mb-8 flex items-center justify-between border-b border-[#d7c39a] pb-6">
                <h2 class="text-3xl font-bold text-[#0f1f3a]">Profiel Bewerken</h2>
                <a href="{{ route('profiel.index') }}" 
                   class="text-sm font-semibold text-[#0f1f3a] hover:text-[#c69a3e]">
                    ← Terug naar profiel
                </a>
            </div>

            <form method="POST" action="{{ route('profiel.update') }}">
                @csrf
                @method('PATCH')

                <!-- Persoonlijke Info -->
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-[#c69a3e]">Persoonlijke Informatie</h3>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="voornaam" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Voornaam <span class="text-red-500">*</span>
                            </label>
                            <input id="voornaam" type="text" name="voornaam" value="{{ old('voornaam', $user->voornaam) }}" required 
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('voornaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="achternaam" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Achternaam <span class="text-red-500">*</span>
                            </label>
                            <input id="achternaam" type="text" name="achternaam" value="{{ old('achternaam', $user->achternaam) }}" required 
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('achternaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefoon" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Telefoon
                            </label>
                            <input id="telefoon" type="tel" name="telefoon" value="{{ old('telefoon', $user->telefoon) }}" 
                                   placeholder="0612345678" pattern="(06|\+316)[0-9]{8}"
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('telefoon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="geboortedatum" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Geboortedatum
                            </label>
                            <input id="geboortedatum" type="date" name="geboortedatum" value="{{ old('geboortedatum', $user->geboortedatum) }}" 
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('geboortedatum')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Adres Info -->
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-[#c69a3e]">Adresgegevens</h3>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="adres" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Adres
                            </label>
                            <input id="adres" type="text" name="adres" value="{{ old('adres', $user->adres) }}" 
                                   placeholder="Straatnaam 123"
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('adres')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postcode" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Postcode
                            </label>
                            <input id="postcode" type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}" 
                                   placeholder="1234AB" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}"
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('postcode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="plaats" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Plaats
                            </label>
                            <input id="plaats" type="text" name="plaats" value="{{ old('plaats', $user->plaats) }}" 
                                   placeholder="Amsterdam"
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            @error('plaats')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Extra Info -->
                <div class="mb-8">
                    <h3 class="mb-4 text-lg font-semibold text-[#c69a3e]">Extra Informatie</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="allergieen" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Allergieën
                            </label>
                            <textarea id="allergieen" name="allergieen" rows="3" 
                                      placeholder="Bijvoorbeeld: noten, parfum, etc."
                                      class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">{{ old('allergieen', $user->allergieen) }}</textarea>
                            @error('allergieen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="wensen" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Wensen
                            </label>
                            <textarea id="wensen" name="wensen" rows="3" 
                                      placeholder="Speciale wensen of opmerkingen"
                                      class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">{{ old('wensen', $user->wensen) }}</textarea>
                            @error('wensen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between border-t border-[#d7c39a] pt-6">
                    <button type="submit" 
                            class="rounded-md px-8 py-4 text-sm font-bold text-white shadow-lg transition hover:shadow-xl" 
                            style="background: #c69a3e;">
                        Opslaan
                    </button>

                    <button type="button" onclick="if(confirm('Weet je zeker dat je je account wilt verwijderen?')) document.getElementById('delete-form').submit();"
                            class="text-sm font-semibold text-red-600 hover:text-red-700">
                        Account verwijderen
                    </button>
                </div>
            </form>

            <!-- Delete Form (hidden) -->
            <form id="delete-form" method="POST" action="{{ route('profiel.destroy') }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
