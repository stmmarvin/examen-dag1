@php
    // Naam van het actie icoon dat getoond moet worden.
    $name = $name ?? '';
@endphp

@if ($name === 'view')
    {{-- Oog icoon voor bekijken. --}}
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="12" cy="12" r="2.5" stroke="#c69a3e" stroke-width="1.8"/>
    </svg>
@elseif ($name === 'edit')
    {{-- Potlood icoon voor wijzigen. --}}
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M4 20h4l11-11-4-4L4 16z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M13.5 6.5l4 4" stroke="#c69a3e" stroke-width="1.8" stroke-linecap="round"/>
    </svg>
@elseif ($name === 'trash')
    {{-- Prullenbak icoon voor verwijderen. --}}
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M4 7h16M9 7V4h6v3M7 7l1 13h8l1-13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M10 11v5M14 11v5" stroke="#c69a3e" stroke-width="1.8" stroke-linecap="round"/>
    </svg>
@endif
