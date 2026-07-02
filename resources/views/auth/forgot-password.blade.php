<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wachtwoord Vergeten - Kniploket Tiko</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left Side - Logo -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-50 to-slate-100 items-center justify-center p-12">
            <div class="text-center">
                <!-- Schaar/Computer Icon -->
                <div class="mb-8">
                    <svg class="w-64 h-64 mx-auto" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Computer Monitor -->
                        <rect x="240" y="120" width="120" height="90" rx="4" stroke="#1e293b" stroke-width="6" fill="white"/>
                        <rect x="245" y="125" width="110" height="70" fill="#1e293b"/>
                        <rect x="280" y="210" width="40" height="20" fill="#1e293b"/>
                        <rect x="270" y="230" width="60" height="8" rx="4" fill="#1e293b"/>
                        
                        <!-- Scissors -->
                        <circle cx="120" cy="100" r="35" stroke="#1e293b" stroke-width="8" fill="white"/>
                        <circle cx="120" cy="220" r="35" stroke="#1e293b" stroke-width="8" fill="white"/>
                        <line x1="120" y1="135" x2="200" y2="160" stroke="#1e293b" stroke-width="8"/>
                        <line x1="120" y1="185" x2="200" y2="160" stroke="#1e293b" stroke-width="8"/>
                        <line x1="200" y1="160" x2="240" y2="160" stroke="#d4a849" stroke-width="6"/>
                    </svg>
                </div>
                
                <!-- Brand Name -->
                <h1 class="text-6xl font-bold mb-4">
                    <span class="text-slate-800">knip</span><span class="text-amber-500">loket</span>
                </h1>
                <p class="text-4xl text-slate-600 font-light tracking-wide">tiko</p>
            </div>
        </div>

        <!-- Right Side - Forgot Password Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-4xl font-bold mb-2">
                        <span class="text-slate-800">knip</span><span class="text-amber-500">loket</span>
                    </h1>
                    <p class="text-2xl text-slate-600 font-light tracking-wide">tiko</p>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-slate-900 mb-4">Wachtwoord vergeten?</h2>
                    <p class="text-slate-600">
                        Geen probleem. Vul je e-mailadres in en we sturen je een link om je wachtwoord opnieuw in te stellen.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- E-mailadres -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">
                            E-mailadres
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-6 rounded-md transition duration-200 text-lg">
                        Verstuur Reset Link
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center text-sm text-slate-600 mt-6">
                        <a href="{{ route('login') }}" class="text-slate-900 hover:text-amber-600 font-semibold">
                            ← Terug naar inloggen
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
