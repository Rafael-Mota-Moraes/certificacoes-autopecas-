<x-layout>
    <x-slot:title>
        Minhas Revendedoras
    </x-slot:title>

    <div class="font-sans p-4 sm:p-6 lg:p-8 min-h-[calc(100vh-145px)]">
        <div class="container mx-auto">
            <h1 class="text-2xl lg:text-3xl font-bold text-center mb-6">
                MINHAS REVENDEDORAS
            </h1>

            <div class="bg-white p-8 rounded-xl shadow-lg">
                @if($resellers->isEmpty())
                    <div class="text-center">
                        <p>Nenhuma revendedora encontrada.</p>
                    </div>
                @else
                    @foreach ($resellers as $reseller)
                        <div class="flex flex-col lg:flex-row gap-8 justify-between">

                            <div class="flex-1 space-y-4 border-r border-gray-300 p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-x-8 gap-y-4">
                                    <div class="border-b-1 border-gray-300">
                                        <h3 class="font-semibold text-gray-600">Nome da revendedora:</h3>
                                        <p class="text-gray-600">{{$reseller->name}}</p>
                                    </div>
                                    <div class="border-b-1 border-gray-300">
                                        <h3 class="font-semibold text-gray-600">CNPJ:</h3>
                                        <p class="text-gray-600">{{$reseller->cnpj}}</p>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-600">Endereço:</h3>
                                        <p class="text-gray-600">
                                            {{ $reseller->address ? $reseller->address->street . ', ' . $reseller->address->number : 'N/A'  }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 space-y-4 border-r border-gray-300 p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-x-8 gap-y-4">
                                    @if($reseller->contacts->isNotEmpty())
                                        <div class="border-b-1 border-gray-300">
                                            <h3 class="font-semibold text-gray-600">Contato:</h3>
                                            <p class="text-gray-600">Telefone: {{ $reseller->contacts->first()->phone }}</p>
                                        </div>
                                        <div class="border-b-1 border-gray-300">
                                            <h3 class="font-semibold text-gray-600">E-mail:</h3>
                                            <p class="text-gray-600">{{ $reseller->contacts->first()->email }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full lg:w-1/3 flex flex-col items-center justify-center space-y-2">
                                @if($reseller->photo)
                                    <img src="{{ asset('storage/' . $reseller->photo) }}" alt="Reseller Photo"
                                        class="object-cover w-full h-full rounded-md">
                                @else
                                    <span class="text-gray-500">Sem foto</span>
                                @endif
                                <button class="text-sm text-[#840032] font-semibold hover:underline">
                                    Trocar foto
                                </button>
                            </div>

                        </div>
                        <div class="flex items-center gap-4 pt-4 mt-4">
                            <button
                                type="button"
                                class="w-full sm:w-auto bg-[#840032] text-white font-semibold py-2 px-6 rounded-md hover:bg-[#6a0028] transition-colors open-edit-modal-btn"
                                data-id="{{ $reseller->id }}">
                                Atualizar dados
                            </button>
                            <button
                                class="w-full sm:w-auto bg-[#840032] text-white font-semibold py-2 px-6 rounded-md hover:bg-[#6a0028] transition-colors">
                                Desativar
                            </button>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 hidden z-50">
            <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Editar Revendedora</h2>
                <div id="modal-form-container">
                    <p class="text-center">Carregando...</p>
                </div>
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
                modalFormContainer.innerHTML = '<p class="text-center">Carregando...</p>';

            openModalButtons.forEach(button => {
                button.addEventListener('click', async function () {
                    const resellerId = this.dataset.id;
                    modal.classList.remove('hidden');

                    try {
                        const response = await fetch(`/resellers/${resellerId}/edit-form`);
                        if (!response.ok) throw new Error('Network response was not ok.');

                        const formHtml = await response.text();
                        modalFormContainer.innerHTML = formHtml;
                    } catch (error) {
                        modalFormContainer.innerHTML = '<p class="text-red-500 text-center">Erro ao carregar os dados. Tente novamente.</p>';
                        console.error('Fetch error:', error);
                    }
                });
            });

            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.classList.contains('close-modal-btn')) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === "Escape") {
                    closeModal();
                }
            });
        });
        </script>
    @endpush
</x-layout>
