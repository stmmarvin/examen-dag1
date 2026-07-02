<nav class="border-b border-gray-400 bg-white">
    <div class="flex h-[76px] items-center justify-between px-7">
        <div class="flex items-center gap-4">
            <!-- Wireframe-logo: eenvoudig kader met kruis zoals in het ontwerp. -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                <span class="relative block h-10 w-10 border border-black">
                    <span class="absolute left-0 top-1/2 h-px w-full -rotate-45 bg-black"></span>
                    <span class="absolute left-0 top-1/2 h-px w-full rotate-45 bg-black"></span>
                </span>
                <span class="text-2xl font-bold">Kniploket Tiko</span>
            </a>
        </div>

        <div class="hidden items-center gap-10 text-sm font-bold lg:flex">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'border-b-2 border-black pb-3' : 'pb-3' }}">
                Overzicht
            </a>
            <a href="{{ route('medewerkers.index') }}" class="{{ request()->routeIs('medewerkers.*') ? 'border-b-2 border-black pb-3' : 'pb-3' }}">
                Medewerkers
            </a>
            <span class="pb-3">Klanten</span>
            <span class="pb-3">Afspraken</span>
            <span class="pb-3">Agenda</span>
            <span class="pb-3">Behandelingen</span>
        </div>

        <div class="flex items-center gap-3 text-sm font-bold">
            <span class="flex h-9 w-9 items-center justify-center rounded-full border border-black">
                <span class="text-xl font-normal">○</span>
            </span>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-1 font-bold">
                        <span>Mijn account</span>
                        <span>v</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Profiel
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Uitloggen
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
