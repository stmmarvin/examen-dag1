<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen - Kniploket Tiko</title>
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

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <img src="/logo.svg" alt="Kniploket Tiko" class="w-64 mx-auto" />
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-slate-900 mb-2">Welkom terug</h2>
                    <p class="text-slate-600">Log in op je Kniploket Tiko account</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
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

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-900 mb-2">
                            Wachtwoord
                        </label>
                        <input id="password" type="password" name="password" required 
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-md focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" 
                               class="w-4 h-4 text-slate-900 border-slate-300 rounded focus:ring-slate-900">
                        <label for="remember_me" class="ml-2 block text-sm text-slate-700">
                            Onthoud mij
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-6 rounded-md transition duration-200 text-lg">
                        Inloggen
                    </button>

                    <!-- Links -->
                    <div class="flex items-center justify-between text-sm text-slate-600 mt-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="hover:text-slate-900 font-semibold">
                                Wachtwoord vergeten?
                            </a>
                        @endif
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hover:text-slate-900 font-semibold">
                                Nog geen account?
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
