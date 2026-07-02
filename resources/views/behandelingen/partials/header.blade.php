<header class="border-b border-[#d7c39a] bg-white text-[#0f1f3a] shadow-sm">
    <div class="flex h-28 w-full items-center justify-between px-10">
        <a href="{{ route('behandelingen.index') }}" class="flex items-center">
            <img src="{{ asset('images/kniploket-tiko-logo.svg') }}" alt="kniploket tiko" class="h-24 w-auto">
        </a>

        <nav class="hidden items-center gap-12 text-sm font-semibold text-[#0f1f3a] md:flex">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'border-b-2 border-[#c69a3e] pb-1' : 'hover:text-[#c69a3e]' }}">Home</a>
            <a href="{{ route('behandelingen.index') }}" class="{{ request()->routeIs('behandelingen.*') ? 'border-b-2 border-[#c69a3e] pb-1' : 'hover:text-[#c69a3e]' }}">Behandelingen</a>
            <a href="#" class="hover:text-[#c69a3e]">Over ons</a>
            <a href="#" class="hover:text-[#c69a3e]">Contact</a>
        </nav>

        @auth
            <a href="{{ route('profiel.index') }}" class="flex items-center gap-3 text-sm font-semibold text-[#0f1f3a] hover:text-[#c69a3e]">
                <span class="flex h-9 w-9 items-center justify-center rounded-full border border-[#0f1f3a] bg-[#f8f4ea]">
                    <span class="h-2 w-2 rounded-full bg-[#c69a3e]"></span>
                </span>
                <span>{{ Auth::user()->name }}</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex items-center gap-3 text-sm font-semibold text-[#0f1f3a] hover:text-[#c69a3e]">
                <span class="flex h-9 w-9 items-center justify-center rounded-full border border-[#0f1f3a] bg-[#f8f4ea]">
                    <span class="h-2 w-2 rounded-full bg-[#c69a3e]"></span>
                </span>
                <span>Inloggen</span>
            </a>
        @endauth
    </div>
</header>
