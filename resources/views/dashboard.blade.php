<x-app-layout>
    <div class="px-10 py-9">
        <div class="max-w-3xl">
            <!-- Dit scherm blijft beperkt tot het individueel gebouwde medewerkerdeel. -->
            <h1 class="text-3xl font-bold">Medewerkers</h1>
            <p class="mt-2 text-sm">Beheer, bekijk en zoek medewerkers.</p>
            <a href="{{ route('medewerkers.index') }}" class="mt-6 inline-flex rounded bg-black px-5 py-3 text-sm font-bold text-white">
                Naar medewerkers
            </a>
        </div>
    </div>
</x-app-layout>
