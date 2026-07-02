<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#C6983C]">Eigenaar login</p>
        <h1 class="mt-3 text-3xl font-extrabold text-[#10213D]">Inloggen</h1>
        <p class="mt-2 text-sm text-gray-600">Log in om medewerkers te beheren.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <label class="block text-sm font-bold text-[#10213D]" for="email">
            E-mailadres
            <input
                id="email"
                class="mt-2 block w-full rounded border-gray-400 text-sm shadow-none focus:border-[#C6983C] focus:ring-[#C6983C]"
                type="email"
                name="email"
                value="{{ old('email', 'eigenaar@kniplokettiko.nl') }}"
                required
                autofocus
                autocomplete="username"
            >
        </label>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <label class="block text-sm font-bold text-[#10213D]" for="password">
            Wachtwoord
            <input
                id="password"
                class="mt-2 block w-full rounded border-gray-400 text-sm shadow-none focus:border-[#C6983C] focus:ring-[#C6983C]"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >
        </label>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center text-sm text-gray-700">
                <input id="remember_me" type="checkbox" class="rounded border-gray-400 text-[#10213D] focus:ring-[#C6983C]" name="remember">
                <span class="ms-2">Ingelogd blijven</span>
            </label>

        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center gap-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2" style="--tw-ring-color: #B8935A;" href="{{ route('password.request') }}">
                        {{ __('Wachtwoord vergeten?') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <a class="underline text-sm hover:opacity-75 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2" style="color: #B8935A; --tw-ring-color: #B8935A;" href="{{ route('register') }}">
                        Nog geen account? Registreer
                    </a>
                @endif
            </div>

            <x-primary-button class="ms-3">
                {{ __('Inloggen') }}
            </x-primary-button>
        </div>

        <button class="w-full rounded bg-[#10213D] px-5 py-3 text-sm font-bold text-white hover:bg-[#1b3158]">
            Inloggen
        </button>
    </form>
</x-guest-layout>
