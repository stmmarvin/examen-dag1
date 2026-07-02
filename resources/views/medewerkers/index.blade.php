@include('behandelingen.partials.page-start')

<main class="flex-1">
    <section class="mx-auto w-full px-8 py-12" style="max-width: 1200px;">
        <div class="mb-8 flex items-center justify-between border-b border-[#d7c39a] pb-6">
            <div>
                <h1 class="text-4xl font-bold text-[#0f1f3a]">Medewerkers Beheer</h1>
                <p class="mt-2 text-lg text-[#0f1f3a] opacity-80">Voeg medewerkers toe, bewerk of verwijder ze</p>
            </div>
            <a href="{{ route('medewerkers.create') }}" 
               class="rounded-md px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:shadow-xl" 
               style="background: #c69a3e;">
                + Nieuwe Medewerker
            </a>
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

        <div class="rounded-lg border border-[#d7c39a] bg-white shadow-lg overflow-hidden">
            @if($medewerkers->count())
                <table class="w-full">
                    <thead class="bg-[#0f1f3a] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">Naam</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Telefoon</th>
                            <th class="px-6 py-4 text-right text-sm font-bold">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#d7c39a]">
                        @foreach($medewerkers as $medewerker)
                            <tr class="hover:bg-[#f8f4ea]">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#0f1f3a]">{{ $medewerker->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-[#0f1f3a]">{{ $medewerker->email }}</td>
                                <td class="px-6 py-4 text-[#0f1f3a]">{{ $medewerker->telefoon ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('medewerkers.edit', $medewerker) }}" 
                                           class="text-[#c69a3e] hover:text-[#0f1f3a] font-semibold">
                                            Bewerken
                                        </a>
                                        <button type="button"
                                                class="font-semibold text-red-600 hover:text-red-800"
                                                data-delete-medewerker
                                                data-medewerker-id="{{ $medewerker->id }}"
                                                data-medewerker-name="{{ $medewerker->name }}">
                                            Verwijderen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center">
                    <p class="text-lg text-[#0f1f3a] opacity-70">Nog geen medewerkers toegevoegd.</p>
                    <a href="{{ route('medewerkers.create') }}" 
                       class="mt-4 inline-block rounded-md px-6 py-3 text-sm font-bold text-white shadow-lg" 
                       style="background: #c69a3e;">
                        Voeg eerste medewerker toe
                    </a>
                </div>
            @endif
        </div>
    </section>

    <div id="medewerker-delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-6">
        <div class="w-full max-w-lg rounded-2xl border border-[#d7c39a] bg-white p-6 shadow-2xl">
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-amber-100 text-lg font-bold text-amber-900">!</span>
                <div class="min-w-0">
                    <h2 class="text-2xl font-bold text-[#0f1f3a]">Medewerker verwijderen</h2>
                    <p class="mt-2 text-sm text-[#0f1f3a] opacity-80">
                        Weet je zeker dat je <span id="medewerker-delete-name" class="font-semibold"></span> wilt verwijderen?
                    </p>
                    <p class="mt-3 text-sm text-[#0f1f3a] opacity-80">
                        Deze actie gebeurt direct op deze pagina.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="medewerker-delete-cancel" class="rounded-md border border-[#d7c39a] px-5 py-2.5 text-sm font-semibold text-[#0f1f3a] hover:bg-[#f8f4ea]">
                    Annuleren
                </button>
                <form id="medewerker-delete-form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-md bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-red-700">
                        Verwijderen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const modal = document.getElementById('medewerker-delete-modal');
            const nameLabel = document.getElementById('medewerker-delete-name');
            const form = document.getElementById('medewerker-delete-form');
            const cancelButton = document.getElementById('medewerker-delete-cancel');
            const deleteButtons = document.querySelectorAll('[data-delete-medewerker]');
            const destroyBaseUrl = @json(url('/medewerkers'));

            const openModal = (medewerkerId, medewerkerName) => {
                nameLabel.textContent = medewerkerName;
                form.action = `${destroyBaseUrl}/${medewerkerId}`;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                form.action = '';
            };

            deleteButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    openModal(button.dataset.medewerkerId, button.dataset.medewerkerName);
                });
            });

            cancelButton.addEventListener('click', closeModal);

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        })();
    </script>
</main>

@include('behandelingen.partials.page-end')
