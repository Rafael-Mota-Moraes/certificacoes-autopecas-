<x-layout>
    <x-slot:title>
        Minhas Revendedoras
    </x-slot:title>
    <x-navigation-bar></x-navigation-bar>

    <div class="font-sans p-4 sm:p-6 lg:p-8 min-h-[calc(100vh-145px)]">
        <div class="container mx-auto">

            @if (session('success'))
                <div class="mb-6 max-w-4xl mx-auto p-4 rounded-md bg-green-100 border border-green-300 text-green-800"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-6 max-w-4xl mx-auto p-4 rounded-md bg-yellow-100 border border-yellow-300 text-yellow-800"
                    role="alert">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 max-w-4xl mx-auto p-4 rounded-md bg-red-100 border border-red-300 text-red-800"
                    role="alert">
                    <ul class="list-disc list-inside text-left">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h1 class="text-2xl lg:text-3xl font-bold text-center mb-8 uppercase text-gray-800">
                Minhas Revendedoras
            </h1>

            @if ($resellers->isEmpty())
                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <p class="text-gray-600">Nenhuma revendedora encontrada.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                    @foreach ($resellers as $reseller)
                        <div
                            class="bg-white rounded-xl shadow-lg p-6 flex flex-col transition-transform hover:scale-105 duration-300 border-2 border-transparent hover:border-[#840032] {{ $reseller->trashed() ? 'opacity-50' : '' }}">

                            <div class="relative w-full h-48 mb-6">
                                <img src="{{ $reseller->photo }}" alt="Foto de {{ $reseller->name }}"
                                    class="object-cover w-full h-full rounded-md">

                                <button type="button"
                                    class="absolute -bottom-3 -right-3 bg-[#840032] text-white rounded-full p-2 hover:bg-[#6a0028] transition-colors shadow-lg open-photo-modal-btn"
                                    title="Trocar foto" data-action="{{ route('resellers.updatePhoto', $reseller) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex-grow space-y-3">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-grow min-w-0">
                                        <h2 class="text-xl font-bold text-gray-800 uppercase truncate"
                                            title="{{ $reseller->name }}">{{ $reseller->name }}</h2>
                                        <p class="text-sm text-gray-500">
                                            CNPJ: {{ $reseller->cnpj ?? 'Não informado' }}</p>
                                    </div>
                                    <a href="{{ route('resellers.show', $reseller) }}"
                                        title="Ver avaliações de {{ $reseller->name }}"
                                        class="text-sm text-[#840032] border border-[#840032] rounded-md px-3 py-1 shrink-0 hover:bg-[#840032] hover:text-white transition-colors">
                                        Ver avaliações
                                    </a>
                                </div>

                                <hr class="my-2">

                                <div>
                                    <h3 class="font-semibold text-gray-700">Endereço:</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $reseller->address ? $reseller->address->street . ', ' . $reseller->address->number : 'Não informado' }}
                                    </p>
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-700">Contatos:</h3>
                                    @if ($reseller->contacts->isNotEmpty())
                                        <p class="text-sm text-gray-600">
                                            Tel: {{ $reseller->contacts->first()->phone ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600">
                                            Email: {{ $reseller->contacts->first()->email ?? 'N/A' }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">Nenhum contato cadastrado.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-auto pt-6 flex flex-col sm:flex-row items-center gap-3">
                                <button type="button"
                                    class="w-full bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors open-edit-modal-btn"
                                    data-id="{{ $reseller->id }}">
                                    Atualizar dados
                                </button>

                                @if ($reseller->trashed())
                                    <div class="relative w-full">
                                        <form action="{{ route('resellers.restore', $reseller->id) }}" method="POST"
                                            class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-green-600 transition-colors">
                                                Reativar
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="relative w-full">
                                        <form action="{{ route('resellers.destroy', $reseller) }}" method="POST"
                                            class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-white text-[#840032] border border-[#840032] font-semibold py-2 px-4 rounded-md hover:bg-gray-100 transition-colors">
                                                Desativar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>
    </div>

    <div id="edit-modal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50"
        style="background-color: rgba(0, 0, 0, 0.9);">
        <div id="modal-form-container" class="bg-white rounded-lg"
            style="border-color: rgba(153, 0, 0, 1); border-style: solid; border-width: 2px;">
            <p class="text-center">Carregando...</p>
        </div>
    </div>

    <div id="photo-modal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50"
        style="background-color: rgba(0, 0, 0, 0.9);">
        <div class="bg-white rounded-lg p-6 w-full max-w-md"
            style="border-color: rgba(153, 0, 0, 1); border-style: solid; border-width: 2px;">
            <h2 class="text-xl font-bold text-center mb-6 uppercase text-gray-800">Atualizar Foto</h2>
            <form id="photo-form" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="photo_upload" class="block text-sm font-medium text-gray-700 mb-2">Selecione a nova
                        imagem:</label>
                    <input type="file" name="photo" id="photo_upload"
                        class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="flex justify-end gap-4 mt-6">
                    <button type="button"
                        class="bg-white text-[#840032] border border-[#840032] font-semibold py-2 px-4 rounded-md hover:bg-gray-100 transition-colors close-photo-modal-btn">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
                        Salvar Foto
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('edit-modal');
                const modalFormContainer = document.getElementById('modal-form-container');
                const openModalButtons = document.querySelectorAll('.open-edit-modal-btn');

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modalFormContainer.innerHTML = '<p class="text-center bg-transparent">Carregando...</p>';
                };

                openModalButtons.forEach(button => {
                    button.addEventListener('click', async function() {
                        const resellerId = this.dataset.id;
                        modal.classList.remove('hidden');

                        try {
                            const response = await fetch(`/resellers/${resellerId}/edit`);
                            if (!response.ok) {
                                throw new Error('A resposta da rede não foi OK.');
                            }
                            const formHtml = await response.text();
                            modalFormContainer.innerHTML = formHtml;
                        } catch (error) {
                            modalFormContainer.innerHTML =
                                '<p class="text-red-500 text-center">Erro ao carregar os dados. Tente novamente.</p>';
                            console.error('Erro no fetch:', error);
                        }
                    });
                });

                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                modal.addEventListener('click', function(event) {
                    if (event.target.classList.contains('close-modal-btn')) {
                        closeModal();
                    }
                });

                const photoModal = document.getElementById('photo-modal');
                const photoForm = document.getElementById('photo-form');
                const openPhotoModalButtons = document.querySelectorAll('.open-photo-modal-btn');

                const closePhotoModal = () => {
                    photoModal.classList.add('hidden');
                    photoForm.action = '';
                    photoForm.reset();
                };

                openPhotoModalButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.stopPropagation();
                        const actionUrl = this.dataset.action;
                        photoForm.action = actionUrl;
                        photoModal.classList.remove('hidden');
                    });
                });

                photoModal.addEventListener('click', function(event) {
                    if (event.target === photoModal || event.target.classList.contains(
                            'close-photo-modal-btn')) {
                        closePhotoModal();
                    }
                });

                document.addEventListener('keydown', function(event) {
                    if (event.key === "Escape") {
                        if (!modal.classList.contains('hidden')) {
                            closeModal();
                        }
                        if (!photoModal.classList.contains('hidden')) {
                            closePhotoModal();
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layout>
