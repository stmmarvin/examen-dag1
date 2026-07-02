@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <!-- Header with back button -->
        <div class="mb-8 flex items-center justify-between border-b border-[#d7c39a] pb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-[#0f1f3a] hover:text-[#c69a3e]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="text-3xl font-bold text-[#0f1f3a]">Afspraak maken</h2>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg border-2 border-green-500 bg-green-50 px-6 py-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg border-2 border-red-500 bg-red-50 px-6 py-4 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="rounded-lg border border-[#d7c39a] bg-white p-8 shadow-lg">
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Employee Selection -->
                    <div>
                        <label for="employee_id" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Kies een medewerker <span class="text-red-500">*</span>
                        </label>
                        <select name="employee_id" id="employee_id" required 
                                class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            <option value="">Selecteer een medewerker...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Treatment Selection -->
                    <div>
                        <label for="treatment_id" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Kies een behandeling <span class="text-red-500">*</span>
                        </label>
                        <select name="treatment_id" id="treatment_id" required 
                                class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
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
                        <label for="appointment_date" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Kies een datum <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="appointment_date" id="appointment_date" required min="{{ date('Y-m-d') }}" 
                               class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="appointment_time" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Kies een tijd <span class="text-red-500">*</span>
                        </label>
                        <select name="appointment_time" id="appointment_time" required 
                                class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">
                            <option value="">Selecteer een tijd...</option>
                            @for($hour = 9; $hour < 18; $hour++)
                                @foreach(['00', '30'] as $minute)
                                    @php $time = sprintf('%02d:%s', $hour, $minute); @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            @endfor
                        </select>
                    </div>

                    <!-- Hidden client_id -->
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <!-- User info -->
                    <div class="rounded-lg border-2 border-[#c69a3e] bg-[#f8f4ea] p-4">
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-[#c69a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-[#0f1f3a]">Afspraak maken als:</p>
                                <p class="text-sm text-[#0f1f3a]">{{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="mb-2 block text-sm font-semibold text-[#0f1f3a]">
                            Opmerkingen (optioneel)
                        </label>
                        <textarea name="notes" id="notes" rows="5" 
                                  placeholder="Bijv. extra opmerkingen..."
                                  class="w-full rounded-md border-2 border-[#d7c39a] px-4 py-3 focus:border-[#c69a3e] focus:outline-none">{{ auth()->user()->allergieen ? 'Allergieën: ' . auth()->user()->allergieen . "\n" : '' }}{{ auth()->user()->wensen ? 'Wensen: ' . auth()->user()->wensen : '' }}</textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between border-t border-[#d7c39a] pt-6">
                        <a href="{{ route('dashboard') }}" 
                           class="rounded-md border-2 border-[#d7c39a] px-6 py-3 text-sm font-bold text-[#0f1f3a] transition hover:bg-[#f8f4ea]">
                            Annuleren
                        </a>
                        <button type="submit" 
                                class="rounded-md px-8 py-4 text-sm font-bold text-white shadow-lg transition hover:shadow-xl" 
                                style="background: #c69a3e;">
                            Afspraak maken
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

@include('behandelingen.partials.page-end')
