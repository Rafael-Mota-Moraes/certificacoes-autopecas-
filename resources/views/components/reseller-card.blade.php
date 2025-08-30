@props(['reseller'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col flex-shrink-0 w-72">
    <img class="w-full h-40 object-cover" src="{{ $reseller->image_url ?? 'https://via.placeholder.com/300x200' }}"
        alt="Foto da {{ $reseller->name }}">

    <div class="p-4 flex flex-col flex-grow">
        <div class="flex items-center mb-2">
            {{-- <span class="text-lg font-bold text-yellow-500">{{ number_format($reseller->rating, 1, ',', '') }}</span> --}}
            <svg class="w-5 h-5 text-yellow-500 fill-current ml-1" viewBox="0 0 20 20">
                <path
                    d="M10 15l-5.878 3.09 1.123-6.545L.489 7.31l6.572-.955L10 .5l2.939 6.855 6.572.955-4.756 4.235 1.123 6.545z" />
            </svg>
        </div>

        <h3 class="text-lg font-bold text-gray-800">{{ $reseller->name }}</h3>
        <p class="text-sm text-gray-600 mb-4 flex-grow">{{ $reseller->address }}</p>

        <a href="#"
            class="mt-auto block w-full bg-[#840032] text-white text-center font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
            Avaliar
        </a>
    </div>
</div>
