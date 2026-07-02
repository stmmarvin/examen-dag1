<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant bewerken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('klanten.update', $klant) }}">
                        @csrf
                        @method('PUT')

                        <!-- Voornaam (Required) -->
                        <div>
                            <x-input-label for="voornaam" value="Voornaam *" />
                            <x-text-input id="voornaam" class="block mt-1 w-full" type="text" name="voornaam" :value="old('voornaam', $klant->gebruiker->voornaam)" required autofocus />
                            <x-input-error :messages="$errors->get('voornaam')" class="mt-2" />
                        </div>

                        <!-- Achternaam (Required) -->
                        <div class="mt-4">
                            <x-input-label for="achternaam" value="Achternaam *" />
                            <x-text-input id="achternaam" class="block mt-1 w-full" type="text" name="achternaam" :value="old('achternaam', $klant->gebruiker->achternaam)" required />
                            <x-input-error :messages="$errors->get('achternaam')" class="mt-2" />
                        </div>

                        <!-- Telefoonnummer (Required) -->
                        <div class="mt-4">
                            <x-input-label for="telefoon" value="Telefoonnummer *" />
                            <x-text-input id="telefoon" class="block mt-1 w-full" type="text" name="telefoon" :value="old('telefoon', $klant->gebruiker->telefoon)" required />
                            <x-input-error :messages="$errors->get('telefoon')" class="mt-2" />
                        </div>

                        <!-- Email (Required) -->
                        <div class="mt-4">
                            <x-input-label for="email" value="Email *" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $klant->gebruiker->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Geboortedatum (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="geboortedatum" value="Geboortedatum" />
                            <x-text-input id="geboortedatum" class="block mt-1 w-full" type="date" name="geboortedatum" :value="old('geboortedatum', $klant->geboortedatum?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('geboortedatum')" class="mt-2" />
                        </div>

                        <!-- Adres (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="adresregel1" value="Adres" />
                            <x-text-input id="adresregel1" class="block mt-1 w-full" type="text" name="adresregel1" :value="old('adresregel1', $klant->adresregel1)" />
                            <x-input-error :messages="$errors->get('adresregel1')" class="mt-2" />
                        </div>

                        <!-- Postcode (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="postcode" value="Postcode" />
                            <x-text-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" :value="old('postcode', $klant->postcode)" placeholder="1234AB" />
                            <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
                        </div>

                        <!-- Woonplaats (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="plaats" value="Woonplaats" />
                            <x-text-input id="plaats" class="block mt-1 w-full" type="text" name="plaats" :value="old('plaats', $klant->plaats)" />
                            <x-input-error :messages="$errors->get('plaats')" class="mt-2" />
                        </div>

                        <!-- Allergieen (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="allergieen" value="Allergieën" />
                            <textarea id="allergieen" name="allergieen" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('allergieen', $klant->klantKenmerken->where('type', 'allergie')->where('actief', true)->first()?->beschrijving) }}</textarea>
                            <x-input-error :messages="$errors->get('allergieen')" class="mt-2" />
                        </div>

                        <!-- Wensen (Optional) -->
                        <div class="mt-4">
                            <x-input-label for="wensen" value="Wensen" />
                            <textarea id="wensen" name="wensen" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('wensen', $klant->klantKenmerken->where('type', 'wens')->where('actief', true)->first()?->beschrijving) }}</textarea>
                            <x-input-error :messages="$errors->get('wensen')" class="mt-2" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-6 gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('klanten.show', $klant) }}'">
                                {{ __('Annuleren') }}
                            </x-secondary-button>

                            <x-primary-button>
                                {{ __('Opslaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
