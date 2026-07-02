<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wachtwoord Vergeten - Kniploket Tiko</title>
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
                <img src="/logo.svg" alt="Kniploket Tiko" class="w-full max-w-md mx-auto" />
            </div>
        </div>

        <!-- Right Side - Forgot Password Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <img src="/logo.svg" alt="Kniploket Tiko" class="w-64 mx-auto" />
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-slate-900 mb-2">Wachtwoord vergeten?</h2>
                    <p class="text-slate-600">Geen probleem. Vul je e-mailadres in en we sturen je een link om je wachtwoord te resetten.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600 bg-green-50 border border-green-200 rounded-md p-4">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">
                            E-mailadres
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-6 rounded-md transition duration-200 text-lg">
                        Reset Link Versturen
                    </button>

                    <!-- Back to Login Link -->
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
