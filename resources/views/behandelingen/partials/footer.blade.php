<footer class="border-t border-[#d7c39a] bg-white text-[#0f1f3a]">
    <div class="mx-auto grid max-w-5xl items-start gap-12 px-10 py-6 md:grid-cols-[1fr_1fr_1fr_1.4fr]">
        <div>
            <h3 class="font-bold text-[#0f1f3a]">Snel naar</h3>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <a href="{{ route('dashboard') }}" class="block hover:text-[#c69a3e]">Home</a>
                <a href="{{ route('behandelingen.index') }}" class="block hover:text-[#c69a3e]">Behandelingen</a>
                <a href="#" class="block hover:text-[#c69a3e]">Over ons</a>
                <a href="#" class="block hover:text-[#c69a3e]">Contact</a>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-[#0f1f3a]">Account</h3>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <a href="{{ route('profile.edit') }}" class="block hover:text-[#c69a3e]">Profiel</a>
                <a href="#" class="block hover:text-[#c69a3e]">Mijn afspraken</a>
                <a href="#" class="block hover:text-[#c69a3e]">Instellingen</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-[#c69a3e]">Uitloggen</button>
                </form>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-[#0f1f3a]">Help</h3>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <a href="#" class="block hover:text-[#c69a3e]">Veelgestelde vragen</a>
                <a href="#" class="block hover:text-[#c69a3e]">Annuleren</a>
                <a href="#" class="block hover:text-[#c69a3e]">Contact</a>
            </div>
        </div>

        <div class="flex items-end justify-start text-sm text-slate-600 md:justify-end md:text-right">
            <div>
                <p>&copy; 2024 kniploket tiko.</p>
                <p class="mt-1">Alle rechten voorbehouden.</p>
            </div>
        </div>
    </div>
</footer>