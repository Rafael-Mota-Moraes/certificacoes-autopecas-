<x-layout>
    <x-slot:title>
        Página Inicial
    </x-slot:title>

    <div class="container mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 uppercase mb-4">Encontre a revendedora mais próxima</h2>

        <div class="max-w-md mx-auto mb-6 flex items-center border border-gray-300 rounded-full shadow-sm">
            <input type="text" id="search-input" placeholder="Digite seu CEP ou cidade"
                class="w-full px-4 py-2 bg-transparent rounded-full focus:outline-none">
            <button id="search-button" class="px-4 text-gray-500 hover:text-[#840032]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div id="error" class="text-red-500 mb-6  "></div>

        <div id="map" class="h-96 w-full max-w-4xl mx-auto rounded-lg shadow-lg z-10"></div>

    </div>

    <h2 class="text-3xl font-extrabold text-black text-center uppercase mb-8">Revendedoras mais avaliadas</h2>
    <section class="bg-[#840032] py-12">
        <div class="container mx-auto px-4">

            <div class="flex space-x-8 overflow-x-auto pb-4 -mx-4 px-10 align-content-center m-auto">
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
    @push('scripts')
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
        </script>
    @endpush
</x-layout>
