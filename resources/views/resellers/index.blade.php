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
                        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col transition-transform hover:scale-105 duration-300 border-2 border-transparent hover:border-[#840032]">

                            <div class="relative w-full h-48 mb-6">
                                @if($reseller->photo)
                                    <img src="{{ asset('storage/' . $reseller->photo) }}"
                                         alt="Foto de {{ $reseller->name }}"
                                         class="object-cover w-full h-full rounded-md">
                                @else
                                    <div class="w-full h-full rounded-md bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Sem foto</span>
                                    </div>
                                @endif
                                <button class="absolute -bottom-3 -right-3 bg-[#840032] text-white rounded-full p-2 hover:bg-[#6a0028] transition-colors shadow-lg"
                                        title="Trocar foto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                         fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd"
                                              d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex-grow space-y-3">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-grow min-w-0">
                                        <h2 class="text-xl font-bold text-gray-800 uppercase truncate"
                                            title="{{$reseller->name}}">{{$reseller->name}}</h2>
                                        <p class="text-sm text-gray-500">
                                            CNPJ: {{$reseller->cnpj ?? 'Não informado'}}</p>
                                    </div>
                                    <a href="{{ route('reseller.show', $reseller) }}"
                                       title="Ver avaliações de {{ $reseller->name }}"
                                       class="text-sm text-[#840032] border border-[#840032] rounded-md px-3 py-1 shrink-0 hover:bg-[#840032] hover:text-white transition-colors">
                                        Ver avaliações
                                    </a>
                                </div>

                                <hr class="my-2">

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

                            <div class="mt-auto pt-6 flex flex-col sm:flex-row items-center gap-3">
                                <button
                                        type="button"
                                        class="w-full bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors open-edit-modal-btn"
                                        data-id="{{ $reseller->id }}">
                                    Atualizar dados
                                </button>

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
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('edit-modal');
                const modalFormContainer = document.getElementById('modal-form-container');
                const openModalButtons = document.querySelectorAll('.open-edit-modal-btn');

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modalFormContainer.innerHTML = '<p class="text-center bg-transparent">Carregando...</p>';
                };

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

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === "Escape" && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });

                modal.addEventListener('click', function (event) {
                    if (event.target.classList.contains('close-modal-btn')) {
                        closeModal();
                    }
                });
            });
        </script>
    @endpush
</x-layout>