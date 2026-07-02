<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-300 bg-white">
                <div class="p-6 text-gray-900">
                    <!-- Dashboard-link naar de individueel gebouwde medewerker CRUD. -->
                    <h3 class="text-xl font-bold">Overzicht Kniploket Tiko</h3>
                    <p class="mt-2 text-sm">Kies een onderdeel om te beheren.</p>

                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        <a href="{{ route('medewerkers.index') }}" class="block rounded border border-gray-400 p-5 font-bold hover:bg-gray-100">
                            Medewerkers
                        </a>
                        <div class="rounded border border-gray-300 p-5 text-gray-500">Klanten</div>
                        <div class="rounded border border-gray-300 p-5 text-gray-500">Afspraken</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
