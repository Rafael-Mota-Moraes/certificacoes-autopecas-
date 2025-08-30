<x-layout>
    <x-slot:title>
        Página Inicial
    </x-slot:title>

    <div class="container mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 uppercase mb-4">Encontre a revendedora mais próxima</h2>
        <div class="max-w-md mx-auto mb-8">
            <input type="text" placeholder="Digite seu CEP ou cidade"
                class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-[#840032]">
        </div>

        <div
            class="bg-gray-300 h-80 w-full max-w-4xl mx-auto rounded-lg flex items-center justify-center text-gray-500 shadow-inner">
            <p class="text-xl">Placeholder para o OpenStreetMaps</p>
        </div>
    </div>

    <h2 class="text-3xl font-extrabold text-black text-center uppercase mb-8">Revendedoras mais avaliadas</h2>
    <section class="bg-[#840032] py-12">
        <div class="container mx-auto px-4">

            <div class="flex space-x-8 overflow-x-auto pb-4 -mx-4 px-4">
                @foreach ($topRatedResellers as $reseller)
                    <x-reseller-card :reseller="$reseller" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-extrabold text-gray-800 text-center uppercase mb-12">Outras Revendedoras</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($otherResellers as $reseller)
                    <x-reseller-card :reseller="$reseller" />
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
