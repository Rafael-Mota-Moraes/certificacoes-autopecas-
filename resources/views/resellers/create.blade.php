<x-layout>
    <x-slot:title>
        Cadastro
    </x-slot:title>
    <x-navigation-bar></x-navigation-bar>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="flex flex-col lg:flex-row items-center justify-center lg:space-x-16">
            <div class="w-full lg:max-w-4xl rounded-md">
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">CADASTRO</h1>
                <div class="bg-white p-8 rounded-xl shadow-lg">

                    <form action="{{ route('resellers.store') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col lg:flex-row lg:space-x-12">

                            <div class="w-full lg:w-1/2 space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">*Nome:</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="cnpj" class="block text-sm font-medium text-gray-700">*CNPJ:</label>
                                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" required
                                        class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('cnpj') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <h2 class="text-lg font-semibold pt-4 border-t border-gray-200">Endereço</h2>
                                <div class="flex space-x-4">
                                    <div class="flex-1">
                                        <label for="zip_code"
                                            class="block text-sm font-medium text-gray-700">*CEP:</label>
                                        <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}"
                                            required
                                            class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('zip_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex-1">
                                        <label for="state"
                                            class="block text-sm font-medium text-gray-700">Estado:</label>
                                        <input type="text" id="state" name="state" value="{{ old('state') }}"
                                            class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">Cidade:</label>
                                    <input type="text" id="city" name="city" value="{{ old('city') }}"
                                        class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="street" class="block text-sm font-medium text-gray-700">Rua:</label>
                                    <input type="text" id="street" name="street" value="{{ old('street') }}"
                                        class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                    @error('street') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex space-x-4">
                                    <div class="w-1/3">
                                        <label for="number"
                                            class="block text-sm font-medium text-gray-700">Número:</label>
                                        <input type="text" id="number" name="number" value="{{ old('number') }}"
                                            class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                        @error('number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-2/3">
                                        <label for="photo-label" class="block text-sm font-medium text-gray-700">Foto da
                                            revendedora:</label>
                                        <div
                                            class="mt-1 flex items-center border border-gray-300 rounded-md h-10 px-2 justify-between">
                                            <span id="photo-filename" class="text-sm text-gray-500 truncate">Nenhum
                                                arquivo...</span>
                                            <label for="photo-upload"
                                                class="cursor-pointer inline-flex items-center justify-center h-8 px-3 rounded-md bg-[#840032] hover:bg-[#6e002a] text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                                </svg>
                                            </label>
                                        </div>
                                        <input type="file" id="photo-upload" name="photo" class="hidden">
                                        @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full lg:w-1/2 mt-8 lg:mt-0">
                                <p class="text-lg font-semibold mb-2">Lista de Contatos</p>
                                <div id="contacts-container" class="space-y-4">
                                    <div
                                        class="grid grid-cols-1 border border-gray-300 border-solid p-4 rounded-lg space-y-4">
                                        <div>
                                            <label for="phone"
                                                class="block text-sm font-medium text-gray-700">*Telefone:</label>
                                            <input type="text" id="phone" name="contacts[0][phone]"
                                                value="{{ old('contacts.0.phone') }}" required
                                                class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                            @error('contacts.0.phone') <p class="text-red-500 text-xs mt-1">
                                                {{ $message }}
                                            </p> @enderror
                                        </div>
                                        <div>
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">*E-mail:</label>
                                            <input type="email" id="email" name="contacts[0][email]"
                                                value="{{ old('contacts.0.email') }}" required
                                                class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                                            @error('contacts.0.email') <p class="text-red-500 text-xs mt-1">
                                                {{ $message }}
                                            </p> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <button type="button" id="add-contact-btn"
                                        class="bg-[#840032] text-white font-semibold py-2 px-6 hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors rounded-md">
                                        Adicionar outro contato
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-center space-x-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('resellers.index') }}"
                                class="text-gray-600 font-medium hover:text-gray-900 transition-colors">
                                Voltar
                            </a>
                            <button type="submit"
                                class="bg-[#840032] rounded-md text-white font-bold py-3 px-8 hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors">
                                Cadastrar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addContactBtn = document.getElementById('add-contact-btn');
            const contactsContainer = document.getElementById('contacts-container');
            let contactIndex = 1; // Start index for new contacts

            addContactBtn.addEventListener('click', function () {
                const newContactDiv = document.createElement('div');
                newContactDiv.className = 'grid grid-cols-1 border border-gray-300 border-solid p-4 rounded-lg space-y-4';

                newContactDiv.innerHTML = `
                    <div>
                        <label for="phone-${contactIndex}" class="block text-sm font-medium text-gray-700">Telefone:</label>
                        <input type="text" id="phone-${contactIndex}" name="contacts[${contactIndex}][phone]" required
                            class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                    </div>
                    <div>
                        <label for="email-${contactIndex}" class="block text-sm font-medium text-gray-700">E-mail:</label>
                        <input type="email" id="email-${contactIndex}" name="contacts[${contactIndex}][email]" required
                            class="mt-1 block w-full rounded-md px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                    </div>
                `;
                contactsContainer.appendChild(newContactDiv);
                contactIndex++;
            });

            const photoUpload = document.getElementById('photo-upload');
            const photoFilename = document.getElementById('photo-filename');

            photoUpload.addEventListener('change', function () {
                if (photoUpload.files.length > 0) {
                    photoFilename.textContent = photoUpload.files[0].name;
                } else {
                    photoFilename.textContent = 'Nenhum arquivo...';
                }
            });
        });
    </script>
</x-layout>