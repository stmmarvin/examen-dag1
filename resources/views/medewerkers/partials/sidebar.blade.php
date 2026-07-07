@php
    $active = $active ?? 'index';
    $actieMedewerker = $actieMedewerker ?? null;
    $isEigenaarAccount = $actieMedewerker
    && strtolower((string) data_get($actieMedewerker, 'email', data_get($actieMedewerker, 'gebruiker.email'))) === 'eigenaar@kniplokettiko.nl';
@endphp

<aside class="flex w-[270px] shrink-0 flex-col border-r border-gray-400 px-6 py-6">
    <div>
        <h1 class="text-2xl font-bold">Medewerkers</h1>
        <p class="mt-3 max-w-[180px] text-sm leading-tight">Beheer, bekijk en zoek medewerkers.</p>
    </div>

    <nav class="mt-7 space-y-2 text-sm font-bold">
        <!-- De actieknoppen staan hier centraal, zoals in het wireframe. -->
        <a href="{{ route('medewerkers.index') }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'index' ? 'bg-gray-200' : '' }}">
            <span class="text-lg">⊙</span>
            <span>Alle medewerkers</span>
        </a>
        <a href="{{ route('medewerkers.create') }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'create' ? 'bg-gray-200' : '' }}">
            <span class="text-xl">+</span>
            <span>Nieuwe medewerker</span>
        </a>

        @if ($actieMedewerker)
            <a href="{{ route('medewerkers.edit', $actieMedewerker) }}" class="flex items-center gap-5 rounded px-4 py-4 {{ $active === 'edit' ? 'bg-gray-200' : '' }}">
                <span class="text-lg">✎</span>
                <span>Medewerker bewerken</span>
            </a>

            @if ($isEigenaarAccount)
                <span class="flex cursor-not-allowed items-center gap-5 rounded px-4 py-4 text-gray-400" title="Het eigenaaraccount kan niet worden verwijderd">
                    <span class="text-lg">▱</span>
                    <span>Medewerker verwijderen</span>
                </span>
            @else
                <button type="button" data-sidebar-delete-medewerker data-medewerker-id="{{ $actieMedewerker->id }}" data-medewerker-name="{{ $actieMedewerker->name }}" class="flex w-full items-center gap-5 rounded px-4 py-4 text-left {{ $active === 'delete' ? 'bg-gray-200' : '' }}">
                    <span class="text-lg">▱</span>
                    <span>Medewerker verwijderen</span>
                </button>
            @endif
        @else
            <span class="flex cursor-not-allowed items-center gap-5 rounded px-4 py-4 text-gray-400">
                <span class="text-lg">✎</span>
                <span>Medewerker bewerken</span>
            </span>
            <span class="flex cursor-not-allowed items-center gap-5 rounded px-4 py-4 text-gray-400">
                <span class="text-lg">▱</span>
                <span>Medewerker verwijderen</span>
            </span>
        @endif
    </nav>

    @if ($actieMedewerker && ! $isEigenaarAccount)
        <div id="sidebar-delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-6">
            <div class="w-full max-w-md rounded-2xl border border-gray-300 bg-white p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-[#0f1f3a]">Medewerker verwijderen</h2>
                <p class="mt-3 text-sm text-[#0f1f3a] opacity-80">
                    Weet je zeker dat je <span id="sidebar-delete-name" class="font-semibold"></span> wilt verwijderen?
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="sidebar-delete-cancel" class="rounded-md border border-gray-300 px-5 py-2 text-sm font-semibold text-[#0f1f3a] hover:bg-gray-100">
                        Annuleren
                    </button>
                    <form id="sidebar-delete-form" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-md bg-red-600 px-5 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            (() => {
                const modal = document.getElementById('sidebar-delete-modal');
                const form = document.getElementById('sidebar-delete-form');
                const nameLabel = document.getElementById('sidebar-delete-name');
                const cancelButton = document.getElementById('sidebar-delete-cancel');
                const deleteButton = document.querySelector('[data-sidebar-delete-medewerker]');
                const destroyBaseUrl = @json(url('/medewerkers'));

                if (!modal || !form || !deleteButton) {
                    return;
                }

                const openModal = () => {
                    nameLabel.textContent = deleteButton.dataset.medewerkerName;
                    form.action = `${destroyBaseUrl}/${deleteButton.dataset.medewerkerId}`;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                };

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    form.action = '';
                };

                deleteButton.addEventListener('click', openModal);
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
    @endif

</aside>
