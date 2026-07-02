<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profiel Bewerken - Kniploket Tiko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-800 to-slate-900 min-h-screen">
    <!-- Header -->
    <div class="bg-slate-900/50 border-b border-slate-700">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">
                    <span class="text-slate-200">knip</span><span class="text-amber-500">loket</span>
                    <span class="text-slate-400 text-lg ml-2">tiko</span>
                </h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('profiel.index') }}" class="text-slate-300 hover:text-white transition">
                    Terug naar profiel
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-300 hover:text-white transition">
                        Uitloggen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-6">Profiel Bewerken</h2>

            <form method="POST" action="{{ route('profiel.update') }}">
                @csrf
                @method('PATCH')

                <!-- Persoonlijke Info -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-amber-600 mb-4">Persoonlijke Informatie</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="voornaam" class="block text-sm font-medium text-gray-700 mb-2">
                                Voornaam <span class="text-red-500">*</span>
                            </label>
                            <input id="voornaam" type="text" name="voornaam" value="{{ old('voornaam', $user->voornaam) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('voornaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="achternaam" class="block text-sm font-medium text-gray-700 mb-2">
                                Achternaam <span class="text-red-500">*</span>
                            </label>
                            <input id="achternaam" type="text" name="achternaam" value="{{ old('achternaam', $user->achternaam) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('achternaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefoon" class="block text-sm font-medium text-gray-700 mb-2">
                                Telefoon
                            </label>
                            <input id="telefoon" type="text" name="telefoon" value="{{ old('telefoon', $user->telefoon) }}" 
                                   placeholder="06 12345678"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('telefoon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="geboortedatum" class="block text-sm font-medium text-gray-700 mb-2">
                                Geboortedatum
                            </label>
                            <input id="geboortedatum" type="date" name="geboortedatum" value="{{ old('geboortedatum', $user->geboortedatum) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('geboortedatum')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Adres Info -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-amber-600 mb-4">Adresgegevens</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="adres" class="block text-sm font-medium text-gray-700 mb-2">
                                Adres
                            </label>
                            <input id="adres" type="text" name="adres" value="{{ old('adres', $user->adres) }}" 
                                   placeholder="Straatnaam 123"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('adres')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">
                                Postcode
                            </label>
                            <input id="postcode" type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}" 
                                   placeholder="1234AB"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('postcode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="plaats" class="block text-sm font-medium text-gray-700 mb-2">
                                Plaats
                            </label>
                            <input id="plaats" type="text" name="plaats" value="{{ old('plaats', $user->plaats) }}" 
                                   placeholder="Amsterdam"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('plaats')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Extra Info -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-amber-600 mb-4">Extra Informatie</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="allergieen" class="block text-sm font-medium text-gray-700 mb-2">
                                Allergieën
                            </label>
                            <textarea id="allergieen" name="allergieen" rows="3" 
                                      placeholder="Bijvoorbeeld: noten, parfum, etc."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('allergieen', $user->allergieen) }}</textarea>
                            @error('allergieen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="wensen" class="block text-sm font-medium text-gray-700 mb-2">
                                Wensen
                            </label>
                            <textarea id="wensen" name="wensen" rows="3" 
                                      placeholder="Speciale wensen of opmerkingen"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('wensen', $user->wensen) }}</textarea>
                            @error('wensen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                        Opslaan
                    </button>

                    <button type="button" onclick="if(confirm('Weet je zeker dat je je account wilt verwijderen?')) document.getElementById('delete-form').submit();"
                            class="text-red-600 hover:text-red-700 font-semibold">
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
    </div>
</body>
</html>
