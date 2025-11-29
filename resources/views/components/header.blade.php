<header x-data="{ open: false, dropdownOpen: false, reportModalOpen: false }" class="bg-white border-1 border-b-gray-100 relative z-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('home') }}" class="flex items-center transition-discrete" x-show="!open" x-transition>
                <img src="{{ asset('images/CertifiCar.svg') }}" alt="CertifiCar Logo" class="h-8 w-auto">
            </a>

            <nav class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600  hover:text-[#840032] transition-colors">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
                        Cadastre-se
                    </a>
                @endguest

                @auth
                    <div class="relative" @click.away="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center space-x-2 text-gray-600 hover:text-[#840032] focus:outline-none transition-colors border border-gray-300 rounded-md px-3 py-1.5">
                            <img class="w-10 rounded-3xl" src="{{ auth()->user()->profile_photo_url }}"
                                alt="Foto do perfil">

                            <span>Minha conta</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" x-transition
                            class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg">
                            <div class="divide-y divide-gray-200">
                                <a href="{{ route('user.profile') }}"
                                    class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Ver
                                    perfil</a>
                                <a href="{{ route('resellers.create') }}"
                                    class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Cadastrar
                                    revendedora</a>
                                <a href="{{ route('resellers.index') }}"
                                    class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Minhas
                                    revendedoras</a>

                                <button type="button" @click="reportModalOpen = true; dropdownOpen = false"
                                    class="block w-full px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Reportar
                                    erro</button>


                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block w-full text-center px-4 py-3 text-sm text-white bg-[#840032] hover:bg-[#6a0028] transition-colors rounded-b-md font-bold">
                                        Sair
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </nav>

            <div class="md:hidden">
                <button @click="open = !open" style="color: #840032" class=" hover:text-gray-600 focus:outline-none"
                    aria-label="Abrir menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open " @click.away="open = false" x-transition class="md:hidden bg-white shadow-lg absolute w-full">
        <nav class="px-2 pt-2 pb-3 space-y-1 sm:px-3 ">
            @guest
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Página
                    inicial</a>
                <hr class="text-gray-50">
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Entrar</a>
                <hr class="text-gray-50">
                <a href="{{ route('register') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Cadastre-se</a>
                <hr class="text-gray-50">

                <button type="button" @click="reportModalOpen = true; open = false"
                    class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-[#840032] transition-colors">Reportar
                    erro</button>
            @endguest

            @auth
                <div>
                    <a href="{{ route('home') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Página
                        inicial</a>
                    <hr class="text-gray-50">

                    <a href="{{ route('user.profile') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Ver
                        perfil</a>

                    <hr class="text-gray-50">

                    <a href="{{ route('resellers.create') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Cadastrar
                        revendedora</a>

                    <hr class="text-gray-50">

                    <a href="{{ route('resellers.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Minhas
                        revendedoras</a>

                    <hr class="text-gray-50">

                    <button type="button" @click="reportModalOpen = true; open = false"
                        class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-[#840032] transition-colors">Reportar
                        erro</button>

                    <hr class="text-gray-50">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block px-3 py-2 rounded-md text-base font-medium bg-[#840032] text-white   transition-colors">
                            Sair
                        </a>
                    </form>
                </div>
            @endauth
        </nav>
    </div>

    <div x-show="reportModalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background-color: rgba(0, 0, 0, 0.7); display: none;">

        <div @click.outside="reportModalOpen = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg"
            style="border-color: rgba(153, 0, 0, 1); border-style: solid; border-width: 2px;">

            <h2 class="text-xl font-bold text-center mb-6 uppercase text-gray-800">Reportar um Problema</h2>

            <form method="POST" action="{{ route('user_report.store') }}">
                @csrf

                @guest
                    <div class="mb-4">
                        <label for="report_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Seu Email (para podermos entrar em contato)
                        </label>
                        <input type="email" id="report_email" name="email"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-[#840032] focus:border-[#840032]"
                            placeholder="seu@email.com" required value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endguest

                <div class="mb-4">
                    <label for="report_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Por favor, descreva o problema que você encontrou:
                    </label>
                    <textarea id="report_message" name="report" rows="5"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-[#840032] focus:border-[#840032]"
                        placeholder="Ex: O botão de 'Salvar' não está funcionando na página de perfil..." required>{{ old('report') }}</textarea>
                    @error('report')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" @click="reportModalOpen = false"
                        class="bg-white text-[#840032] border border-[#840032] font-semibold py-2 px-4 rounded-md hover:bg-gray-100 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
                        Enviar Relatório
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
