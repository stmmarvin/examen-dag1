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
                                   pattern=".+@(outlook\.nl|hotmail\.(com|nl)|gmail\.com)"
                                   title="Email moet eindigen op @outlook.nl, @hotmail.com, @hotmail.nl of @gmail.com"
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
                                   title="Telefoonnummer moet een Nederlands nummer zijn (06... of +316...)"
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
                                   placeholder="1234AB" pattern="[1-9][0-9]{3}[a-zA-Z]{2}" maxlength="6"
                                   title="Postcode moet exact 4 cijfers gevolgd door 2 letters zijn (bijv. 1234AB)"
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

                    <button type="button" onclick="openDeleteModal()"
                            class="text-sm font-semibold text-red-600 hover:text-red-700">
                        Account verwijderen
                    </button>
                </div>
            </form>

            <!-- Delete Modal -->
            <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                <div class="mx-4 w-full max-w-md rounded-lg bg-white p-8 shadow-2xl">
                    <h3 class="mb-4 text-2xl font-bold text-[#0f1f3a]">Account Verwijderen</h3>
                    <p class="mb-6 text-[#0f1f3a]">Weet je zeker dat je je account wilt verwijderen?</p>
                    
                    <div class="mb-6 rounded-lg border-2 border-[#c69a3e] bg-[#f8f4ea] p-6">
                        <p class="mb-2 text-sm font-semibold text-[#0f1f3a]">Verificatie Code:</p>
                        <p id="verificationCode" class="text-3xl font-bold text-[#c69a3e]">----</p>
                        <p class="mt-2 text-xs text-[#0f1f3a]">Vul deze code hieronder in om te bevestigen</p>
                    </div>

                    <form id="delete-form" method="POST" action="{{ route('profiel.destroy') }}">
                        @csrf
                        @method('DELETE')
                        
                        <div class="mb-6">
                            <label for="verification_code" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                                Voer verificatie code in:
                            </label>
                            <input type="text" name="verification_code" id="verification_code" 
                                   maxlength="4" pattern="[0-9]{4}" required
                                   class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 text-center text-2xl font-bold focus:border-[#c69a3e] focus:outline-none"
                                   placeholder="0000">
                            <p id="codeError" class="mt-2 hidden text-sm text-red-600">Verkeerde code! Probeer opnieuw.</p>
                        </div>

                        <div class="flex gap-4">
                            <button type="button" onclick="closeDeleteModal()" 
                                    class="flex-1 rounded-md border-2 border-[#d7c39a] px-6 py-3 text-sm font-bold text-[#0f1f3a] transition hover:bg-[#f8f4ea]">
                                Annuleren
                            </button>
                            <button type="submit" 
                                    class="flex-1 rounded-md bg-red-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-red-700">
                                Verwijder Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                let generatedCode = null;

                async function openDeleteModal() {
                    const modal = document.getElementById('deleteModal');
                    const codeDisplay = document.getElementById('verificationCode');
                    const codeInput = document.getElementById('verification_code');
                    const errorMsg = document.getElementById('codeError');
                    
                    // Generate verification code
                    try {
                        const response = await fetch('{{ route("profiel.delete-confirm") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const data = await response.json();
                        generatedCode = data.code;
                        codeDisplay.textContent = data.code;
                    } catch (error) {
                        console.error('Error generating code:', error);
                        return;
                    }
                    
                    // Reset form
                    codeInput.value = '';
                    errorMsg.classList.add('hidden');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }

                function closeDeleteModal() {
                    const modal = document.getElementById('deleteModal');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }

                // Close modal on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeDeleteModal();
                    }
                });

                // Validate code before submit
                document.getElementById('delete-form').addEventListener('submit', function(e) {
                    const codeInput = document.getElementById('verification_code');
                    const errorMsg = document.getElementById('codeError');
                    
                    if (codeInput.value.length !== 4) {
                        e.preventDefault();
                        errorMsg.textContent = 'Code moet 4 cijfers zijn!';
                        errorMsg.classList.remove('hidden');
                    }
                });

                // Telefoon validatie - alleen cijfers
                document.getElementById('telefoon').addEventListener('input', function(e) {
                    let value = e.target.value;
                    // Verwijder alles behalve cijfers en +
                    value = value.replace(/[^0-9+]/g, '');
                    // Als het begint met 06, mag het maximaal 10 karakters zijn
                    if (value.startsWith('06') && value.length > 10) {
                        value = value.substring(0, 10);
                    }
                    // Als het begint met +316, mag het maximaal 12 karakters zijn
                    if (value.startsWith('+316') && value.length > 12) {
                        value = value.substring(0, 12);
                    }
                    e.target.value = value;
                });

                // Postcode validatie - alleen cijfers en letters, exact format
                document.getElementById('postcode').addEventListener('input', function(e) {
                    let value = e.target.value.toUpperCase().replace(/[^0-9A-Z]/g, '');
                    
                    // Maximaal 6 karakters
                    if (value.length > 6) {
                        value = value.substring(0, 6);
                    }
                    
                    // Eerste 4 moeten cijfers zijn
                    if (value.length <= 4) {
                        value = value.replace(/[^0-9]/g, '');
                    } else {
                        // Eerste 4 cijfers, laatste 2 letters
                        let numbers = value.substring(0, 4).replace(/[^0-9]/g, '');
                        let letters = value.substring(4, 6).replace(/[^A-Z]/g, '');
                        value = numbers + letters;
                    }
                    
                    e.target.value = value;
                });

                // Plaats validatie - alleen letters
                document.getElementById('plaats').addEventListener('input', function(e) {
                    let value = e.target.value;
                    // Alleen letters, spaties en -
                    value = value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ\s\'-]/g, '');
                    e.target.value = value;
                });

                // Voornaam en achternaam validatie - alleen letters
                ['voornaam', 'achternaam'].forEach(function(fieldId) {
                    document.getElementById(fieldId).addEventListener('input', function(e) {
                        let value = e.target.value;
                        value = value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ\s\'-]/g, '');
                        e.target.value = value;
                    });
                });
            </script>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
