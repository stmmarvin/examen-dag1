@php
    $type = strtolower((string) $type);
    $symbol = match (true) {
        str_contains($type, 'kleur') => '♨',
        str_contains($type, 'styling') => '⌁',
        str_contains($type, 'baard') => '◠',
        default => '✂',
    };
@endphp

<span class="flex h-12 w-12 items-center justify-center rounded bg-gray-200 text-2xl text-black">{{ $symbol }}</span>
