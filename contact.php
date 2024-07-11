
const modifiCargaison = document.getElementById('modifiCargaison') as HTMLButtonElement
const stateModal = document.getElementById('stateModal') as HTMLElement

modifiCargaison.addEventListener('click', () => {
    stateModal.classList.remove('hidden');
});

const closeModalMod = document.getElementById('closeModalBtn') as HTMLButtonElement
const saveStateBtn = document.getElementById('saveStateBtn') as HTMLButtonElement


closeModalMod.addEventListener('click', () => {
    stateModal.classList.add('hidden');
});

saveStateBtn.addEventListener('click', async () => {
    const cargoNumberInput = document.getElementById('cargoNumber') as HTMLInputElement;
    const cargoNumber = cargoNumberInput.value;
    const selectedStateInput = document.querySelector('input[name="state"]:checked') as HTMLInputElement;
    
    if (!cargoNumber || !selectedStateInput) {
        alert('Veuillez entrer le numéro de cargaison et sélectionner un état.');
        return;
    }

    const cargo = filteredCargos.find(c => c.numero.toString() === cargoNumber);
    if (!cargo) {
        alert('Numéro de cargaison invalide.');
        return;
    }

    const newState = selectedStateInput.value;

    try {
        const response = await fetch('api.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ...cargo, etat_Avancement: newState })
        });

        if (!response.ok) {
            const errorMessage = await response.json();
            alert(errorMessage.message);
            throw new Error('Failed to update cargo state');
        }

        cargo.etat_Avancement = newState;
        displayCargos();
        document.getElementById('stateModal')?.classList.add('hidden');

    } catch (error) {
        console.error('Error updating cargo state:', error);
    }
});






// Met à jour les champs de saisie dynamiques
function updateSearchFields() {
    searchFieldsContainer.innerHTML = '';
    const selectedKeys = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    // console.log('Selected Keys:', selectedKeys);

    selectedKeys.forEach(key => {
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = `Rechercher par ${key}`;

        // if ((key = 'date-depart') || (key = 'date-arrivee')) {
        //     input.type = 'date';
        // }
        // else {
        //     input.type = 'text';
        // }
        input.className = 'm-2 text-xs text-black SearchField';
        input.setAttribute('data-criteria', key);
        // console.log('Created input with data-criteria:', input.getAttribute('data-criteria'));
        searchFieldsContainer.appendChild(input);
       


        // console.log('Created input with data-criteria:', key);

        // Ajout de l'événement d'entrée pour chaque champ de recherche
        input.addEventListener('input', filterCargos);
    });
    filterCargos();
}

// Fonction de filtrage
function filterCargos(): void {
    const searchFields =  Array.from(document.getElementsByClassName('SearchField')) as HTMLInputElement[];
    // console.log(fild);
    const filterValues: { [key: string]: string } = {};
    // console.log(searchFields);
    

    searchFields.forEach((field: HTMLInputElement) => {
        console.log('QWERTY');
        

        const criteria: string | null = field.getAttribute('data-criteria');
        // console.log('Field:', field, 'Criteria:', criteria, 'Field Value:', field.value);
        if (criteria !== null) {
            // if (criteria === 'dateDepart' || criteria === 'dateArrivee') {
            //     // Formate la valeur de recherche pour les dates
            //     if (field.value === '') {
            //         filterValues[criteria] = '';
            //     } else {
            //         filterValues[criteria] = formatDate(field.value);
            //         console.log(filterValues[criteria]);
            //     }
            // } else {
               
            // }
            filterValues[criteria] = field.value.toLowerCase();
        }
    });

    // console.log('Filter Values:', filterValues);

    filteredCargos = cargos.filter((cargo: Cargaison) => {
        return Object.keys(filterValues).every((criteria: string) => {
            let cargoValue: string = String((cargo as  any)[criteria] || '').toLowerCase();
            // console.log(cargoValue);
            return cargoValue.includes(filterValues[criteria]);

        });
        
    });

    // console.log('Filtered Cargos:', filteredCargos);

    currentPage = 1; // Reset to first page after filtering
    displayCargos();
}


// Ajouter des écouteurs d'événements pour les cases à cocher et le bouton de réinitialisation des filtres
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateSearchFields);
});

resetFiltersBtn.addEventListener('click', function () {
    checkboxes.forEach(checkbox => checkbox.checked = false);
    updateSearchFields();
});






function generateReceipt(produit: Produit): string {
    return `
        <h1>Reçu d'Achat</h1>
        <p><strong>Code Produit:</strong> ${produit.code}</p>
        <p><strong>Libellé:</strong> ${produit.libelle}</p>
        <p><strong>Poids:</strong> ${produit.poids} kg</p>
        <p><strong>Type de Produit:</strong> ${produit.type_produit}</p>
        <p><strong>Prix Total:</strong> ${produit.prix_total} EUR</p>
        <hr>
        <h2>Informations du Client</h2>
        <p><strong>Nom:</strong> ${produit.client.nom} ${produit.client.prenom}</p>
        <p><strong>Téléphone:</strong> ${produit.client.telephone}</p>
        <p><strong>Email:</strong> ${produit.client.email}</p>
        <p><strong>Adresse:</strong> ${produit.client.adresse}</p>
        <hr>
        <h2>Informations du Destinataire</h2>
        <p><strong>Nom:</strong> ${produit.destinataire.nom} ${produit.destinataire.prenom}</p>
        <p><strong>Téléphone:</strong> ${produit.destinataire.telephone}</p>
        <p><strong>Email:</strong> ${produit.destinataire.email}</p>
        <p><strong>Adresse:</strong> ${produit.destinataire.adresse}</p>
    `;
}

    
    ProduiForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const type_produit = (document.getElementById('type_produit') as HTMLSelectElement).value;
        const libelle = (document.getElementById('libelleProd') as HTMLInputElement).value;
        const poids = parseFloat((document.getElementById('poidsProd') as HTMLInputElement).value);
    
    
        const client: ClientData = { nom: 'Client A', prenom: 'client A', adresse: 'Adresse A', telephone: '1234567890', email:'ft@gmail.com' };
        const destinataire: ClientData = { nom: 'Destinataire A',prenom: 'destinataireA' ,adresse: 'Adresse B', telephone: '0987654321', email:'mg@gmail.com' };
    
        let produitData: ProduitData;
    
        switch (type_produit) {
            case 'chimique':
                const toxicite = parseFloat((document.getElementById('toxicite') as HTMLInputElement).value);
                produitData = {
                    libelle,
                    poids,
                    type_produit: 'Chimique',
                    prix_kg: 0,
                    prix_total: 0,
                    client,
                    destinataire,
                    code: generateUniqueCode()

                };
                break;
            case 'materiel':
                const typeMateriel = (document.getElementById('type_materiel') as HTMLSelectElement).value;
                produitData = {
                    libelle,
                    poids,
                    type_produit: 'Materiel',
                    prix_kg: 0,
                    prix_total: 0,
                    client,
                    destinataire,
                    code: generateUniqueCode()

                };
                break;
            case 'alimentaire':
                produitData = {
                    libelle,
                    poids,
                    type_produit: 'Alimentaire',
                    prix_kg: 0,
                    prix_total: 0,
                    client,
                    destinataire,
                    code: generateUniqueCode()

                };
                break;
            default:
                alert('Type de produit non supporté');
                return;
        }
    
        saveNewProductToServer(produitData, cargaisonCourante.id).then(() => {
            alert("Produit ajouté avec succès.");
            fetchCargos();
        }).catch((error) => {
            alert(`Erreur lors de l'ajout du produit : ${error.message}`);
        });
    });
    


    function afficherCargaisonsDisponibles(cargaisons: Cargaison[]): void {
    const cargaisonList = document.getElementById('choisir-cargaison-list');
    if (cargaisonList) {
        cargaisonList.innerHTML = '';

        cargaisons.forEach((cargaison, index) => {
            const cargaisonItem = document.createElement('div');
            cargaisonItem.className = 'cargaison-item mb-2';
            cargaisonItem.innerHTML = `
                <input type="radio" name="selectedCargaison" value="${index}" id="cargaison${index}">
                <label for="cargaison${index}">${cargaison.type} - Poids max: ${cargaison.poidsMax}, Poids actuel: ${cargaison.poids_total}</label>
            `;
            cargaisonList.appendChild(cargaisonItem);
        });
    }
}














// const formFieldProd: FormField[] = Array.from(
//     document.querySelectorAll(`#produitForm [data-label]`)
//   ).map(field => {
//     const htmlField = field as HTMLElement;
//     return {
//       inputId: htmlField.id,
//       errorSpanId: `${htmlField.id}Error`,
//       validator: validators[htmlField.dataset.label as keyof typeof validators]
//     };
//   });


//   const inputIds = formFieldProd.map(field => field.inputId);
//   console.log(inputIds);


// const submitNewProd: SubmitCallback = (formData) => {

//     const type_produit = formData['type_produit'];
//     const libelle = formData['libelleProd'];
//     const poids = parseFloat(formData['poidsProd']);

//     console.log(formData['type_produit']);


//     const client: ClientData = {
//       nom: formData['client_nom'],
//       prenom: formData['client_prenom'],
//       adresse: formData['client_adresse'],
//       telephone: formData['client_telephone'],
//       email: formData['client_email'],
//     };

//     const destinataire: ClientData = {
//       nom: formData['destinataire_nom'],
//       prenom: formData['destinataire_prenom'],
//       adresse: formData['destinataire_adresse'],
//       telephone: formData['destinataire_telephone'],
//       email: formData['destinataire_email'],
//     };

//     let produitData: ProduitData;

//     switch (type_produit) {
//       case 'chimique':
//         const toxicite = parseFloat(formData['toxicite']);
//         produitData = {
//           libelle,
//           poids,
//           type_produit: 'chimique',
//           prix_kg: 0,
//           prix_total: 0,
//           client,
//           destinataire,
//           code: generateUniqueCode()
//         };
//         break;
//       case 'materiel':
//         const typeMateriel = formData['type_materiel'];
//         produitData = {
//           libelle,
//           poids,
//           type_produit: 'materiel',
//           prix_kg: 0,
//           prix_total: 0,
//           client,
//           destinataire,
//           code: generateUniqueCode()
//         };
//         break;
//       case 'alimentaire':
//         produitData = {
//           libelle,
//           poids,
//           type_produit: 'alimentaire',
//           prix_kg: 0,
//           prix_total: 0,
//           client,
//           destinataire,
//           code: generateUniqueCode()
//         };
//         break;
//       default:
//         alert('Type de produit non supporté');
//         return;
//     }
//     //  saveNewProductToServer(produitData, cargaisonCourante.id);
//     //         .then(() => {
//     //             alert("Cargaison ajoutée avec succès.");
//     //             fetchCargos();
//     //         })
//     //         .catch((error) => {
//     //             alert(`Erreur lors de l'ajout de la cargaison : ${error.message}`);
//     //         });

//     try {
//        saveNewProductToServer(produitData, cargaisonCourante.id);
//       alert("Produit ajouté avec succès.");
//       fetchCargos();

//       // Envoi des notificationsformFieldsCar
//     //   await sendEmail(produitData);
//     //   await sendSms(produitData);
//     } catch (error: unknown) { // Typage de l'erreur comme 'unknown'
//         if (error instanceof Error) {
//           // Si l'erreur est une instance de la classe Error, vous pouvez accéder à ses propriétés spécifiques
//           console.error('Une erreur s\'est produite :', error.message);
//         } else {
//           // Si l'erreur n'est pas une instance de la classe Error, vous pouvez la gérer en tant qu'objet générique
//           console.error('Une erreur s\'est produite :', error);
//         }
//   };
//   };


//   // Generate a unique code for a product
// function generateUniqueCode(): string {
//     return 'PROD-' + Date.now().toString(36) + '-' + Math.random().toString(36).substr(2, 9).toUpperCase();
// }

// new Formulaire("produitForm", formFieldProd, submitNewProd);

// const formFieldsPro: FormField[] = Array.from(
//     document.querySelectorAll(`#produitForm [data-label]`)
//   ).map(field => {
//     const htmlField = field as HTMLElement;
//     return {
//       inputId: htmlField.id,
//       errorSpanId: `${htmlField.id}Error`,
//       validator: validators[htmlField.dataset.label as keyof typeof validators]
//     };
//   });

//   const submitCallback: SubmitCallback = (formData) => {

//     const client: ClientData = {
//               nom: formData['client_nom'],
//               prenom: formData['client_prenom'],
//               adresse: formData['client_adresse'],
//               telephone: formData['client_telephone'],
//               email: formData['client_email'],
//             };

//             const destinataire: ClientData = {
//               nom: formData['destinataire_nom'],
//               prenom: formData['destinataire_prenom'],
//               adresse: formData['destinataire_adresse'],
//               telephone: formData['destinataire_telephone'],
//               email: formData['destinataire_email'],
//             };

//     const produit = creerProduit(formData.libelleProd, parseFloat(formData.poidsProd),parseInt(formData.toxicite), formData.type_materiel, formData.code, formData.type_produit, client, destinataire);
//     afficherCargaisonsDisponibles(produit);
//   };

//   function creerProduit(libelle: string, poids: number, toxicite:number, typeMateriel:string, code:string, type: string, client:ClientData , destinataire:ClientData ): Produit {
//     if (type === 'alimentaire') {
//       return new Alimentaire(libelle, poids, client, destinataire , code);
//     } else if (type === 'chimique') {
//       return new Chimique(libelle, poids,client, destinataire , toxicite, code);
//     } else {
//       return new Materiel(libelle, poids, client, destinataire , typeMateriel, code );
//     }
//   }

//   function afficherCargaisonsDisponibles(produit: Produit) {
//     const choisirCargaisonList = document.getElementById('choisir-cargaison-list') as HTMLElement;
//     choisirCargaisonList.innerHTML = '';
//     choisirCargaisonList.classList.remove('hidden');

//     const cargaisonsFiltrees = cargos.filter(cargaison => {
//       const poidsTotalActuel = cargaison.produits.reduce((total, prod) => total + prod.poids, 0);
//       const peutAjouterProduit = poidsTotalActuel + produit.poids <= (cargaison.poidsMax?? 0);
//       const estCompatible = (produit instanceof Chimique && cargaison instanceof CargaisonMaritime) ||
//                             (produit instanceof Materiel && produit.typeMateriel === 'fragile' && !(cargaison instanceof CargaisonMaritime)) ||
//                             (produit instanceof Alimentaire);

//       return cargaison.produits.length < 10 && peutAjouterProduit && estCompatible;
//     });
<!-- 
//     if (cargaisonsFiltrees.length === 0) {
//       choisirCargaisonList.innerHTML = '<p>Aucune cargaison disponible pour prendre en charge ce produit.</p>';
//     } else {
//       cargaisonsFiltrees.forEach((cargaison, index) => {
//         const cargaisonOption = document.createElement('div');
//         cargaisonOption.classList.add('bg-white', 'p-4', 'rounded', 'shadow-md', 'mb-4');
//         cargaisonOption.innerHTML = `
//           <p>Type: ${cargaison instanceof CargaisonAerienne ? 'Aérienne' : cargaison instanceof CargaisonMaritime ? 'Maritime' : 'Routière'}</p>
//           <p>Distance: ${cargaison.distanceKm} km</p>
//           <p>Nombre de produits: ${cargaison.nbProduits()}</p>
//           <p>Montant total: ${cargaison.sommeTotale()} f cfa</p>
//           <p>Date de Départ: ${cargaison.dateDepart}</p>
//           <p>Date d'Arrivée: ${cargaison.dateArrivee}</p>
//         `;
//         choisirCargaisonList.appendChild(cargaisonOption);
//       });
//     }
//   } -->


//   function getFormData(form: HTMLFormElement): { [key: string]: string } {
//     const formData = new FormData(form);
//     const data: { [key: string]: string } = {};
//     formData.forEach((value, key) => {
//         data[key] = value.toString();
//     });
//     return data;
// }


//   function ajouterProduitALaCargaison(indexCargaison: number, formData: { [key: string]: string }) {

//         const client: ClientData = {
//             nom: formData['client_nom'],
//             prenom: formData['client_prenom'],
//             adresse: formData['client_adresse'],
//             telephone: formData['client_telephone'],
//             email: formData['client_email']
//         };

//         const destinataire: ClientData = {
//             nom: formData['destinataire_nom'],
//             prenom: formData['destinataire_prenom'],
//             adresse: formData['destinataire_adresse'],
//             telephone: formData['destinataire_telephone'],
//             email: formData['destinataire_email']
//         };
//         const produit = creerProduit(formData.libelleProd, parseFloat(formData.poidsProd),parseInt(formData.toxicite), formData.type_materiel, formData.code, formData.type_produit, client, destinataire);

//     const cargaison = cargos[indexCargaison];
//     cargaison.ajouterProduit(produit);

//     afficherCargaison(cargaison);
//   }

// //   function afficherCargaison(cargaison: Cargaison) {
// //     // Logique pour afficher la cargaison mise à jour
// //   }

//   document.addEventListener('DOMContentLoaded', () => {
//     new Formulaire('produitForm', formFields, submitCallback);
//   });




const cargaisonsFiltrees = cargaisons.filter(cargaison => {
        const poidsTotalActuel = cargaison.produits.reduce((total, prod) => total + prod.poids, 0);
        const peutAjouterProduit = poidsTotalActuel + produit.poids <= (cargaison.poidsMax ?? Infinity);
        const estCompatible = (produit instanceof Chimique && cargaison instanceof CargaisonMaritime) ||
                              (produit instanceof Materiel && produit.type_produit === 'fragile' && !(cargaison instanceof CargaisonMaritime)) ||
                              (produit instanceof Alimentaire);

        return cargaison.produits.length < (cargaison.produitMax ?? Infinity) && peutAjouterProduit && estCompatible;
    });















    // if (isset($updatedData['cargaison'])) {
    //     $updatedCargaison = $updatedData['cargaison'];

    //     foreach ($data['cargaisons'] as &$cargaison) {
    //         if ($cargaison['id'] == $updatedCargaison['id']) {
    //             $currentAdvancement = $cargaison['etat_Avancement'];
    //             $newAdvancement = $updatedCargaison['etat_Avancement'] ?? $currentAdvancement;
    //             $currentState = $cargaison['etat_globale'];
    //             $newState = $updatedCargaison['etat_globale'] ?? $currentState;

    //             $validTransitions = [
    //                 'en attente' => ['en cours'],
    //                 'en cours' => ['arriver', 'perdu'],
    //                 'arriver' => [],
    //                 'perdu' => [],
    //             ];

    //             // Validation de la transition d'état d'avancement
    //             if (!in_array($newAdvancement, $validTransitions[$currentAdvancement])) {
    //                 http_response_code(400); // Bad Request
    //                 echo json_encode(array("message" => "État d'avancement invalide"));
    //                 return;
    //             }

    //             // Validation de l'ouverture de la cargaison
    //             if ($newState === 'ouvert' && $currentAdvancement !== 'en attente') {
    //                 http_response_code(403); // Forbidden
    //                 echo json_encode(array("message" => "Seules les cargaisons en attente peuvent être ouvertes"));
    //                 return;
    //             }

    //             $cargaison['etat_Avancement'] = $newAdvancement;
    //             $cargaison['etat_globale'] = $newState;

    //             // Mettre à jour l'état des produits en fonction de l'état de la cargaison
    //             foreach ($cargaison['produits'] as &$produit) {
    //                 if ($newAdvancement === 'en attente') {
    //                     $produit['etat'] = 'en attente';
    //                 } elseif ($newAdvancement === 'en cours') {
    //                     $produit['etat'] = 'en cours';
    //                 } elseif ($newAdvancement === 'perdu') {
    //                     $produit['etat'] = 'perdu';
    //                 } elseif ($newAdvancement === 'arriver') {
    //                     $produit['etat'] = 'arriver';
    //                     $produit['date_arrivee'] = (new DateTime())->format('Y-m-d');
    //                 }
    //             }

    //             // Envoyer un message aux clients si la cargaison est perdue
    //             if ($newAdvancement === 'perdu') {
    //                 $clients = array_map(function ($produit) {
    //                     return $produit['client']['telephone'];
    //                 }, $cargaison['produits']);

    //                 $message = "Votre produit avec le code " . $produit['code'] . " dans la cargaison avec le numéro " . $cargaison['numero'] . " a été perdu.";
    //                 sendSms($clients, $message);
    //             }

    //             // Envoyer un message aux clients si la cargaison est arrivée
    //             if ($newAdvancement === 'arriver') {
    //                 $clients = array_map(function ($produit) {
    //                     return $produit['client']['telephone'];
    //                 }, $cargaison['produits']);

    //                 $message = "La cargaison avec le numéro " . $cargaison['numero'] . " est arrivée. Veuillez vérifier l'état d'avancement de votre produit avec le code " . $produit['code'] . ".";
    //                 sendSms($clients, $message);
    //             }

    //             saveData($data);

    //             http_response_code(200);
    //             echo json_encode(["message" => "Cargaison mise à jour avec succès"]);
    //             return;
    //         }
    //     }

    //     http_response_code(404);
    //     echo json_encode(array("message" => "Cargaison non trouvée"));
    // } elseif (isset($updatedData['produit'])) {
    //     $updatedProduit = $updatedData['produit'];

    //     foreach ($data['cargaisons'] as &$cargaison) {
    //         foreach ($cargaison['produits'] as &$produit) {
    //             if ($produit['id'] == $updatedProduit['id']) {
    //                 $validProductStates = ['arriver', 'perdu', 'recuperer', 'archiver'];
    //                 if (!in_array($updatedProduit['etat'], $validProductStates)) {
    //                     http_response_code(400); // Bad Request
    //                     echo json_encode(array("message" => "État de produit invalide"));
    //                     return;
    //                 }

    //                 if ($cargaison['etat_Avancement'] !== 'arriver' && $updatedProduit['etat'] === 'recuperer') {
    //                     http_response_code(403); // Forbidden
    //                     echo json_encode(array("message" => "Les produits ne peuvent être marqués comme récupérés que si la cargaison est arrivée"));
    //                     return;
    //                 }

    //                 // Mise à jour de l'état du produit
    //                 $produit['etat'] = $updatedProduit['etat'];

    //                 // Destruction du code et de l'id si le produit est marqué comme récupéré
    //                 if ($produit['etat'] === 'recuperer') {
    //                     unset($produit['code']);
    //                     unset($produit['id']);
    //                 }

    //                 saveData($data);

    //                 http_response_code(200);
    //                 echo json_encode(array("message" => "Produit mis à jour avec succès"));
    //                 return;
    //             }
    //         }
    //     }

    //     http_response_code(404);
    //     echo json_encode(array("message" => "Produit non trouvé"));
    // }








function validateProduitInfo(): void {
    const form = document.getElementById('produitForm') as HTMLFormElement;
    const formData = getFormData(form);
    const produit = obtenirProduitCourant(formData);

    const cargaisonsDisponibles = cargos.filter(cargaison => {
        const poidsTotalActuel = cargaison.sommePoids();
        const peutAjouterPoids = poidsTotalActuel + produit.poids <= (cargaison.poidsMax ?? Number.MAX_SAFE_INTEGER);
        const peutAjouterProduit = cargaison.produits.length < (cargaison.produitMax ?? Number.MAX_SAFE_INTEGER);
        const estCompatible = (produit instanceof Chimique && cargaison instanceof CargaisonMaritime) ||
                              (produit instanceof Materiel && produit.type_produit === 'fragile' && !(cargaison instanceof CargaisonMaritime)) ||
                              (produit instanceof Alimentaire);

        return cargaison.etat_Avancement === 'en attente' && cargaison.etat_globale === 'ouvert' && peutAjouterPoids && peutAjouterProduit && estCompatible;
    });


    if (cargaisonsDisponibles.length > 0) {
        afficherCargaisonsDisponibles(cargaisonsDisponibles);
        document.getElementById('cargaisonSelection')?.classList.remove('hidden');

        const selectedCargaisonIndex = getSelectedCargaisonIndex();
        if (selectedCargaisonIndex !== -1) {
            ajouterProduitALaCargaison(selectedCargaisonIndex);
            console.log(ajouterProduitALaCargaison(selectedCargaisonIndex));
        }
    } else {
        alert('Aucune cargaison disponible pour ce produit.');
    }
}





function ajouterProduitALaCargaison(index: number): void {
    const form = document.getElementById('produitForm') as HTMLFormElement;
    const formData = getFormData(form);
    const produit = obtenirProduitCourant(formData);

    const cargaisonsDisponibles = cargos.filter(cargaison => {
        const poidsTotalActuel = cargaison.sommePoids();
        const peutAjouterPoids = poidsTotalActuel + produit.poids <= (cargaison.poidsMax ?? Number.MAX_SAFE_INTEGER);
        const peutAjouterProduit = cargaison.produits.length < (cargaison.produitMax ?? Number.MAX_SAFE_INTEGER);

        return cargaison.etat_Avancement === 'en attente' && cargaison.etat_globale === 'ouvert' && peutAjouterPoids && peutAjouterProduit;
    });
    if (index >= 0 && index < cargaisonsDisponibles.length) {
        const selectedCargaison = cargaisonsDisponibles[index];
        selectedCargaison.ajouterProduit(produit);
        alert('Produit ajouté à la cargaison sélectionnée.');
        saveNewProductToServer(produit, selectedCargaison.id);

        // Afficher le bouton pour continuer au client
        document.getElementById('nextClientButton')?.classList.remove('hidden');
        document.getElementById('nextStepCargaisonButton')?.classList.add('hidden');
    } else {
        alert('Veuillez sélectionner une cargaison valide.');
    }
}