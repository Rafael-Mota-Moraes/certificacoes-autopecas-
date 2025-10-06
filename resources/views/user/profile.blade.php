<x-layout>
    <x-slot:title>
        Perfil de {{ auth()->user()->name }}
    </x-slot:title>

        <x-navigation-bar></x-navigation-bar>
    <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false" class="container mx-auto px-4 py-8">


        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-800 uppercase tracking-widest">Dados da conta</h1>
        </div>


        <div class="mt-8 bg-white m-auto max-w-4xl min-h-70 flex flex-col md:flex-row rounded-2xl border-2 divide-y md:divide-y-0 md:divide-x divide-gray-300 shadow-lg">
            <div class="flex-1 flex-col p-6 md:p-10 text-left md:text-left order-2 md:order-1">
                <div class="max-w-md mx-auto md:mx-0">
                    <p class="text-gray-700 mb-6">
                        <strong class="font-semibold">Nome:</strong> {{ auth()->user()->name }}
                    </p>
                    <hr>
                    <p class="text-gray-700 my-6">
                        <strong class="font-semibold">E-mail:</strong> {{ auth()->user()->email }}
                    </p>
                    <hr>
                    <p class="text-gray-700 my-6">
                        <strong class="font-semibold">CPF:</strong> {{ auth()->user()->cpf }}
                    </p>

                    <div class="mt-6 text-right ">
                        <button @click="modalOpen = true"
                                class="bg-[#840032] p-2 px-4 text-white font-semibold rounded-md hover:bg-[#6a0028] transition-colors ">
                            Atualizar dados
                        </button>
                    </div>
                </div>
            </div>


            <div class="flex-1 p-8 flex flex-col items-center justify-center order-1 md:order-2">
                <form id="photo-form" method="POST" action="{{ route('user.updatePhoto') }}"
                      enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf

                    <input type="file" name="photo" id="photo" class="hidden">

                    <label for="photo" class="cursor-pointer group flex flex-col items-center">
                        <img class="rounded-xl h-32 w-32 object-cover border-2 border-gray-200 group-hover:opacity-80 transition-opacity"
                             src="{{ auth()->user()->profile_photo_url }}" alt="Foto de Perfil">
                        <span class="mt-4 text-sm text-[#840032] hover:underline">
                            Trocar foto de perfil
                        </span>
                    </label>

                    <button type="submit" class="hidden">Enviar</button>
                </form>
            </div>
        </div>


        {{-- Modal de Atualização (sem alterações) --}}
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center"
             style="display: none; background-color: rgba(0, 0, 0, 0.5);">

            <div @click.outside="modalOpen = false"
                 class="bg-white rounded-2xl border-2 border-[#840032] shadow-xl p-8 max-w-md w-full mx-4">
                <h2 class="text-2xl font-black text-center uppercase mb-6 tracking-wider">
                    Atualizar Dados
                </h2>

                <form method="POST" action="{{ route('user.update') }}">
                    @method('PATCH')
                    @csrf
                    {{-- Campos do formulário do modal --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome:</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                               class="w-full px-3 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-[#840032]">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail:</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                               class="w-full px-3 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-[#840032]">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nova Senha:</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-3 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-[#840032]"
                               placeholder="Deixe em branco para não alterar">
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation"
                               class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-[#840032]">
                    </div>
                    <button type="submit"
                            class="w-full py-2 px-4 bg-[#840032] text-white font-semibold rounded-md hover:bg-[#6a0028] transition-colors">
                        Confirmar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script>
    const photoInput = document.getElementById('photo');
    const photoForm = document.getElementById('photo-form');

    photoInput.addEventListener('change', function () {
        if (photoInput.files.length > 0) {
            photoForm.submit();
        }
    });
</script>