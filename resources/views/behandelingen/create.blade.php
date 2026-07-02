<x-app-layout>
    <x-slot name="header">
        {{-- Pagina voor een nieuwe behandeling. --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwe behandeling toevoegen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('behandelingen.store') }}">
                    @include('behandelingen.partials.form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
