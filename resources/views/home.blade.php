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

    <div class="container mx-auto px-4 py-12 text-center">

        <div class="max-w-md mx-auto mb-6 flex items-center text-gray bg-white rounded-full shadow-sm">
            <button id="search-button" class="px-4 text-gray-500 hover:text-[#840032]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
            <input type="text" id="search-input" placeholder="Digite sua Cidade"
                   class="w-full py-2 bg-transparent focus:outline-none">
        </div>
        <h2 class="text-3xl font-extrabold text-gray-800 uppercase mb-4">Encontre a revendedora mais próxima</h2>

        <div id="error" class="text-red-500 mb-6"></div>

        <div id="map" class="h-96 w-full max-w-4xl mx-auto rounded-lg shadow-lg z-10"></div>

    </div>

    <h2 id="topRatedResellers" class="text-3xl font-extrabold text-black text-center uppercase mb-8">Revendedoras mais
        avaliadas</h2>

    <div class="relative">
        <section class="bg-[#840032] py-12">
            <div class="container mx-auto px-4">

                <div class="swiper top-rated-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($topRatedResellers as $reseller)
                            <div class="swiper-slide">
                                <x-reseller-card :reseller="$reseller"/>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($otherResellers as $reseller)
                    <x-reseller-card :reseller="$reseller"/>
                @endforeach
            </div>
        </div>
    </section>

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
