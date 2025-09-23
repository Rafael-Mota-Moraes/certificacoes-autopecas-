<header x-data="{ open: false, dropdownOpen: false }" class="bg-white shadow-sm relative z-10">
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
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" x-transition
                             class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg">
                            <div class="divide-y divide-gray-200">
                                <a href="{{ route('user.profile') }}"
                                   class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Ver
                                    perfil</a>
                                <a href="{{route("resellers.create")}}"
                                   class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Cadastrar
                                    revendedora</a>
                                <a href="{{route("resellers.index")}}"
                                   class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Minhas
                                    revendedoras</a>

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
                              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
                <a href="#"
                   class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Reportar
                    erro</a>
            @endguest

            @auth
                <div>
                    <a href="{{route("home")}}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Página
                        inicial</a>
                    <hr class="text-gray-50">

                    <a href="{{route("user.profile")}}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Ver
                        perfil</a>

                    <hr class="text-gray-50">

                    <a href="{{route("resellers.create")}}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Cadastrar
                        revendedora</a>

                    <hr class="text-gray-50">

                    <a href="{{route("resellers.index")}}"
                       class="block px-3 py-2 rounded-md text-base font-medium text-[#840032]  transition-colors">Minhas
                        revendedoras</a>

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
</header>
