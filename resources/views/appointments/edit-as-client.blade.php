<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Mijn Afspraken bewerken (Klant)
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-600 mb-6">Bekijk en bewerk je eigen afspraken als klant.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4">
                    {{ session('info') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($appointments as $appointment)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="text-lg font-semibold" style="color: #1E293B;">
                                        {{ $appointment->appointment_date->format('d F Y \o\m H:i') }}
                                    </h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">Behandeling:</span>
                                        <p class="font-medium text-gray-900">{{ $appointment->treatment->name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Medewerker:</span>
                                        <p class="font-medium text-gray-900">{{ $appointment->employee->name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Status:</span>
                                        <p>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($appointment->status == 'bevestigd') bg-green-100 text-green-800
                                                @elseif($appointment->status == 'in afwachting') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if($appointment->notes)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <span class="text-gray-500 text-sm">Notities:</span>
                                        <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4 flex gap-2">
                                <a href="{{ route('appointments.edit', $appointment) }}" style="color: #B8935A;" class="hover:opacity-75 font-medium text-sm">
                                    Bewerken
                                </a>
                                <button type="button" onclick="openDeleteModal({{ $appointment->id }})" class="text-red-600 hover:text-red-900 font-medium text-sm">
                                    Annuleren
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white shadow-sm rounded-lg p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-2">U heeft nog geen afspraken.</p>
                        <p class="text-gray-500 mb-6">Maak uw eerste afspraak aan om te beginnen.</p>
                        <a href="{{ route('appointments.create-as-client') }}" style="background-color: #1E293B;" class="inline-block px-6 py-3 hover:opacity-90 text-white font-semibold rounded-md transition">
                            Nieuwe afspraak maken
                        </a>
                    </div>
                @endforelse
            </div>

            @if($appointments->hasPages())
                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
            @endif
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
                <h3 class="text-lg font-semibold mb-2" style="color: #1E293B;">Afspraak annuleren</h3>
                <p class="text-sm text-gray-600 mb-6">Weet u zeker dat u deze afspraak wilt annuleren? Deze actie kan niet ongedaan worden gemaakt.</p>
                
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
