 <!-- <div class="w-64 bg-white p-4 mt-3 shadow flex align-center">
     <div class=" w-full  bg-white shadow-md  pt-20 divide-y divide-gray-300 divide-dashed  group-hover:opacity-100 transition duration-300 group-hover:visible">
         <a href="index.php?page=dashboard" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
             <img src="./assets/dashboard.png" alt="sofa" class="w-5 h-5 object-contain">
             <span class="ml-6 text-gray-600 text-sm">Dashboard</span>
         </a>
         <a href="index.php?page=cargaisons" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
             <img src="./assets/cargaison.png" alt="" class="w-5 h-5 object-contain">
             <span class="ml-6 text-gray-600 text-sm">Cargaisons</span>
         </a>
         <a href="index.php?page=Clients" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
             <img src="./assets/client-fidele.png" alt="" class="w-5 h-5 object-contain">
             <span class="ml-6 text-gray-600 text-sm">Clients</span>
         </a>
         <a href="index.php?page=produit" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
             <img src="./assets/colis.png" alt="" class="w-5 h-5 object-contain">
             <span class="ml-6 text-gray-600 text-sm">Produit</span>
         </a>
     </div>
 </div>
 -->

<aside id="Asidebar"  class="fixed top-0 left-0 h-full w-64 z-10 transition-bg bg-custom md:bg-transparent">
        <div class="flex justify-between items-center p-4 md:hidden">
            <div class="text-white font-bold">Brand</div>
            <button id="menu-button" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <ul id="menu" class="md:block mt-4 p-4 hidden md:space-y-4">
            <li><a href="#" class="block font-bold text-white nav-link">Home</a></li>
            <li><a href="#" class="block font-bold text-white nav-link">About</a></li>
            <li><a href="#" class="block font-bold text-white nav-link">Services</a></li>
            <li><a href="#" class="block font-bold text-white nav-link">Contact</a></li>
        </ul>
</aside>
<script>
    document.getElementById('menu-button').addEventListener('click', function() {
    var menu = document.getElementById('menu');
    menu.classList.toggle('hidden');

    var sidebar = document.getElementById('Asidebar');
    if (menu.classList.contains('hidden')) {
        sidebar.classList.remove('md:block');
    } else {
        sidebar.classList.add('md:block');
    }
});




 <!-- navbar -->



// if ($requestMethod === 'PUT' || $requestMethod === 'PATCH') {
//     $updatedData = json_decode(file_get_contents('php://input'), true);
//     if (isset($inputData['id']) && isset($inputData['etat_globale'])) {
//         foreach ($data['cargaisons'] as &$cargaison) {
//             if ($cargaison['id'] == $inputData['id']) {
//                 if (isset($inputData['etat_globale'])) {
//                     $cargaison['etat_globale'] = $inputData['etat_globale'];
//                 }
//                 if (isset($inputData['etat_Avancement'])) {
//                     $cargaison['etat_Avancement'] = $inputData['etat_Avancement'];

//                 }

//                 if ($productId && isset($inputData['etat'])) {
//                     foreach ($cargaison['produits'] as &$produit) {
//                         if ($produit['id'] == $productId) {
//                             $produit['etat'] = $inputData['etat'];
//                         }
//                     }
//                 }


//                 saveData($data);

//                 http_response_code(200);
//                 echo json_encode(array("message" => "Cargaison mise à jour avec succès"));
//                 exit();


//             }

//         }
//         http_response_code(404);
//         echo json_encode(array("message" => "Cargaison non trouvée"));
//     } else {
//         http_response_code(400);
//         echo json_encode(array("message" => "Données invalides"));
//     }

// }
