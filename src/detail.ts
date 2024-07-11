// function suggestClient() {
//     const telephone = telephoneInput.value;
//     const client = clients.find(client => client.telephone === telephone);
//     if (client) {
//         // Afficher une boîte de dialogue modale pour confirmer l'utilisation des détails du client
//         const confirmation = confirm(`Voulez-vous utiliser les détails du client ${client.nom} (${client.telephone}) ?`);
//         if (confirmation) {
//             // Remplir les champs du formulaire avec les détails du client
//             nomInput.value = client.nom;
//             adresseInput.value = client.adresse;
//         } else {
//             // Effacer les champs si le gestionnaire n'accepte pas
//             nomInput.value = '';
//             adresseInput.value = '';
//         }
//     } else {
//         // Effacer les champs si aucun client correspondant n'est trouvé
//         nomInput.value = '';
//         adresseInput.value = '';
//     }
// }

// document.addEventListener('DOMContentLoaded', function() {
//     const produitForm = document.getElementById('produitForm');
//     produitForm.addEventListener('submit', (event) => {
//         event.preventDefault();
//         addProduct();
//     });
// });

// function addProduct() {
//     const libelle = document.getElementById('libelle').value;
//     const poids = document.getElementById('poids').value;
//     const typeProduit = document.getElementById('type_produit').value;

//     const client = {
//         nom: document.getElementById('client_nom').value,
//         telephone: document.getElementById('client_telephone').value,
//         adresse: document.getElementById('client_adresse').value
//     };

//     const destinataire = {
//         nom: document.getElementById('destinataire_nom').value,
//         telephone: document.getElementById('destinataire_telephone').value,
//         adresse: document.getElementById('destinataire_adresse').value
//     };

//     const newProduct = {
//         libelle: libelle,
//         poids: poids,
//         type_produit: typeProduit,
//         prix_kg: 0, // à calculer si nécessaire
//         prix_total: 0, // à calculer si nécessaire
//         client: client,
//         destinataire: destinataire
//     };

//     // Ajouter le nouveau produit à la cargaison sélectionnée
//     const selectedCargoId = 1; // Exemple, remplacer par l'ID de la cargaison sélectionnée
//     const cargo = cargaisons.find(c => c.id === selectedCargoId);
//     if (cargo) {
//         cargo.produits.push(newProduct);
//         displayProducts(cargo.produits);
//     }

//     // Optionnel: Enregistrer le produit via une requête à l'API
// }

// function displayProducts(products) {
//     const produitList = document.getElementById('produit-list');
//     produitList.innerHTML = ''; // Clear existing rows
//     products.forEach(product => {
//         const newRow = document.createElement('tr');
//         newRow.innerHTML = `
//             <td>${product.libelle}</td>
//             <td>${product.type_produit}</td>
//             <td>${product.poids}</td>
//             <td>${product.prix_kg}</td>
//             <td>${product.prix_total}</td>
//         `;
//         produitList.appendChild(newRow);
//     });
// }

// import { afficherCargaison } from "./cargaisons";

// function detailFonction() {
//     const cargaisonList = document.getElementById('cargaison-list');
//     cargaisonList.addEventListener('click', (event) => {
//         if (event.target.tagName === 'BUTTON') {
//             const cargaisonId = parseInt(event.target.dataset.cargaisonId);
//             const cargaison = cargaisons.find(cargaison => cargaison.id === cargaisonId);
//             afficherCargaison(cargaison);
//         }
//     });
// }