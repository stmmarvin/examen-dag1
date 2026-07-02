<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Afspraak beheer
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-600 mb-8">Beheer je afspraakinstellingen en voorkeuren.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Openingstijden</h3>
                    <p class="text-gray-600 text-sm mb-4">Stel je beschikbaarheid in.</p>
                    <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Bewerken →</button>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Behandelingen</h3>
                    <p class="text-gray-600 text-sm mb-4">Beheer je diensten en prijzen.</p>
                    <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Bewerken →</button>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Medewerkers</h3>
                    <p class="text-gray-600 text-sm mb-4">Beheer je team leden.</p>
                    <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Bewerken →</button>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Notificaties</h3>
                    <p class="text-gray-600 text-sm mb-4">Stel herinneringen in.</p>
                    <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Bewerken →</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
