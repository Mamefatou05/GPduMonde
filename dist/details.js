/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/detail.ts":
/*!***********************!*\
  !*** ./src/detail.ts ***!
  \***********************/
/***/ (() => {

eval("\n// function suggestClient() {\n//     const telephone = telephoneInput.value;\n//     const client = clients.find(client => client.telephone === telephone);\n//     if (client) {\n//         // Afficher une boîte de dialogue modale pour confirmer l'utilisation des détails du client\n//         const confirmation = confirm(`Voulez-vous utiliser les détails du client ${client.nom} (${client.telephone}) ?`);\n//         if (confirmation) {\n//             // Remplir les champs du formulaire avec les détails du client\n//             nomInput.value = client.nom;\n//             adresseInput.value = client.adresse;\n//         } else {\n//             // Effacer les champs si le gestionnaire n'accepte pas\n//             nomInput.value = '';\n//             adresseInput.value = '';\n//         }\n//     } else {\n//         // Effacer les champs si aucun client correspondant n'est trouvé\n//         nomInput.value = '';\n//         adresseInput.value = '';\n//     }\n// }\n// document.addEventListener('DOMContentLoaded', function() {\n//     const produitForm = document.getElementById('produitForm');\n//     produitForm.addEventListener('submit', (event) => {\n//         event.preventDefault();\n//         addProduct();\n//     });\n// });\n// function addProduct() {\n//     const libelle = document.getElementById('libelle').value;\n//     const poids = document.getElementById('poids').value;\n//     const typeProduit = document.getElementById('type_produit').value;\n//     const client = {\n//         nom: document.getElementById('client_nom').value,\n//         telephone: document.getElementById('client_telephone').value,\n//         adresse: document.getElementById('client_adresse').value\n//     };\n//     const destinataire = {\n//         nom: document.getElementById('destinataire_nom').value,\n//         telephone: document.getElementById('destinataire_telephone').value,\n//         adresse: document.getElementById('destinataire_adresse').value\n//     };\n//     const newProduct = {\n//         libelle: libelle,\n//         poids: poids,\n//         type_produit: typeProduit,\n//         prix_kg: 0, // à calculer si nécessaire\n//         prix_total: 0, // à calculer si nécessaire\n//         client: client,\n//         destinataire: destinataire\n//     };\n//     // Ajouter le nouveau produit à la cargaison sélectionnée\n//     const selectedCargoId = 1; // Exemple, remplacer par l'ID de la cargaison sélectionnée\n//     const cargo = cargaisons.find(c => c.id === selectedCargoId);\n//     if (cargo) {\n//         cargo.produits.push(newProduct);\n//         displayProducts(cargo.produits);\n//     }\n//     // Optionnel: Enregistrer le produit via une requête à l'API\n// }\n// function displayProducts(products) {\n//     const produitList = document.getElementById('produit-list');\n//     produitList.innerHTML = ''; // Clear existing rows\n//     products.forEach(product => {\n//         const newRow = document.createElement('tr');\n//         newRow.innerHTML = `\n//             <td>${product.libelle}</td>\n//             <td>${product.type_produit}</td>\n//             <td>${product.poids}</td>\n//             <td>${product.prix_kg}</td>\n//             <td>${product.prix_total}</td>\n//         `;\n//         produitList.appendChild(newRow);\n//     });\n// }\n// import { afficherCargaison } from \"./cargaisons\";\n// function detailFonction() {\n//     const cargaisonList = document.getElementById('cargaison-list');\n//     cargaisonList.addEventListener('click', (event) => {\n//         if (event.target.tagName === 'BUTTON') {\n//             const cargaisonId = parseInt(event.target.dataset.cargaisonId);\n//             const cargaison = cargaisons.find(cargaison => cargaison.id === cargaisonId);\n//             afficherCargaison(cargaison);\n//         }\n//     });\n// }\n\n\n//# sourceURL=webpack://gpdumonde/./src/detail.ts?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/detail.ts"]();
/******/ 	
/******/ })()
;