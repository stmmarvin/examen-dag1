<footer class="border-t border-gray-400 bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-8 md:grid-cols-[1.4fr_1fr_1fr_1fr_1.2fr]">
        <div>
            <span class="relative block h-12 w-12 border border-gray-900">
                <span class="absolute left-0 top-1/2 h-px w-full -rotate-45 bg-gray-900"></span>
                <span class="absolute left-0 top-1/2 h-px w-full rotate-45 bg-gray-900"></span>
            </span>
            <h2 class="mt-4 text-lg font-bold text-black">Kapperszaak</h2>
            <p class="mt-3 text-sm text-black">Jouw haar, onze passie.</p>
            <p class="mt-1 text-sm text-black">Stralend elke dag weer.</p>
        </div>

        <div>
            <h3 class="font-bold text-black">Snel naar</h3>
            <div class="mt-4 space-y-3 text-sm text-black">
                <a href="{{ route('dashboard') }}" class="block hover:underline">Home</a>
                <a href="{{ route('behandelingen.index') }}" class="block hover:underline">Behandelingen</a>
                <a href="#" class="block hover:underline">Over ons</a>
                <a href="#" class="block hover:underline">Contact</a>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-black">Account</h3>
            <div class="mt-4 space-y-3 text-sm text-black">
                <a href="{{ route('profile.edit') }}" class="block hover:underline">Profiel</a>
                <a href="#" class="block hover:underline">Mijn afspraken</a>
                <a href="#" class="block hover:underline">Instellingen</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:underline">Uitloggen</button>
                </form>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-black">Help</h3>
            <div class="mt-4 space-y-3 text-sm text-black">
                <a href="#" class="block hover:underline">Veelgestelde vragen</a>
                <a href="#" class="block hover:underline">Annuleren</a>
                <a href="#" class="block hover:underline">Contact</a>
            </div>
        </div>

        <div class="flex items-end justify-start text-sm text-black md:justify-end md:text-right">
            <div>
                <p>© 2024 Kapperszaak.</p>
                <p class="mt-1">Alle rechten voorbehouden.</p>
            </div>
        </div>
    </div>
</footer>
