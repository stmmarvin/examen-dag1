<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Afspraken verwijderen (Medewerker)
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-600 mb-6">Beheer en verwijder afspraken als medewerker.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum & Tijd</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Behandeling</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ $appointment->appointment_date->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium text-gray-900">{{ $appointment->client->full_name }}</div>
                                    <div class="text-gray-500">{{ $appointment->client->phone }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $appointment->treatment->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($appointment->status == 'bevestigd') bg-green-100 text-green-800
                                        @elseif($appointment->status == 'in afwachting') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" class="inline" onsubmit="return confirm('Weet je zeker dat je deze afspraak wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Verwijderen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Geen afspraken gevonden.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($appointments->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
