@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="relative min-h-[520px] overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('images/home-salon-hero.png') }}');">
        <div class="absolute inset-0 bg-black/55"></div>
        <div class="relative mx-auto flex min-h-[520px] max-w-[1700px] flex-col items-center justify-center px-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-[#d8b05c]">Kniploket Tiko</p>
            <h1 class="mt-4 max-w-4xl text-4xl font-bold text-white sm:text-5xl">Welkom, {{ Auth::user()->name }}</h1>
            <p class="mt-4 max-w-2xl text-sm leading-6 text-white/85">
                Plan makkelijk je bezoek en bekijk onze behandelingen in een rustige, professionele omgeving.
            </p>
            <a href="{{ route('behandelingen.index') }}" class="mt-8 inline-flex items-center justify-center rounded-md bg-[#c69a3e] px-8 py-4 text-sm font-bold text-[#0f1f3a] shadow-xl shadow-black/30 hover:bg-[#d8b05c]">
                Maak een afspraak
            </a>
        </div>
    </section>

    <section class="mx-auto w-full max-w-[1700px] px-8 py-8">
        <div class="grid gap-4 sm:grid-cols-2">
            <a href="{{ route('behandelingen.index') }}" class="rounded-lg border border-slate-200 bg-white/90 p-5 shadow-sm hover:border-[#c69a3e]">
                <p class="text-sm font-semibold text-[#c69a3e]">Behandelingen</p>
                <p class="mt-2 text-2xl font-bold text-[#0f1f3a]">Overzicht</p>
            </a>
            <a href="{{ route('profile.edit') }}" class="rounded-lg border border-slate-200 bg-white/90 p-5 shadow-sm hover:border-[#c69a3e]">
                <p class="text-sm font-semibold text-[#c69a3e]">Account</p>
                <p class="mt-2 text-2xl font-bold text-[#0f1f3a]">Profiel</p>
            </a>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
