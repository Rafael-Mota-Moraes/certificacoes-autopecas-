@props(['reseller'])

@php
    $hasActiveCertificate = $reseller->certificate && $reseller->certificate->status == 'paid';
@endphp

<div class="relative bg-white rounded-lg shadow-lg p-5 flex flex-col h-full">

    @if ($hasActiveCertificate)
        <div class="absolute -top-1 -left-1 z-10" title="Revendedora Certificada">
            <img src="{{ asset('images/mini_certificate.svg') }}" class="w-30 h-30 " alt="Selo de Certificado">
        </div>
    @endif


    <div class="flex items-end justify-between mb-2">
        <span
            class="text-lg font-bold ml-auto mx-2">{{ number_format($reseller->reviews_avg_rating, 1, ',', '') }}</span>
        <img src="images/{{ ceil($reseller->reviews_avg_rating) }}-star.svg" alt="">
    </div>

    <div class="w-full h-48 mb-4">
        <img class="w-full h-full object-cover rounded-md"
            src="{{ $reseller->photo ?? asset('images/car-placeholder.png') }}" alt="Foto">
    </div>

    <h3 class="text-xl font-bold truncate">{{ $reseller->name }}</h3>
    <p class="text-sm text-gray-500 mb-2">CNPJ: {{ $reseller->cnpj ?? 'N/A' }}</p>

    <span class="text-sm text-gray-700">
        {{ $reseller->address ? $reseller->address->city : 'Local não informado' }}
    </span>

    <div class="mt-auto pt-4 flex gap-2">
        <button @click="detailModalOpen = true; selectedReseller = {{ $reseller->toJson() }}"
            class="w-full text-center bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
            Ver Detalhes
        </button>
        <button @click="ratedModalOpen = true; selectedResellerId = {{ $reseller->id }}"
            class="w-full text-center bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-md hover:bg-gray-300 transition-colors">
            Avaliar
        </button>
    </div>
</div>
