<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('appointments.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Nieuwe afspraak
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-600 mb-6">Vul de gegevens in om een nieuwe afspraak te maken.</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <form method="POST" action="{{ route('appointments.store') }}">
                            @csrf

                            <!-- Client Selection -->
                            <div class="mb-6">
                                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Klant
                                </label>
                                <select name="client_id" id="client_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecteer een klant...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->full_name }} - {{ $client->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <button type="button" class="mt-2 text-sm text-indigo-600 hover:text-indigo-900">
                                    + Nieuwe klant toevoegen
                                </button>
                            </div>

                            <!-- Employee Selection -->
                            <div class="mb-6">
                                <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Medewerker
                                </label>
                                <select name="employee_id" id="employee_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecteer een medewerker...</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}{{ $employee->specialty ? ' - ' . $employee->specialty : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date and Time -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Datum
                                    </label>
                                    <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('appointment_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tijd
                                    </label>
                                    <select name="appointment_time" id="appointment_time" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Selecteer tijd...</option>
                                        @for($hour = 9; $hour < 18; $hour++)
                                            @foreach(['00', '15', '30', '45'] as $minute)
                                                @php
                                                    $time = sprintf('%02d:%s', $hour, $minute);
                                                @endphp
                                                <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                                                    {{ $time }}
                                                </option>
                                            @endforeach
                                        @endfor
                                    </select>
                                    @error('appointment_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Treatment Selection -->
                            <div class="mb-6">
                                <label for="treatment_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Behandeling
                                </label>
                                <select name="treatment_id" id="treatment_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecteer behandeling...</option>
                                    @foreach($treatments as $treatment)
                                        <option value="{{ $treatment->id }}" 
                                                data-duration="{{ $treatment->duration_minutes }}"
                                                data-price="{{ $treatment->price }}"
                                                {{ old('treatment_id') == $treatment->id ? 'selected' : '' }}>
                                            {{ $treatment->name }} - €{{ number_format($treatment->price, 2) }} ({{ $treatment->duration_minutes }} min)
                                        </option>
                                    @endforeach
                                </select>
                                @error('treatment_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notities (optioneel)
                                </label>
                                <textarea name="notes" id="notes" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Voeg een notitie toe...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Annuleren
                                </a>
                                <button type="submit" style="background-color: #1E293B;" class="px-6 py-2 hover:opacity-90 text-white font-semibold rounded-md transition">
                                    Afspraak opslaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 shadow-sm rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-semibold mb-4">Samenvatting</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Klant</span>
                                <span class="font-medium" id="summary-client">—</span>
                            </div>
                            
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Medewerker</span>
                                <span class="font-medium" id="summary-employee">—</span>
                            </div>
                            
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Behandeling</span>
                                <span class="font-medium" id="summary-treatment">—</span>
                            </div>
                            
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Datum & tijd</span>
                                <span class="font-medium" id="summary-datetime">—</span>
                            </div>
                            
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Duur</span>
                                <span class="font-medium" id="summary-duration">—</span>
                            </div>
                            
                            <div class="flex justify-between py-2 font-semibold">
                                <span class="text-gray-900">Prijs</span>
                                <span class="text-gray-900" id="summary-price">—</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Update summary when form fields change
        document.getElementById('client_id').addEventListener('change', function() {
            const text = this.options[this.selectedIndex].text;
            document.getElementById('summary-client').textContent = this.value ? text.split(' - ')[0] : '—';
        });

        document.getElementById('employee_id').addEventListener('change', function() {
            const text = this.options[this.selectedIndex].text;
            document.getElementById('summary-employee').textContent = this.value ? text.split(' - ')[0] : '—';
        });

        document.getElementById('treatment_id').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const text = option.text;
            const duration = option.dataset.duration;
            const price = option.dataset.price;
            
            if (this.value) {
                document.getElementById('summary-treatment').textContent = text.split(' - ')[0];
                document.getElementById('summary-duration').textContent = duration + ' minuten';
                document.getElementById('summary-price').textContent = '€' + parseFloat(price).toFixed(2);
            } else {
                document.getElementById('summary-treatment').textContent = '—';
                document.getElementById('summary-duration').textContent = '—';
                document.getElementById('summary-price').textContent = '—';
            }
        });

        function updateDateTime() {
            const date = document.getElementById('appointment_date').value;
            const time = document.getElementById('appointment_time').value;
            
            if (date && time) {
                const dateObj = new Date(date);
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                const formattedDate = dateObj.toLocaleDateString('nl-NL', options);
                document.getElementById('summary-datetime').textContent = formattedDate + ' ' + time;
            } else {
                document.getElementById('summary-datetime').textContent = '—';
            }
        }

        document.getElementById('appointment_date').addEventListener('change', updateDateTime);
        document.getElementById('appointment_time').addEventListener('change', updateDateTime);
    </script>
    @endpush
</x-app-layout>
