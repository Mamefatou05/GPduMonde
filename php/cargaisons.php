<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Cargaisons</h1>


    <!-- You can open the modal using ID.showModal() method -->
    <button class="btn" onclick="my_modal_3.showModal()">open modal</button>
    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <!-- Formulaire pour ajouter une cargaison -->
            <section id="ajouter-cargaison" class="">
                <h1 class="text-2xl font-bold text-gray-700 mb-6">Ajouter une Cargaison</h1>
                <div class="bg-gray-100 p-4 rounded shadow-md">
                    <form id="cargaisonForm" method="POST" class="space-y-4">
                        <div>
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
                            <input type="lieu" id="lieu_arriver" name="lieu_arriver" data-label="isNotEmpty" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="lieu_arriverError" class="text-red-500 h-5 text-sm"></div>
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
                            <label for="poid_max" class="block text-sm font-medium text-gray-700">Poid Maximum</label>
                            <input type="number" id="poid_max" name="poid_max" data-label="isPositiveNumber" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <div id="poid_maxError" class="text-red-500 h-5 text-sm"></div>
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
                            <input type="number" id="produitMax" name="produitMax" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div id="champ_poids" class="hidden">
                            <label for="poidsMax" class="block text-sm font-medium text-gray-700">Poids maximal de la cargaison (kg)</label>
                            <input type="number" id="poidsMax" name="poidsMax" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <input type="hidden" id="mode_remplissage_hidden" name="mode_remplissage">

                        <div class="container flex justify-between">
                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Ajouter Cargaison</button>
                            <button type="reset" class="bg-gray-500 text-white px-4 py-2 rounded">Annuler</button>
                        </div>
                    </form>
                </div>
                <div id="map"></div>
            </section>
        </div>
    </dialog>

    <!-- Filters and search -->
    <div class="mb-4 mt-4">
        <input type="text" id="searchNumero" placeholder="Recherche par Numéro" class="border p-2 mb-2">
        <select id="filterCategorie" class="border p-2">
            <option value="all">Toutes les catégories</option>
            <option value="date_depart">Date de Départ</option>
            <option value="date_arrivee">Date d'Arrivée</option>
            <option value="lieu_depart">Lieu de Départ</option>
            <option value="lieu_arrivee">Lieu d'Arrivée</option>
        </select>
        <input type="text" id="filterValue" placeholder="Valeur du Filtre" class="border p-2">
        <button id="applyFilters" class="bg-green-500 text-white p-2">Appliquer Filtres</button>
    </div>

    <!-- Table to display cargos -->
    <table class="table-auto text-sm w-full border-collapse border">
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

<script src="../dist/cargaisons.js"></script>