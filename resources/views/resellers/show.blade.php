<x-layout>
    <x-slot:title>
        Avaliações de {{ $reseller->name }}
    </x-slot:title>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">

                <div class="flex-1 flex justify-center md:justify-start">
                    @if ($hasActiveCertificate)
                        <img src="/images/mini_certificate.svg" alt="Revendedora Certificada" class="w-32 h-auto"
                            title="Esta revendedora é certificada">
                    @endif
                </div>

                <div class="flex-1 text-center">
                    <h1 class="text-4xl font-extrabold text-gray-800 uppercase mb-2">
                        {{ $reseller->name }}
                    </h1>
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-5xl font-bold">{{ number_format($averageRating, 1, ',', '.') }}</span>
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-7 h-7 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>

                @if (!$hasActiveCertificate)
                    <div class="flex-1 flex justify-center md:justify-end">
                        <div class="flex items-center gap-2">

                            <div class="relative">
                                @if ($meetsReviews && $meetsPercentage)
                                    <a href="{{ route('payment', $reseller) }}"
                                        class="text-white font-semibold py-2 px-6 rounded-md transition-colors bg-[#840032] hover:bg-[#6a0028]">
                                        Emitir Certificado
                                    </a>
                                @else
                                    <button
                                        class="text-white font-semibold py-2 px-6 rounded-md transition-colors bg-[#840032] opacity-50 cursor-not-allowed"
                                        disabled>
                                        Emitir Certificado
                                    </button>
                                @endif
                            </div>

                            <div class="relative group">
                                <div
                                    class="w-6 h-6 bg-gray-200 text-gray-700 rounded-full flex items-center justify-center text-sm font-bold cursor-pointer">
                                    ⓘ
                                </div>

                                <div
                                    class="absolute z-10 left-full top-0 ml-2 w-72
                                        bg-white border-2 border-[#840032] rounded-lg p-4 shadow-xl
                                        opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100
                                        transition-all duration-200 ease-in-out
                                        transform-origin-left
                                        pointer-events-none group-hover:pointer-events-auto">


                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            @if ($meetsReviews)
                                                <span class="text-green-500 font-bold text-lg"
                                                    title="Atingido! ({{ $totalReviews }} avaliações)">✓</span>
                                            @else
                                                <span class="text-red-500 font-bold text-lg"
                                                    title="Não atingido ({{ $totalReviews }} avaliações)">✗</span>
                                            @endif
                                            <span class="text-sm text-gray-700">{{ $criteriaReviews }} avaliações</span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            @if ($meetsPercentage)
                                                <span class="text-green-500 font-bold text-lg"
                                                    title="Atingido! ({{ $positivePercentage }}% positivas)">✓</span>
                                            @else
                                                <span class="text-red-500 font-bold text-lg"
                                                    title="Não atingido ({{ $positivePercentage }}% positivas)">✗</span>
                                            @endif
                                            <span class="text-sm text-gray-700">{{ $criteriaPercentage }}% de
                                                avaliações positivas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="flex-1 md:block hidden"></div>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 justify-center mb-10">
                <a href="{{ route('resellers.show', $reseller) }}"
                    class="px-4 py-2 rounded-md border-2 text-sm font-semibold transition-colors
                          {{ !$currentRating ? 'bg-[#840032] text-white border-[#840032]' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    Todas ({{ $totalReviews }})
                </a>

                @for ($star = 5; $star >= 1; $star--)
                    <a href="{{ route('resellers.show', ['reseller' => $reseller, 'rating' => $star]) }}"
                        class="px-4 py-2 rounded-md border-2 text-sm font-semibold transition-colors
                              {{ $currentRating == $star ? 'bg-[#840032] text-white border-[#840032]' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                        {{ $star }} estrelas ({{ $starCounts[$star] }})
                    </a>
                @endfor
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($reviews as $review)
                    <x-review-card :review="$review" />
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        <p class="text-lg">Nenhuma avaliação encontrada para este filtro.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center">
                {{ $reviews->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-layout>
