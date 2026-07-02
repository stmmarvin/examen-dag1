<x-app-layout>
    <x-slot name="header">
        {{-- Pagina om een behandeling te wijzigen. --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Behandeling wijzigen</h2>
    </x-slot>

    <div class="min-h-screen bg-stone-100 py-12" style="background-image: linear-gradient(135deg, rgba(120, 53, 15, 0.08), rgba(255, 255, 255, 0.35)), repeating-linear-gradient(45deg, rgba(68, 64, 60, 0.05) 0, rgba(68, 64, 60, 0.05) 1px, transparent 1px, transparent 18px);">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 rounded-lg bg-stone-900 px-6 py-5 text-white shadow-md">
                <p class="text-sm font-medium uppercase tracking-widest text-amber-200">Kniploket Tiko</p>
                <p class="mt-1 text-sm text-stone-200">Pas de gegevens van deze behandeling aan.</p>
            </div>

            <div class="bg-white/95 p-6 shadow-md ring-1 ring-stone-200 sm:rounded-lg">
                <form method="POST" action="{{ route('behandelingen.update', $behandeling) }}">
                    @method('PUT')
                    @include('behandelingen.partials.form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
