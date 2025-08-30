<header x-data="{ open: false }" class="bg-white shadow-sm relative z-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/CertifiCar.svg') }}" alt="CertifiCar Logo" class="h-8 w-auto">
            </a>

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

            <!-- Hamburger Button -->
            <div class="md:hidden">
                <button @click="open = !open"
                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                    aria-label="Abrir menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" x-transition class="md:hidden bg-white shadow-lg absolute w-full">
        <nav class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('login') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">
                Entrar
            </a>

            <a href="{{ route('register') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-[#840032] transition-colors">
                Cadastre-se
            </a>
        </nav>
    </div>
</header>