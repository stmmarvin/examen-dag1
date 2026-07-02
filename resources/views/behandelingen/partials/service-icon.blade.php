@php
    // Bepaalt welk simpel icoon bij de categorie hoort.
    $type = strtolower((string) $type);
    $icon = match (true) {
        str_contains($type, 'kleur') => 'kleur',
        str_contains($type, 'styling') => 'styling',
        str_contains($type, 'baard') => 'baard',
        default => 'knippen',
    };
@endphp

<span class="flex h-12 w-12 items-center justify-center rounded bg-slate-100 text-[#0f1f3a]">
    @if ($icon === 'kleur')
        {{-- Verfkwast icoon voor kleur behandelingen. --}}
        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M14 4h6l-4 4 2 2-7 7-4-4 7-7z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6 14c-2 1-3 3-3 6 3 0 5-1 6-3" stroke="#c69a3e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @elseif ($icon === 'styling')
        {{-- Fohn icoon voor styling behandelingen. --}}
        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M4 7h10a4 4 0 0 1 0 8H9l-2 5H4l2-5H4z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18 9h3M18 12h3M18 15h2" stroke="#c69a3e" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
    @elseif ($icon === 'baard')
        {{-- Gezicht icoon voor baard behandelingen. --}}
        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M8 10a4 4 0 0 1 8 0v3a4 4 0 0 1-8 0z" stroke="currentColor" stroke-width="1.8"/>
            <path d="M7 14c1 4 3 6 5 6s4-2 5-6" stroke="#c69a3e" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M9 10h.01M15 10h.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
    @else
        {{-- Schaar icoon voor knip behandelingen. --}}
        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M4 5l16 14M20 5 8.5 16.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="5.5" cy="18.5" r="2.5" stroke="#c69a3e" stroke-width="1.8"/>
            <circle cx="5.5" cy="5.5" r="2.5" stroke="#c69a3e" stroke-width="1.8"/>
        </svg>
    @endif
</span>
