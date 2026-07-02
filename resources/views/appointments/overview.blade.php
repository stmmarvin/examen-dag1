<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Afspraken overzicht
            </h2>
            <button onclick="openAppointmentModal()" class="bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nieuwe afspraak
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-600 mb-6">Bekijk en beheer al je afspraken op één plek.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('appointments.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <!-- Date Range -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Van datum</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tot datum</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Employee Filter -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Medewerker</label>
                        <select name="employee_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Alle</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Client Filter -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Klant</label>
                        <select name="client_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Alle</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Treatment Filter -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Behandeling</label>
                        <select name="treatment_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Alle</option>
                            @foreach($treatments as $treatment)
                                <option value="{{ $treatment->id }}" {{ request('treatment_id') == $treatment->id ? 'selected' : '' }}>
                                    {{ $treatment->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Alle</option>
                            <option value="bevestigd" {{ request('status') == 'bevestigd' ? 'selected' : '' }}>Bevestigd</option>
                            <option value="in afwachting" {{ request('status') == 'in afwachting' ? 'selected' : '' }}>In afwachting</option>
                            <option value="geannuleerd" {{ request('status') == 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            <option value="voltooid" {{ request('status') == 'voltooid' ? 'selected' : '' }}>Voltooid</option>
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-6 flex justify-end gap-2">
                        <a href="{{ route('appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Filters wissen
                        </a>
                        <button type="submit" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Appointments Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Datum & tijd
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Klant
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Medewerker
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Behandeling
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gemaakt door
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Notities
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acties
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $appointment->appointment_date->format('d M Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $appointment->appointment_date->format('H:i') }} - {{ $appointment->appointment_date->addMinutes($appointment->duration_minutes)->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $appointment->client->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $appointment->client->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->employee->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $appointment->treatment->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->treatment->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->user ? $appointment->user->name : '—' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($appointment->status == 'bevestigd') bg-green-100 text-green-800
                                        @elseif($appointment->status == 'in afwachting') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status == 'geannuleerd') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">{{ $appointment->notes ?: '—' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="openEditModal({{ $appointment->id }})" class="text-indigo-600 hover:text-indigo-900">
                                            Bewerken
                                        </button>
                                        <button type="button" onclick="openDeleteModal({{ $appointment->id }})" class="text-red-600 hover:text-red-900">
                                            Annuleren
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-lg font-medium">Geen afspraken gevonden</p>
                                        <p class="text-sm mt-1">Klik op "Nieuwe afspraak" om een afspraak toe te voegen.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($appointments->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>

            <div class="mt-4 text-sm text-gray-600">
                1 - {{ $appointments->count() }} van {{ $appointments->total() }} afspraken
            </div>
        </div>
    </div>

    <!-- Modal for creating appointment -->
    <div id="appointmentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Nieuwe afspraak</h3>
                <button onclick="closeAppointmentModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('appointments.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Client Selection -->
                    <div>
                        <label for="modal_client_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Klant *
                        </label>
                        <select name="client_id" id="modal_client_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer een klant...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->full_name }} - {{ $client->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Employee Selection -->
                    <div>
                        <label for="modal_employee_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Medewerker *
                        </label>
                        <select name="employee_id" id="modal_employee_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer een medewerker...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}{{ $employee->specialty ? ' - ' . $employee->specialty : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="modal_appointment_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Datum *
                        </label>
                        <input type="date" name="appointment_date" id="modal_appointment_date" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="modal_appointment_time" class="block text-sm font-medium text-gray-700 mb-1">
                            Tijd *
                        </label>
                        <select name="appointment_time" id="modal_appointment_time" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer tijd...</option>
                            @for($hour = 9; $hour < 18; $hour++)
                                @foreach(['00', '15', '30', '45'] as $minute)
                                    @php
                                        $time = sprintf('%02d:%s', $hour, $minute);
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            @endfor
                        </select>
                    </div>

                    <!-- Treatment Selection -->
                    <div class="md:col-span-2">
                        <label for="modal_treatment_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Behandeling *
                        </label>
                        <select name="treatment_id" id="modal_treatment_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer behandeling...</option>
                            @foreach($treatments as $treatment)
                                <option value="{{ $treatment->id }}" 
                                        data-duration="{{ $treatment->duration_minutes }}"
                                        data-price="{{ $treatment->price }}">
                                    {{ $treatment->name }} - €{{ number_format($treatment->price, 2) }} ({{ $treatment->duration_minutes }} min)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="modal_notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notities (optioneel)
                        </label>
                        <textarea name="notes" id="modal_notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Voeg een notitie toe..."></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeAppointmentModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuleren
                    </button>
                    <button type="submit" class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-md">
                        Afspraak opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for editing appointment -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Afspraak bewerken</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" id="editForm" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Client Selection -->
                    <div>
                        <label for="edit_client_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Klant *
                        </label>
                        <select name="client_id" id="edit_client_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer een klant...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->full_name }} - {{ $client->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Employee Selection -->
                    <div>
                        <label for="edit_employee_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Medewerker *
                        </label>
                        <select name="employee_id" id="edit_employee_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer een medewerker...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}{{ $employee->specialty ? ' - ' . $employee->specialty : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="edit_appointment_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Datum *
                        </label>
                        <input type="date" name="appointment_date" id="edit_appointment_date" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="edit_appointment_time" class="block text-sm font-medium text-gray-700 mb-1">
                            Tijd *
                        </label>
                        <select name="appointment_time" id="edit_appointment_time" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer tijd...</option>
                            @for($hour = 9; $hour < 18; $hour++)
                                @foreach(['00', '15', '30', '45'] as $minute)
                                    @php
                                        $time = sprintf('%02d:%s', $hour, $minute);
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            @endfor
                        </select>
                    </div>

                    <!-- Treatment Selection -->
                    <div>
                        <label for="edit_treatment_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Behandeling *
                        </label>
                        <select name="treatment_id" id="edit_treatment_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecteer behandeling...</option>
                            @foreach($treatments as $treatment)
                                <option value="{{ $treatment->id }}">
                                    {{ $treatment->name }} - €{{ number_format($treatment->price, 2) }} ({{ $treatment->duration_minutes }} min)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status *
                        </label>
                        <select name="status" id="edit_status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="bevestigd">Bevestigd</option>
                            <option value="in afwachting">In afwachting</option>
                            <option value="geannuleerd">Geannuleerd</option>
                            <option value="voltooid">Voltooid</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="edit_notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notities (optioneel)
                        </label>
                        <textarea name="notes" id="edit_notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Voeg een notitie toe..."></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuleren
                    </button>
                    <button type="submit" class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-md">
                        Wijzigingen opslaan
                    </button>
                </div>
            </form>
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
        const appointments = @json($appointments->items());

        function openAppointmentModal() {
            document.getElementById('appointmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.querySelector('#appointmentModal form').reset();
        }

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
                const deleteModal = document.getElementById('deleteModal');
                const appointmentModal = document.getElementById('appointmentModal');
                const editModal = document.getElementById('editModal');
                
                if (!deleteModal.classList.contains('hidden')) {
                    closeDeleteModal();
                } else if (!appointmentModal.classList.contains('hidden')) {
                    closeAppointmentModal();
                } else if (!editModal.classList.contains('hidden')) {
                    closeEditModal();
                }
            }
        });

        function openEditModal(appointmentId) {
            const appointment = appointments.find(a => a.id === appointmentId);
            if (!appointment) return;

            // Set form action
            document.getElementById('editForm').action = `/appointments/${appointmentId}`;

            // Fill form fields
            document.getElementById('edit_client_id').value = appointment.client_id;
            document.getElementById('edit_employee_id').value = appointment.employee_id;
            document.getElementById('edit_treatment_id').value = appointment.treatment_id;
            document.getElementById('edit_status').value = appointment.status;
            document.getElementById('edit_notes').value = appointment.notes || '';

            // Parse and set date/time
            const appointmentDate = new Date(appointment.appointment_date);
            const dateStr = appointmentDate.toISOString().split('T')[0];
            const timeStr = appointmentDate.toTimeString().slice(0, 5);
            
            document.getElementById('edit_appointment_date').value = dateStr;
            document.getElementById('edit_appointment_time').value = timeStr;

            // Show modal
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('editForm').reset();
        }

        // Close modals when clicking outside
        document.getElementById('appointmentModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAppointmentModal();
        });

        document.getElementById('editModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
    </script>
</x-app-layout>
