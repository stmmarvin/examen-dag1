<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Test Unhappy Paths - Afspraak Annuleren
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong>✓ Success:</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong>✗ Error (Unhappy Path):</strong> {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4">
                    <strong>ℹ Info:</strong> {{ session('info') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold mb-4" style="color: #1E293B;">Unhappy Path Test Scenario's</h3>
                <p class="text-gray-600 mb-4">Gebruik deze pagina om de validaties te testen bij het annuleren van afspraken.</p>
                
                <div class="space-y-4">
                    <div class="border-l-4 border-red-500 bg-red-50 p-4">
                        <h4 class="font-semibold text-red-800 mb-2">Scenario 1: Afspraak is al geannuleerd</h4>
                        <p class="text-sm text-red-700 mb-2">Stappen:</p>
                        <ol class="list-decimal list-inside text-sm text-red-700 space-y-1">
                            <li>Ga naar het afspraken overzicht</li>
                            <li>Annuleer een afspraak (status wordt "geannuleerd")</li>
                            <li>Probeer dezelfde afspraak opnieuw te annuleren</li>
                            <li>Je ziet: <strong>"Deze afspraak is al geannuleerd."</strong></li>
                        </ol>
                    </div>

                    <div class="border-l-4 border-orange-500 bg-orange-50 p-4">
                        <h4 class="font-semibold text-orange-800 mb-2">Scenario 2: Afspraak uit het verleden</h4>
                        <p class="text-sm text-orange-700 mb-2">Stappen:</p>
                        <ol class="list-decimal list-inside text-sm text-orange-700 space-y-1">
                            <li>Maak een afspraak aan met een datum in het verleden (wijzig in database)</li>
                            <li>Probeer deze afspraak te annuleren</li>
                            <li>Je ziet: <strong>"Afspraken uit het verleden kunnen niet worden geannuleerd."</strong></li>
                        </ol>
                        <div class="mt-3 bg-white border border-orange-300 rounded p-3">
                            <p class="text-xs text-orange-800 font-semibold mb-2">Database wijziging (gebruik phpMyAdmin of command):</p>
                            <code class="text-xs bg-gray-100 p-2 block rounded">
                                UPDATE appointments SET appointment_date = '2024-01-01 10:00:00' WHERE id = [KIES_ID];
                            </code>
                        </div>
                    </div>

                    <div class="border-l-4 border-purple-500 bg-purple-50 p-4">
                        <h4 class="font-semibold text-purple-800 mb-2">Scenario 3: Afspraak bestaat niet meer</h4>
                        <p class="text-sm text-purple-700 mb-2">Stappen:</p>
                        <ol class="list-decimal list-inside text-sm text-purple-700 space-y-1">
                            <li>Open browser console (F12)</li>
                            <li>Probeer handmatig een DELETE request te doen naar een niet-bestaande afspraak ID</li>
                            <li>Of: Verwijder een afspraak uit de database en probeer deze te annuleren</li>
                            <li>Je ziet: <strong>"Deze afspraak bestaat niet meer."</strong></li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4" style="color: #1E293B;">Alle Afspraken (Voor Testen)</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum & Tijd</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klant</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">In Verleden?</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($appointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 text-sm text-gray-900">{{ $appointment->id }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        {{ $appointment->appointment_date->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">{{ $appointment->client->full_name }}</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($appointment->status == 'bevestigd') bg-green-100 text-green-800
                                            @elseif($appointment->status == 'in afwachting') bg-yellow-100 text-yellow-800
                                            @elseif($appointment->status == 'geannuleerd') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        @if($appointment->appointment_date < now())
                                            <span class="text-red-600 font-semibold">✓ Ja (verleden)</span>
                                        @else
                                            <span class="text-green-600">✗ Nee (toekomst)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button type="button" onclick="openDeleteModal({{ $appointment->id }})" 
                                                class="text-red-600 hover:text-red-900 font-medium text-sm">
                                            Test Annuleren
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        Geen afspraken gevonden. Maak eerst een afspraak aan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('appointments.create') }}" style="background-color: #1E293B;" class="inline-block px-4 py-2 hover:opacity-90 text-white font-semibold rounded-md transition">
                        + Nieuwe test afspraak maken
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-8 border w-full max-w-md shadow-lg rounded-lg bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2" style="color: #1E293B;">Afspraak annuleren (TEST)</h3>
                <p class="text-sm text-gray-600 mb-6">Klik op "Ja, annuleren" om de unhappy path validaties te testen.</p>
                
                <form id="deleteForm" method="POST" class="flex gap-3 justify-center">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-md transition">
                        Terug
                    </button>
                    <button type="submit" style="background-color: #1E293B;" class="px-6 py-2 hover:opacity-90 text-white font-semibold rounded-md transition">
                        Ja, annuleren
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(appointmentId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/appointments/${appointmentId}`;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
