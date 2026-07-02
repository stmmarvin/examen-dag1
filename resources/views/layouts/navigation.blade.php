<nav class="border-b border-gray-400 bg-white">
    <div class="flex h-[76px] items-center justify-between px-7">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/kniploket-tiko-logo.png') }}" alt="Kniploket Tiko" class="h-14 w-14 object-contain">
                <span class="text-2xl font-bold">
                    <span class="text-[#10213D]">knip</span><span class="text-[#C6983C]">loket</span>
                    <span class="ml-1 text-[#10213D]">tiko</span>
                </span>
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
