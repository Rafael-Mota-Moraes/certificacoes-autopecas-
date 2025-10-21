@props(['review'])

{{-- Card com fundo branco, borda vermelha, altura mínima aumentada e 3 colunas --}}
<div class="bg-white border-2 border-[#840032] rounded-lg p-5 shadow-md h-full flex flex-col min-h-[260px]">

    {{-- Cabeçalho do Card: Avatar, Nome, Estrelas --}}
    <div class="flex items-center gap-4 mb-4">

        {{-- Avatar Placeholder --}}
        <div class="w-12 h-12 bg-gray-200 rounded-full shrink-0"></div>

        {{-- Nome e Estrelas --}}
        <div class="flex-grow">
            <h3 class="text-lg font-bold text-gray-800">
                {{ $review->user->name ?? 'Usuário Anônimo' }}
            </h3>
            <div class="flex shrink-0">
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                @endfor
            </div>
        </div>
    </div>

    {{-- Tags de Comentários (Centralizadas) --}}
    <div class="flex flex-wrap gap-2 justify-center">
        @foreach ($review->comments as $comment)
            <span class="px-3 py-1 rounded-full border border-[#840032] text-[#840032] text-sm">
                {{ $comment->comment }}
            </span>
        @endforeach
    </div>
</div>