<x-layout>
    <x-slot:title>
        Minhas Revendedoras
    </x-slot:title>
    <x-navigation-bar></x-navigation-bar>

    <div class="font-sans p-4 sm:p-6 lg:p-8 min-h-[calc(100vh-145px)]">
        <div class="container mx-auto">
            <h1 class="text-2xl lg:text-3xl font-bold text-center mb-8 uppercase text-gray-800">
                Minhas Revendedoras
            </h1>

            @if($resellers->isEmpty())
                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <p class="text-gray-600">Nenhuma revendedora encontrada.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                    @foreach ($resellers as $reseller)
                        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col transition-transform hover:scale-105 duration-300">

                            <div class="relative w-full h-48 mb-4">
                                @if($reseller->photo)
                                    <img src="{{ asset('storage/' . $reseller->photo) }}"
                                         alt="Foto de {{ $reseller->name }}"
                                         class="object-cover w-full h-full rounded-md">
                                @else
                                    <div class="w-full h-full rounded-md bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Sem foto</span>
                                    </div>
                                @endif
                                <button class="absolute bottom-2 right-2 text-xs bg-black bg-opacity-50 text-white px-2 py-1 rounded-md hover:bg-opacity-75">
                                    Trocar foto
                                </button>
                            </div>

                            {{-- INFORMAÇÕES --}}
                            <div class="flex-grow space-y-4">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800 truncate">{{$reseller->name}}</h2>
                                    <p class="text-sm text-gray-500">CNPJ: {{$reseller->cnpj}}</p>
                                </div>

                                <hr>

                                <div>
                                    <h3 class="font-semibold text-gray-700">Endereço:</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $reseller->address ? $reseller->address->street . ', ' . $reseller->address->number : 'Não informado'  }}
                                    </p>
                                </div>

                                <div>
                                    <h3 class="font-semibold text-gray-700">Contatos:</h3>
                                    @if($reseller->contacts->isNotEmpty())
                                        <p class="text-sm text-gray-600">
                                            Tel: {{ $reseller->contacts->first()->phone ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600">
                                            Email: {{ $reseller->contacts->first()->email ?? 'N/A' }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">Nenhum contato cadastrado.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- BOTÕES DE AÇÃO --}}
                            <div class="mt-auto pt-6 flex flex-col sm:flex-row items-center gap-3">
                                <button
                                        type="button"
                                        class="w-full bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors open-edit-modal-btn"
                                        data-id="{{ $reseller->id }}">
                                    Atualizar dados
                                </button>
                                <form action="{{ route('resellers.destroy', $reseller) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-gray-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-gray-600 transition-colors">
                                        Desativar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
    <div id="edit-modal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.9);">
            <div id="modal-form-container" class="bg-white rounded-lg" style="border-color: rgba(153, 0, 0, 1); border-style: solid; border-width: 2px;">
                <p class="text-center">Carregando...</p>
            </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // 1. Seleciona os elementos do modal uma única vez
                const modal = document.getElementById('edit-modal');
                const modalFormContainer = document.getElementById('modal-form-container');
                const openModalButtons = document.querySelectorAll('.open-edit-modal-btn');

                // 2. Função para fechar o modal
                const closeModal = () => {
                    modal.classList.add('hidden');
                    // Limpa o conteúdo do formulário ao fechar para não mostrar dados antigos
                    modalFormContainer.innerHTML = '<p class="text-center bg-transparent">Carregando...</p>';
                };

                // 3. Adiciona o listener para CADA botão "Atualizar dados"
                openModalButtons.forEach(button => {
                    button.addEventListener('click', async function () {
                        const resellerId = this.dataset.id;
                        console.log("reseller id:", resellerId);
                        modal.classList.remove('hidden'); // Mostra o modal

                        try {
                            const response = await fetch(`/resellers/${resellerId}/edit`);
                            if (!response.ok) {
                                throw new Error('A resposta da rede não foi OK.');
                            }

                            const formHtml = await response.text();
                            modalFormContainer.innerHTML = formHtml;

                        } catch (error) {
                            modalFormContainer.innerHTML = '<p class="text-red-500 text-center">Erro ao carregar os dados. Tente novamente.</p>';
                            console.error('Erro no fetch:', error);
                        }
                    });
                });

                // 4. Adiciona listeners para fechar o modal

                // Clicando fora do conteúdo do modal (no fundo escuro)
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                // Pressionando a tecla "Escape"
                document.addEventListener('keydown', function (event) {
                    if (event.key === "Escape" && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });

                // Clicando em um botão de fechar que possa vir dentro do HTML carregado
                modal.addEventListener('click', function (event) {
                    if (event.target.classList.contains('close-modal-btn')) {
                        closeModal();
                    }
                });
            });
        </script>
    @endpush
</x-layout>
