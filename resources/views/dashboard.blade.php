@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="relative overflow-hidden" style="min-height: 680px; background-image: url('{{ asset('images/home-salon-hero.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="absolute inset-0" style="background: rgba(0, 0, 0, .58);"></div>
        <div class="relative mx-auto flex flex-col items-center justify-center px-8 text-center" style="min-height: 680px; max-width: 1700px;">
            <p class="text-sm font-semibold uppercase tracking-widest" style="color: #d8b05c;">Kniploket Tiko</p>
            <h1 class="mt-4 max-w-4xl text-4xl font-bold sm:text-5xl" style="color: #fff;">Welkom, {{ Auth::user()->name }}</h1>
            <p class="mt-4 max-w-2xl text-sm leading-6" style="color: rgba(255, 255, 255, .86);">
                Plan makkelijk je bezoek en bekijk onze behandelingen in een rustige, professionele omgeving.
            </p>
            <a href="{{ route('behandelingen.index') }}" class="mt-8 inline-flex items-center justify-center rounded-md px-8 py-4 text-sm font-bold shadow-xl" style="background: #c69a3e; color: #0f1f3a; box-shadow: 0 18px 36px rgba(0, 0, 0, .32);">
                Maak een afspraak
            </a>
        </div>
    </section>

    <section class="mx-auto w-full px-8 py-8" style="max-width: 1700px;">
        <div class="grid gap-4 sm:grid-cols-2">
            <a href="{{ route('behandelingen.index') }}" class="rounded-lg border border-slate-200 p-5 shadow-sm hover:border-[#c69a3e]" style="background: rgba(255, 255, 255, .92);">
                <p class="text-sm font-semibold text-[#c69a3e]">Behandelingen</p>
                <p class="mt-2 text-2xl font-bold text-[#0f1f3a]">Overzicht</p>
            </a>
            <a href="{{ route('profile.edit') }}" class="rounded-lg border border-slate-200 p-5 shadow-sm hover:border-[#c69a3e]" style="background: rgba(255, 255, 255, .92);">
                <p class="text-sm font-semibold text-[#c69a3e]">Account</p>
                <p class="mt-2 text-2xl font-bold text-[#0f1f3a]">Profiel</p>
            </a>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
