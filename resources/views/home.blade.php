<x-layout>

    <style>

        @media (max-width: 767px) {

            .swiper-button-prev,
            .swiper-button-next {
                display: none !important;
            }
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: #FFFFFF !important;
            top: 50%;
            transform: translateY(-50%);
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-button-next {
            right: 10px;
        }


        .top-rated-swiper-pagination {
            position: relative;
            bottom: auto;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .top-rated-swiper-pagination .swiper-pagination-bullet {
            background-color: #840032 !important;
            opacity: 0.5;
            width: 10px;
            height: 10px;
        }

        .top-rated-swiper-pagination .swiper-pagination-bullet-active {
            background-color: #840032 !important;
            opacity: 1;
        }
    </style>
    <x-slot:title>
        Página Inicial
    </x-slot:title>
    <div x-data="{
        ratedModalOpen: false,
        detailModalOpen: false,
        selectedResellerId: null,
        selectedReseller: null,
        selectedRating: 0,
        selectedComments: [],
        allComments: {{ $comments->isNotEmpty() ? $comments->toJson() : '[]' }}
    }">
        <div class="container mx-auto px-4 py-12 text-center">

            <div class="max-w-md mx-auto mb-6 flex items-center text-gray bg-white rounded-full shadow-sm">
                <button id="search-button" class="px-4 text-gray-500 hover:text-[#840032]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <input type="text" id="search-input" placeholder="Digite sua Cidade"
                    class="w-full py-2 bg-transparent focus:outline-none">
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 uppercase mb-4">Encontre a revendedora mais próxima</h2>

            <div id="error" class="text-red-500 mb-6"></div>

            <div id="map" class="h-96 w-full max-w-4xl mx-auto rounded-lg shadow-lg z-1"></div>

        </div>

        <h2 id="topRatedResellers" class="text-3xl font-extrabold text-black text-center uppercase mb-8">Revendedoras
            mais
            avaliadas</h2>

        <div class="relative">
            <section class="bg-[#840032] py-12">
                <div class="container mx-auto px-4">

                    <div class="swiper top-rated-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($topRatedResellers as $reseller)
                                <div class="swiper-slide ml-5">
                                    <x-reseller-card :reseller="$reseller" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-prev hidden lg:block"></div>
                    <div class="swiper-button-next hidden lg:block"></div>
                </div>
            </section>

            <div class="swiper-pagination top-rated-swiper-pagination"></div>
        </div>


        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-extrabold text-gray-800 text-center uppercase mb-12">Outras Revendedoras</h2>

                <div class="grid grid-cols-[repeat(auto-fit,minmax(20rem,1fr))] gap-8">
                    @foreach ($otherResellers as $reseller)
                        <x-reseller-card :reseller="$reseller"/>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $otherResellers->links() }}
                </div>
            </div>
        </section>

        <div x-show="ratedModalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center "
            style="display: none; background-color: rgba(0, 0, 0, 0.5);">

            <div @click.outside="ratedModalOpen = false"
                class="bg-white rounded-2xl border-2 border-[#840032] shadow-xl p-8 max-w-xl w-full mx-4">
                <h2 class="text-2xl font-black text-center uppercase mb-6 tracking-wider">
                    Avaliar revendedora
                </h2>
                <form method="POST" action="{{ route('reseller-ratings.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="reseller_id" :value="selectedResellerId">

                    <div class="mb-4">
                        <div class="relative w-max mx-auto">
                            <img :src="`/images/${selectedRating}-star.svg`" alt="Avaliação"
                                class="w-60 h-12 transition-all duration-300 ease-in-out">
                            <div class="absolute top-0 left-0 w-full h-full flex">
                                <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                    <button type="button" @click="selectedRating = star"
                                        class="w-1/5 h-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032]"
                                        :title="`${star} estrela(s)`">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="rating" :value="selectedRating">

                    <div x-show="selectedRating > 0" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" class="mb-6 mt-4">


                        <div class="flex flex-wrap gap-2 justify-center">
                            <template x-for="comment in allComments.filter(c => c.rate == selectedRating)"
                                :key="comment.id">
                                <label :for="'comment_' + comment.id"
                                    :class="{
                                        'bg-[#840032] text-white': selectedComments.some(id => id == comment.id),
                                        'bg-gray-200 text-gray-800 hover:bg-gray-300': !selectedComments.some(id =>
                                            id == comment.id)
                                    }"
                                    class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200 ease-in-out text-sm font-semibold">

                                    <input type="checkbox" :id="'comment_' + comment.id" :value="comment.id"
                                        name="comment_ids[]" x-model="selectedComments" class="hidden">

                                    <span x-text="comment.comment"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-[#840032] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#6a0028] transition-colors">
                            Enviar Avaliação
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div
            x-show="detailModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
            style="display: none;"
        >
            <div
                @click.away="detailModalOpen = false"
                class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 p-6 relative"
            >
                <template x-if="selectedReseller">
                    <div>
                        <img class="absolute top-0 -left-2 z-10 w-30 h-30" src="images/mini_certificate.svg" alt="Certificado">
                        <div class="flex flex-col md:flex-row gap-6 mt-8">
                            <div class="w-full md:w-1/2">
                                <img class="w-full h-64 object-cover rounded-md" :src="selectedReseller.image_url || 'images/car-placeholder.png'" alt="Foto">
                            </div>
                            <div class="w-full md:w-1/2 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-3xl font-bold" x-text="selectedReseller.name"></h2>
                                    <div class="flex items-center">
                                            <span class="text-lg font-bold ml-auto mx-2" x-text="parseFloat(selectedReseller.reviews_avg_rating).toFixed(1).replace('.', ',')"></span>
                                            <img :src="'images/' + Math.ceil(selectedReseller.reviews_avg_rating) + '-star.svg'" alt="Avaliação">
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-4" x-text="'CNPJ: ' + (selectedReseller.cnpj || 'Não informado')"></p>
                                <div class="text-sm text-gray-700 space-y-2">
                                    <p><strong>Endereço:</strong> <span x-text="selectedReseller.address ? `${selectedReseller.address.street} - ${selectedReseller.address.city} - ${selectedReseller.address.state}` : 'Não cadastrado'"></span></p>
                                    <p><strong>Contatos:</strong></p>
                                    <p class="pl-4">Tel: <span x-text="selectedReseller.phone || '(DDD) 99999-9999'"></span></p>
                                    <p class="pl-4">E-mail: <span x-text="selectedReseller.email || 'email@example.com'"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            const map = L.map('map').setView([-14.235, -51.925], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const resellers = @json($resellersForMap);

            resellers.forEach(reseller => {
                if (reseller.address && reseller.address.latitude && reseller.address.longitude) {
                    const marker = L.marker([reseller.address.latitude, reseller.address.longitude]).addTo(map);
                    const popupContent = `...`;
                    marker.bindPopup(popupContent);
                }
            });

            const searchInput = document.getElementById('search-input');
            const searchButton = document.getElementById('search-button');
            let searchedLocationMarker = null;

            const searchLocation = () => {
                const query = searchInput.value;
                if (query.length < 3) {
                    return;
                }

                // URL da API Nominatim
                const apiUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = data[0].lat;
                            const lon = data[0].lon;

                            map.flyTo([lat, lon], 13);

                            if (searchedLocationMarker) {
                                map.removeLayer(searchedLocationMarker);
                            }

                            searchedLocationMarker = L.marker([lat, lon]).addTo(map)
                                .bindPopup(`<b>Resultado para:</b><br>${data[0].display_name}`)
                                .openPopup();

                        } else {
                            let element = document.getElementById('error');

                            element.innerText = 'Localização não encontrada. Tente novamente.';

                            setTimeout(() => {
                                element.innerText = '';
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar localização:', error);
                        alert('Ocorreu um erro ao tentar buscar a localização.');
                    });
            };

            searchButton.addEventListener('click', searchLocation);

            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    searchLocation();
                }
            });

            const swiper = new Swiper('.top-rated-swiper', {
                autoplay: true,
                loop: true,
                spaceBetween: 30,
                slidesPerView: 1,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 40,
                    },
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.top-rated-swiper-pagination',
                    clickable: true,
                },
            });
        </script>
    @endpush
</x-layout>
