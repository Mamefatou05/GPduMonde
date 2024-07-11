<?php
// // Charger les données des cargaisons
// $data = json_decode(file_get_contents('data.json'), true);

// // Récupérer l'ID de la cargaison à partir de l'URL
// $cargoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// // Rechercher la cargaison par ID
// $cargo = null;
// foreach ($data['cargaisons'] as $item) {
//     if ($item['id'] === $cargoId) {
//         $cargo = $item;
//         break;
//     }
// }

// // Si la cargaison n'est pas trouvée, afficher un message d'erreur
// if (!$cargo) {
//     echo "Cargaison non trouvée";
// }
?>
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

<!-- <div class="bg-white p-4 rounded shadow-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-purple-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Libellé</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Poids</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix/kg</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix Total</th>
                            </tr>
                        </thead>
                        <tbody id="produit-list" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div> -->
</section>


<script src="../dist/details.js"></script>