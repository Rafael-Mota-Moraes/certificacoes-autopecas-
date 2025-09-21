<header x-data="{ open: false, dropdownOpen: false }" class="bg-white shadow-sm relative z-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/CertifiCar.svg') }}" alt="CertifiCar Logo" class="h-8 w-auto">
            </a>

<<<<<<< Updated upstream
            <!-- Desktop Navigation -->
             <div class="md:flex">
                 <nav class="hidden md:flex items-center space-x-4">
                     <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#840032] transition-colors">
                         Entrar
                     </a>
     
                     <a href="{{ route('register') }}"
                         class="bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
                         Cadastre-se
                     </a>
                 </nav>

             </div>
=======
            <nav class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#840032] transition-colors">
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
                            <img class="w-10 rounded-3xl" src="{{auth()->user()->profile_photo_url}}" alt="">

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
                                <a href="#"
                                   class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Ver
                                    perfil</a>
                                <a href="#"
                                   class="block px-4 py-2 text-sm text-center font-medium text-[#840032] hover:bg-gray-100">Cadastrar
                                    revendedora</a>
                                <a href="#"
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
>>>>>>> Stashed changes

            <div class="md:hidden">
<<<<<<< Updated upstream
                <button @click="open = !open"
                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                    aria-label="Abrir menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
=======
                <button @click="open = !open" class="text-gray-500 hover:text-gray-600 focus:outline-none"
                        aria-label="Abrir menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
>>>>>>> Stashed changes
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" @click.away="open = false" x-transition class="md:hidden bg-white shadow-lg absolute w-full">
        <nav class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
<<<<<<< Updated upstream
            <a href="{{ route('login') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">
                Entrar
            </a>

            <a href="{{ route('register') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">
                Cadastre-se
            </a>
=======
            @guest
                <a href="{{ route('login') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">Entrar</a>
                <a href="{{ route('register') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">Cadastre-se</a>
            @endguest

            @auth
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex items-center px-3 mb-3">
                        <div class="flex-shrink-0">
                            <span class="inline-block h-10 w-10 rounded-full bg-gray-200"></span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <a href="#"
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">Ver
                        perfil</a>
                    <a href="#"
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">Cadastrar
                        revendedora</a>
                    <a href="#"
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">Minhas
                        revendedoras</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">
                            Sair
                        </a>
                    </form>
                </div>
            @endauth
>>>>>>> Stashed changes
        </nav>
    </div>
</header>
