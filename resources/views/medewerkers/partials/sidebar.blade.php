@php
    $active = $active ?? 'index';
    $actieMedewerker = $actieMedewerker ?? null;
    $isEigenaarAccount = $actieMedewerker
        && strtolower((string) $actieMedewerker->gebruiker?->email) === 'eigenaar@kniplokettiko.nl';
@endphp

<aside class="flex w-[270px] shrink-0 flex-col border-r border-gray-400 px-6 py-6">
    <div>
        <h1 class="text-2xl font-bold">Medewerkers</h1>
        <p class="mt-3 max-w-[180px] text-sm leading-tight">Beheer, bekijk en zoek medewerkers.</p>
    </div>

    <nav class="mt-7 space-y-2 text-sm font-bold">
        <!-- De actieknoppen staan hier centraal, zoals in het wireframe. -->
        <a href="{{ route('medewerkers.index') }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'index' ? 'bg-gray-200' : '' }}">
            <span class="text-lg">⊙</span>
            <span>Alle medewerkers</span>
        </a>
        <a href="{{ route('medewerkers.create') }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'create' ? 'bg-gray-200' : '' }}">
            <span class="text-xl">+</span>
            <span>Nieuwe medewerker</span>
        </a>

        @if ($actieMedewerker)
            <a href="{{ route('medewerkers.edit', $actieMedewerker) }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'edit' ? 'bg-gray-200' : '' }}">
                <span class="text-lg">✎</span>
                <span>Medewerker bewerken</span>
            </a>

            @unless ($isEigenaarAccount)
                <a href="{{ route('medewerkers.delete', $actieMedewerker) }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'delete' ? 'bg-gray-200' : '' }}">
                    <span class="text-lg">▱</span>
                    <span>Medewerker verwijderen</span>
                </a>
            @endunless
        @else
            <span class="flex cursor-not-allowed items-center gap-5 rounded px-4 py-4 text-gray-400">
                <span class="text-lg">✎</span>
                <span>Medewerker bewerken</span>
            </span>
            <span class="flex cursor-not-allowed items-center gap-5 rounded px-4 py-4 text-gray-400">
                <span class="text-lg">▱</span>
                <span>Medewerker verwijderen</span>
            </span>
        @endif
    </nav>

</aside>
