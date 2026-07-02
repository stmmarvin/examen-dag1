<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Action Buttons -->
                    <div class="mb-6 flex justify-between items-center">
                        <a href="{{ route('klanten.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Terug naar overzicht
                        </a>
                        
                        <div class="flex gap-3">
                            <a href="{{ route('klanten.edit', $klant) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Bewerken
                            </a>
                            
                            <form method="POST" action="{{ route('klanten.destroy', $klant) }}" onsubmit="return confirm('Weet u zeker dat u deze klant wilt verwijderen?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Verwijderen
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Klant Details -->
                    <div class="space-y-6">
                        <!-- Personal Information Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Persoonlijke Gegevens</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Voornaam</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->gebruiker->voornaam }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Achternaam</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->gebruiker->achternaam }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->gebruiker->email }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telefoon</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->gebruiker->telefoon }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Geboortedatum</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $klant->geboortedatum ? $klant->geboortedatum->format('d-m-Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Adresgegevens</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Adres</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->adresregel1 ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Postcode</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->postcode ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Plaats</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->plaats ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Allergies Section -->
                        @php
                            $allergieen = $klant->getAllergieen();
                        @endphp
                        @if($allergieen->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Allergieën</h3>
                            <div class="space-y-2">
                                @foreach($allergieen as $allergie)
                                <div class="bg-red-50 border border-red-200 rounded-md p-3">
                                    <p class="text-sm text-gray-900">{{ $allergie->beschrijving }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Wishes Section -->
                        @php
                            $wensen = $klant->getWensen();
                        @endphp
                        @if($wensen->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Wensen</h3>
                            <div class="space-y-2">
                                @foreach($wensen as $wens)
                                <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                    <p class="text-sm text-gray-900">{{ $wens->beschrijving }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Timestamps Section -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-500">
                                <div>
                                    <span class="font-medium">Aangemaakt op:</span> 
                                    {{ $klant->created_at->format('d-m-Y H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">Laatst bijgewerkt:</span> 
                                    {{ $klant->updated_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
