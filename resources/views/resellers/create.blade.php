<x-layout>
    <x-slot:title>
        Cadastro
    </x-slot:title>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="flex flex-col lg:flex-row items-center justify-center lg:space-x-16">
            <div class="w-full max-w-4/5 rounded-md">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">CADASTRO</h1>

                    <x-form action="{{ route('resellers.create') }}" method="POST" class="space-y-4">
                        <div class=" items-center grid grid-cols-2 justify-center">
                            <div class="grid grid-cols-1 max-w-3/5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">*Nome:</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cnpj" class="block text-sm font-medium text-gray-700">*CNPJ:</label>
                                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('cnpj')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <h2>Endereço</h2>
                                <div class="flex items-center w-full justify-between pt-1">
                                    <div class="flex-1 pr-4" >
                                        <label for="cep" class="block text-sm font-medium text-gray-700">*CEP:</label>
                                        <input type="text" id="cep" name="cep" value="{{ old('cep') }}" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('cep')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex-1 pl-4">
                                        <label for="state" class="block text-sm font-medium text-gray-700">Estado:</label>
                                        <input type="text" id="state" name="state" value="{{ old('state') }}"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('state')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">Cidade:</label>
                                    <input type="text" id="city" name="city"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="street" class="block text-sm font-medium text-gray-700">Rua:</label>
                                    <input type="text" id="street" name="street"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                </div>

                                <div class="flex items-center w-full justify-between">
                                    <div class="flex-1 w-full pr-4">
                                        <label for="number" class="block text-sm font-medium text-gray-700">Número:</label>
                                        <input type="number" id="number" name="number"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    </div>
                                    <div class="flex-1 w-full pl-4">
                                        <label for="photo-upload" class="block text-sm font-medium text-gray-700">Foto da revendedora:</label>

                                        <div class="mt-1 flex justify-end items-center border border-gray-300 h-10">
                                            <label for="photo-upload"
                                                class="cursor-pointer inline-flex items-center justify-center h-7 w-12 rounded-md bg-[#840032] hover:bg-[#6e002a] text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                                    </svg>

                                            </label>
                                        </div>

                                        <input type="file" id="photo-upload" name="photo" class="hidden">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p> Lista de contatos
                                <div class="grid grid-cols-1 max-w-3/5 border-2 border-black border-solid p-2">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone:</label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('phone')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail:</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <button>Adicionar contato</button>
                            </div>

                            <div class="flex-1 items-right justify-between pt-4">
                                <button type="submit"
                                        class="bg-[#840032] text-white font-semibold py-2 px-6 hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors">
                                    Cadastrar
                                </button>
                            </div>
                        </div>

                    </x-form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
