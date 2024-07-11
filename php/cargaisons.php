<style>
    #map {
        height: 180px;
    }
</style>


<section id="CargaisonList" class="">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Cargaisons</h1>


        <!-- You can open the modal using ID.showModal() method -->
        <button class="btn" onclick="my_modal_3.showModal()">Ajouter Cargaison</button>
        <dialog id="my_modal_3" class="">
            <div class="container absolute">
                <form method="dialog" <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <!-- Formulaire pour ajouter une cargaison -->
                <h1 class="text-2xl font-bold text-gray-700 mb-6">Ajouter une Cargaison</h1>
                <div class="bg-gray-100  p-4 rounded shadow-md">
                    <form id="cargaisonForm" method="POST" class="space-y-4">
                        <div class="w-1/2">
                            <label for="type_cargaison" class="block text-sm font-medium text-gray-700">Type de Cargaison</label>
                            <select id="type_cargaison" name="type_cargaison" data-label="isNotEmpty" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">veuillez selectionner le types</option>
                                <option value="aerienne">Aérienne</option>
                                <option value="maritime">Maritime</option>
                                <option value="routiere">Routière</option>
                            </select>
                            <div id="type_cargaisonError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <div>
                            <label for="lieu_depart" class="block text-sm font-medium text-gray-700">Lieu de depart</label>
                            <input type="lieu" id="lieu_depart" name="lieu_depart" data-label="isNotEmpty" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="lieu_departError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <div>
                            <label for="lieu_arrivee" class="block text-sm font-medium text-gray-700">Lieu d'arriver</label>
                            <input type="lieu" id="lieu_arrivee" name="lieu_arrivee" data-label="isNotEmpty" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="lieu_arriveeError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <div>
                            <label for="distance" class="block text-sm font-medium text-gray-700">Distance</label>
                            <input type="distance" id="distance" name="distance" data-label="isPositiveNumber" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="distanceError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <div>
                            <label for="dateDepart" class="block text-sm font-medium text-gray-700">Date de Départ</label>
                            <input type="date" id="dateDepart" name="dateDepart" data-label="isValidDate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="dateDepartError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <div>
                            <label for="dateArrivee" class="block text-sm font-medium text-gray-700">Date d'Arrivée</label>
                            <input type="date" id="dateArrivee" name="date_arrivee" data-label="isValidDate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="dateArriveeError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mode de remplissage de la cargaison</label>
                            <div class="mt-1">
                                <input type="radio" id="produitMaxRadio" name="mode_remplissage" value="produitMax">
                                <label for="produitMaxRadio" class="ml-2 text-sm text-gray-700">Par nombre de produits</label>
                            </div>
                            <div class="mt-1">
                                <input type="radio" id="poidsMaxRadio" name="mode_remplissage" value="poidsMax">
                                <label for="poidsMaxRadio" class="ml-2 text-sm text-gray-700">Par poids maximal</label>
                            </div>
                        </div>
                        <div id="champ_produits" class="hidden">
                            <label for="produitMax" class="block text-sm font-medium text-gray-700">Nombre de produits max</label>
                            <input type="number" id="produitMax" name="produitMax" data-label="isPositiveNumberNull" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div id="champ_poids" class="hidden">
                            <label for="poid_max" class="block text-sm font-medium text-gray-700">Poid Maximal de la Cargaison (Kg)</label>
                            <input type="number" id="poid_max" name="poid_max" data-label="isPositiveNumberNull" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="poid_maxError" class="text-red-500 h-5 text-sm"></div>
                        </div>
                        <input type="hidden" id="mode_remplissage_hidden" name="mode_remplissage">

                        <div class="container flex justify-between">
                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Ajouter Cargaison</button>
                            <button type="reset" class="bg-gray-500 text-white px-4 py-2 rounded">Annuler</button>
                        </div>
                        <div id="map"></div>
                    </form>
                </div>
            </div>
        </dialog>

        <!-- Filters and search -->
        <div class="bg-white p-4 rounded text-black shadow-md mb-4 flex flex-col mt-4">
            <div>
                <input type="text" id="searchNumero" placeholder="Recherche par Numéro" class="border p-2 mb-2 w-full rounded">
            </div>
            <div class="flex flex-row">
                <div class="mb-2">
                    <label for="DateDepar" class="block">Date de Départ</label>
                    <input type="date" id="DateDepar" class="border p-2 w-full rounded">
                </div>
                <div class="mb-2">
                    <label for="dateArriv" class="block">Date d'Arrivée</label>
                    <input type="date" id="dateArriv" class="border p-2 w-full rounded">
                </div>
                <div class="mb-2">
                    <label for="lieuDepart" class="block">Lieu de Départ</label>
                    <input type="text" id="lieuDepart" placeholder="Lieu de Départ" class="border p-2 w-full rounded">
                </div>
                <div class="mb-2">
                    <label for="lieuArrivee" class="block">Lieu d'Arrivée</label>
                    <input type="text" id="lieuArrivee" placeholder="Lieu d'Arrivée" class="border p-2 w-full rounded">
                </div>
                <div class="mb-2">
                    <label for="statut" class="block">Status</label>
                    <input type="text" id="statut" placeholder="status" class="border p-2 w-full rounded">
                </div>
                <div class="mb-2">
                    <select id="Etat">
                        <option value="fermer">Fermé</option>
                        <option value="">Tous</option>
                        <option value="ouvert">Ouvert</option>
                    </select>
                </div>


            </div>

            <!-- New Reset Button -->
            <button id="resetFilters" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Réinitialiser</button>
        </div>


        <!-- Table to display cargos -->
        <table class="table-auto text-sm w-full border-collapse border text-black">
            <thead>
                <tr>
                    <th class="border p-2">Numéro</th>
                    <th class="border p-2">Mode de remplissage</th>
                    <th class="border p-2">Poids Max/produit Max</th>
                    <th class="border p-2">Date Départ</th>
                    <th class="border p-2">Date Arrivée</th>
                    <th class="border p-2">Prix Total</th>
                    <th class="border p-2">Lieu Départ</th>
                    <th class="border p-2">Lieu Arrivée</th>
                    <th class="border p-2">Distance (km)</th>
                    <th class="border p-2">Type</th>
                    <th class="border p-2">Statut</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="cargoTableBody">
                <!-- Data will be inserted here dynamically -->
            </tbody>
        </table>

        <!-- Pagination controls -->
        <div id="paginationControls" class="mt-4">
            <button id="prevPage" class="bg-gray-500 text-white p-2">Précédent</button>
            <span id="pageInfo" class="mx-2"></span>
            <button id="nextPage" class="bg-gray-500 text-white p-2">Suivant</button>
        </div>
    </div>
</section>
<section id="CargaisonDetail" class="hidden">
    <div class="w-full m-4">

        <div class="flex justify-between items-center mb-6">
            <h1 id="cargaison-name" class="text-2xl font-bold text-gray-700"></h1>
            <div>
                <button id="cargaison-date" class="bg-purple-600 text-white px-4 py-2 rounded"></button>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow-md mb-6">
            <div class="container flex justify-between">
                <div class="flex items-center mb-4">
                    <span id="cargaison-type-icon" class="block w-8 h-8 bg-gray-200 rounded-full mr-4"></span>
                    <div>
                        <span id="cargaison-type" class="text-lg font-bold text-purple-700"></span>
                        <div id="cargaison-tags" class="flex mt-1">
                            <!-- Tags will be dynamically added here -->
                        </div>
                    </div>
                </div>
                <div>
                    <button class="bg-purple-600 text-white px-4 py-2 rounded" id="produits-link2">Produits / Colis</button>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-700">Départ:</span>
                    <span id="cargaison-depart" class="text-purple-700 font-bold"></span>
                </div>
                <div>
                    <span class="text-gray-700">Arrivée:</span>
                    <span id="cargaison-arrivee" class="text-purple-700 font-bold"></span>
                </div>
                <div>
                    <span class="text-gray-700"></span>
                    <span id="cargaison-poids" class="text-purple-700 font-bold"></span>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="../dist/cargaisons.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


    var depart;
    var arrive;

    function handleClick(e) {
        const arriv = document.getElementById('lieu_arrivee');
        console.log(arriv);
        const depar = document.getElementById('lieu_depart');

        if (!depart || (depar.value == "")) {
            //effacer dabord le marqueur depart si il y en a un
            if (depart) {
                map.removeLayer(depart);
            }
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            var url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    var country = data.address.country;
                    depar.value = country;
                })
                .catch(error => {
                    console.error(error);
                });
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup('Depart ').openPopup();
            depart = marker;

        } else if (!arrive || (arriv.value == "")) {
            //effacer dabord le marqueur arrive si il y en a un
            if (arrive) {
                map.removeLayer(arrive);
            }
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            var url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    var country = data.address.country;
                    arriv.value = country;
                })
                .catch(error => {
                    console.error(error);
                });
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup('Arrivee ').openPopup();
            arrive = marker;
        }

        calculateDistance();
    }

    function calculateDistance() {
        var distance = depart.getLatLng().distanceTo(arrive.getLatLng()) / 1000;
        const distanceElement = document.getElementById('distance');
        distanceElement.value = distance.toFixed(2);
    }

    map.on('click', handleClick);
</script>