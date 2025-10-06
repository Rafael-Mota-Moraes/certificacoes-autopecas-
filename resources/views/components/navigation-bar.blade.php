
<div class="mb-8 bg-white pt-4">
    <nav class="flex space-x-2 border-b border-gray-200 justify-center">

        <a href="{{ route('user.profile') }}"
           class="py-3 px-6 font-semibold transition-colors text-[#840032]
                          {{ request()->routeIs('user.profile')
                             ? 'bg-gray-300 '
                             : 'bg-transparent  hover:bg-gray-50 ' }}">
            Minha conta
        </a>

        <a href="{{ route('resellers.create') }}"
           class="py-3 px-6 font-semibold transition-colors text-[#840032]
                          {{ request()->routeIs('reseller.create')
                             ? 'bg-gray-300 '
                             : 'bg-transparent  hover:bg-gray-50 ' }}">
            Cadastrar revendedora
        </a>

        <a href="{{ route('resellers.index') }}"
           class="py-3 px-6 font-semibold transition-colors text-[#840032]
                          {{ request()->routeIs('reseller.index')
                             ? 'bg-gray-300 '
                             : 'bg-transparent  hover:bg-gray-50 ' }}">
            Minhas revendedoras
        </a>

    </nav>
</div>