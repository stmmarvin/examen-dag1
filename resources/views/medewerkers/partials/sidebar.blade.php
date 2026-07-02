@php
    $active = $active ?? 'index';
@endphp

<aside class="flex w-[270px] shrink-0 flex-col border-r border-gray-400 px-6 py-6">
    <div>
        <h1 class="text-2xl font-bold">Medewerkers</h1>
        <p class="mt-3 max-w-[180px] text-sm leading-tight">Beheer, bekijk en zoek medewerkers.</p>
    </div>

    <nav class="mt-7 space-y-2 text-sm font-bold">
        <!-- De sidebar blijft navigatie; acties staan bij de medewerker waar ze context hebben. -->
        <a href="{{ route('medewerkers.index') }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'index' ? 'bg-gray-200' : '' }}">
            <span class="text-lg">⊙</span>
            <span>Alle medewerkers</span>
        </a>
    </nav>

    <div class="mt-auto rounded border border-gray-400 p-5 text-sm">
        <h2 class="font-bold">Hulp nodig?</h2>
        <p class="mt-3 leading-tight">Bekijk de handleiding of neem contact op met support.</p>
        <button type="button" class="mt-7 w-full rounded border border-gray-400 px-4 py-3 font-bold">
            Naar helpcentrum
        </button>
    </div>
</aside>
