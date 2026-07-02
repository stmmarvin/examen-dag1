<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registreren - Kniploket Tiko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left Side - Logo -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-50 to-slate-100 items-center justify-center p-12">
            <div class="text-center max-w-lg">
                <!-- Real Kniploket Tiko Logo -->
                <img src="/logo.svg" alt="Kniploket Tiko" class="w-full max-w-md mx-auto" />
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-md py-8">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <img src="/logo.svg" alt="Kniploket Tiko" class="w-64 mx-auto" />
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-slate-900 mb-2">Account aanmaken</h2>
                    <p class="text-slate-600">Registreer je als klant van Kniploket Tiko</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Voornaam -->
                    <div>
                        <label for="voornaam" class="block text-sm font-semibold text-slate-900 mb-2">
                            Voornaam <span class="text-red-500">*</span>
                        </label>
                        <input id="voornaam" type="text" name="voornaam" value="{{ old('voornaam') }}" required autofocus 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('voornaam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Achternaam -->
                    <div>
                        <label for="achternaam" class="block text-sm font-semibold text-slate-900 mb-2">
                            Achternaam <span class="text-red-500">*</span>
                        </label>
                        <input id="achternaam" type="text" name="achternaam" value="{{ old('achternaam') }}" required 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('achternaam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">
                            E-mailadres <span class="text-red-500">*</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                               pattern=".+@(outlook\.nl|hotmail\.(com|nl)|gmail\.com)"
                               title="Email moet eindigen op @outlook.nl, @hotmail.com, @hotmail.nl of @gmail.com"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefoon -->
                    <div>
                        <label for="telefoon" class="block text-sm font-semibold text-slate-900 mb-2">
                            Telefoonnummer
                        </label>
                        <input id="telefoon" type="tel" name="telefoon" value="{{ old('telefoon') }}" 
                               placeholder="0612345678" pattern="(06|\+316)[0-9]{8}" title="Telefoonnummer moet beginnen met 06 gevolgd door 8 cijfers"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('telefoon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Wachtwoord -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-900 mb-2">
                            Wachtwoord <span class="text-red-500">*</span>
                        </label>
                        <input id="password" type="password" name="password" required 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bevestig Wachtwoord -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-900 mb-2">
                            Bevestig Wachtwoord <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-6 rounded-md transition duration-200 text-lg mt-6">
                        Account aanmaken
                    </button>

                    <!-- Login Link -->
                    <div class="text-center text-sm text-slate-600 mt-6">
                        Al een account? 
                        <a href="{{ route('login') }}" class="text-slate-900 hover:text-amber-600 font-semibold">
                            Log hier in
                        </a>
                    </div>
                </form>

                <script>
                    // Voornaam en achternaam validatie - alleen letters
                    ['voornaam', 'achternaam'].forEach(function(fieldId) {
                        document.getElementById(fieldId).addEventListener('input', function(e) {
                            let value = e.target.value;
                            value = value.replace(/[^a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ\s\'-]/g, '');
                            e.target.value = value;
                        });
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
                </script>
            </div>
        </div>
    </div>
</body>
</html>
