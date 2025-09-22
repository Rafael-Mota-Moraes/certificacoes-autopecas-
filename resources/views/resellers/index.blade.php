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
                            class="w-full sm:w-auto bg-[#840032] text-white font-semibold py-2 px-6 rounded-md hover:bg-[#6a0028] transition-colors">
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

    <div class="fixed bottom-24 right-6 lg:hidden">
        <button class="w-14 h-14 bg-[#840032] rounded-full flex items-center justify-center text-white shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>
</x-layout>