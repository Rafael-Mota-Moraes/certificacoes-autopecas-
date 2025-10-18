@props(['reseller'])
<div class="bg-white shadow-lg overflow-hidden flex flex-col flex-shrink-0 w-80 relative">
    <div class="p-4 flex flex-col flex-grow ">
        @if ($reseller->certificate)
            <img class="absolute top-0 -left-2 z-10 w-30 h-30" src="images/mini_certificate.svg" alt="Certificado">
        @endif

        <div class="flex items-end justify-between mb-2">
            <span
                class="text-lg font-bold ml-auto mx-2">{{ number_format($reseller->reviews_avg_rating, 1, ',', '') }}</span>
            <img src="images/{{ ceil($reseller->reviews_avg_rating) }}-star.svg" alt="">
        </div>

        <img class="w-full h-40 object-cover" src="{{ $reseller->image_url ?? 'images/car-placeholder.png' }}"
            alt="Foto da {{ $reseller->name }}">

        <p class="my-2 font-bold text-xl">
            {{ $reseller->name }}
        </p>

        <p class="mb-4">
            @if ($reseller->address)
                {{ $reseller->address->street }} - {{ $reseller->address->city }} - {{ $reseller->address->state }}
            @else
                Endereço não cadastrado.
            @endif
        </p>

        <div class="flex justify-center items-center">
            <button @click="ratedModalOpen = true; selectedResellerId = {{ $reseller->id }}"
                class="mt-auto block w-25 bg-[#840032] text-white text-center font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
                Avaliar
            </button>
            <button @click="selectedReseller = {{ Js::from($reseller) }}; detailModalOpen = true"
                class="block w-25 mx-2 text-center font-semibold py-2 px-4 rounded-md transition-colors border-1"
                style="color: #840032;">
                Ver mais
            </button>
        </div>
    </div>
</div>