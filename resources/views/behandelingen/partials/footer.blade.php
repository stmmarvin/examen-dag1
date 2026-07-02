<footer class="border-t border-gray-400 bg-white">
    <div class="mx-auto grid max-w-5xl items-start gap-12 px-10 py-6 md:grid-cols-[1fr_1fr_1fr_1.4fr]">
        <div>
            <h3 class="font-bold text-black">Snel naar</h3>
            <div class="mt-3 space-y-2 text-sm text-black">
                <a href="{{ route('dashboard') }}" class="block hover:underline">Home</a>
                <a href="{{ route('behandelingen.index') }}" class="block hover:underline">Behandelingen</a>
                <a href="#" class="block hover:underline">Over ons</a>
                <a href="#" class="block hover:underline">Contact</a>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-black">Account</h3>
            <div class="mt-3 space-y-2 text-sm text-black">
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
            <div class="mt-3 space-y-2 text-sm text-black">
                <a href="#" class="block hover:underline">Veelgestelde vragen</a>
                <a href="#" class="block hover:underline">Annuleren</a>
                <a href="#" class="block hover:underline">Contact</a>
            </div>
        </div>

        <div class="flex items-end justify-start text-sm text-black md:justify-end md:text-right">
            <div>
                <p>&copy; 2024 Kapperszaak.</p>
                <p class="mt-1">Alle rechten voorbehouden.</p>
            </div>
        </div>
    </div>
</footer>
