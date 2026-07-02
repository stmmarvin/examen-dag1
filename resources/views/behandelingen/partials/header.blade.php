<header class="border-b border-gray-400 bg-white">
    <div class="mx-auto flex h-24 max-w-7xl items-center justify-between px-6">
        <a href="{{ route('behandelingen.index') }}" class="flex items-center gap-4">
            <span class="relative block h-12 w-12 border border-gray-900">
                <span class="absolute left-0 top-1/2 h-px w-full -rotate-45 bg-gray-900"></span>
                <span class="absolute left-0 top-1/2 h-px w-full rotate-45 bg-gray-900"></span>
            </span>
            <span class="text-xl font-bold text-black">Kapperszaak</span>
        </a>

        <nav class="hidden items-center gap-12 text-sm font-semibold text-black md:flex">
            <a href="{{ route('dashboard') }}" class="hover:underline">Home</a>
            <a href="{{ route('behandelingen.index') }}" class="border-b-2 border-black pb-1">Behandelingen</a>
            <a href="#" class="hover:underline">Over ons</a>
            <a href="#" class="hover:underline">Contact</a>
        </nav>

        <div class="flex items-center gap-3 text-sm font-semibold text-black">
            <span class="flex h-9 w-9 items-center justify-center rounded-full border border-black">
                <span class="text-lg leading-none">◎</span>
            </span>
            <span>Mijn account</span>
            <span class="text-lg leading-none">⌄</span>
        </div>
    </div>
</header>
