<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Afspraak maken
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-600 mb-6">Maak een nieuwe afspraak als klant.</p>

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

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Employee Selection -->
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kies een medewerker
                            </label>
                            <select name="employee_id" id="employee_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecteer een medewerker...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }}{{ $employee->specialty ? ' - ' . $employee->specialty : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Treatment Selection -->
                        <div>
                            <label for="treatment_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kies een behandeling
                            </label>
                            <select name="treatment_id" id="treatment_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecteer een behandeling...</option>
                                @foreach($treatments as $treatment)
                                    <option value="{{ $treatment->id }}">
                                        {{ $treatment->name }} - €{{ number_format($treatment->price, 2) }} ({{ $treatment->duration_minutes }} min)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Kies een datum
                            </label>
                            <input type="date" name="appointment_date" id="appointment_date" required min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Time -->
                        <div>
                            <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Kies een tijd
                            </label>
                            <select name="appointment_time" id="appointment_time" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecteer een tijd...</option>
                                @for($hour = 9; $hour < 18; $hour++)
                                    @foreach(['00', '30'] as $minute)
                                        @php $time = sprintf('%02d:%s', $hour, $minute); @endphp
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                @endfor
                            </select>
                        </div>

                        <!-- Hidden client_id - automatically linked to logged in user -->
                        <input type="hidden" name="client_id" value="{{ $client->id }}">

                        <!-- Show user info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium" style="color: #1E293B;">Afspraak maken als:</p>
                                    <p class="text-sm text-gray-600">{{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Opmerkingen (optioneel)
                            </label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Bijv. allergieën, voorkeuren..."></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Annuleren
                            </a>
                            <button type="submit" class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-md">
                                Afspraak maken
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
