<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn Profiel - Kniploket Tiko</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-300 hover:text-white transition">
                    Uitloggen
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-slate-800">Mijn Profiel</h2>
                <a href="{{ route('profiel.edit') }}" 
                   class="bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Bewerken
                </a>
            </div>

            <div class="space-y-4">
                <!-- Persoonlijke Info -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-amber-600 mb-3">Persoonlijke Informatie</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Voornaam</p>
                            <p class="text-gray-800 font-medium">{{ $user->voornaam ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Achternaam</p>
                            <p class="text-gray-800 font-medium">{{ $user->achternaam ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Telefoon</p>
                            <p class="text-gray-800 font-medium">{{ $user->telefoon ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Geboortedatum</p>
                            <p class="text-gray-800 font-medium">
                                {{ $user->geboortedatum ? \Carbon\Carbon::parse($user->geboortedatum)->format('d-m-Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Adres Info -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-amber-600 mb-3">Adresgegevens</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Adres</p>
                            <p class="text-gray-800 font-medium">{{ $user->adres ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Postcode</p>
                            <p class="text-gray-800 font-medium">{{ $user->postcode ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Plaats</p>
                            <p class="text-gray-800 font-medium">{{ $user->plaats ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Extra Info -->
                <div>
                    <h3 class="text-lg font-semibold text-amber-600 mb-3">Extra Informatie</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Allergieën</p>
                            <p class="text-gray-800 font-medium">{{ $user->allergieen ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Wensen</p>
                            <p class="text-gray-800 font-medium">{{ $user->wensen ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
