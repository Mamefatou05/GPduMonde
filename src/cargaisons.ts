import { FormField, validators, SubmitCallback, Formulaire, isDateAfter} from "./utils";
import {readDataFromServer, saveNewCargoToServer} from "./api";
import { Cargaison, CargaisonAerienne, CargaisonMaritime, CargaisonRoutiere, ICargaison , formatDate } from "./types/cargaison";
import { Alimentaire, Chimique, Materiel } from "./produit";
let cargos: ICargaison[] = [];
let filteredCargos: ICargaison[] = [];
let currentPage = 1;
const rowsPerPage = 3;


// mode de remplissage
const produitMaxRadio = document.getElementById('produitMaxRadio') as HTMLInputElement ;
const poidsMaxRadio = document.getElementById('poidsMaxRadio') as HTMLInputElement ;
const champProduits = document.getElementById('champ_produits') as HTMLElement ;
const champPoids = document.getElementById('champ_poids') as HTMLElement  ;
const modeRemplissage = document.getElementById('mode_remplissage_hidden') as HTMLInputElement;
const radios = document.querySelectorAll('input[name="mode_remplissage"]');
radios.forEach(radio => {
    radio.addEventListener('change', function () {
        if (produitMaxRadio.checked) {
            champProduits.classList.remove('hidden');
            champPoids.classList.add('hidden');
            modeRemplissage.value = 'produitMax';
        } else if (poidsMaxRadio.checked) {
            champPoids.classList.remove('hidden');
            champProduits.classList.add('hidden');
            modeRemplissage.value = 'poidsMax';
        }
    });
});
// Initialiser
if (produitMaxRadio.checked) {
    champProduits.classList.remove('hidden');
    champPoids.classList.add('hidden');
    modeRemplissage.value = 'produitMax';
} else if (poidsMaxRadio.checked) {
    champPoids.classList.remove('hidden');
    champProduits.classList.add('hidden');
    modeRemplissage.value = 'poidsMax';
}

// console.log(modeRemplissage);
// console.log(modeRemplissage.value);

// Fonction pour récupérer les cargos
export async function fetchCargos(): Promise<void> {
    try {
        console.log('Fetching cargos...');
        const data = await readDataFromServer<{cargaisons: Array<ICargaison>}>('../php/api.php');
        const cargaisons = data?.cargaisons || [];    
        cargos = cargaisons; // Assignation directe puisque c'est un tableau
        filteredCargos = [...cargos];
        displayCargos(); // Assurez-vous que cette fonction est définie ailleurs dans votre code
        console.log('Cargos fetched successfully');
    } catch (error) {
        console.error('Error fetching cargos:', error);
    }
}

export function afficherCargaison(cargaison: ICargaison) {
    const cargaisonName = document.getElementById('cargaison-name') as HTMLElement;
    const cargaisonDate = document.getElementById('cargaison-date') as HTMLElement;
    const cargaisonDepart = document.getElementById('cargaison-depart') as HTMLElement;
    const cargaisonArrivee = document.getElementById('cargaison-arrivee') as HTMLElement;
    const cargaisonTags = document.getElementById('cargaison-tags') as HTMLElement;
    const produitList = document.getElementById('produit-list') as HTMLElement;
    const cargaisonInfo = document.getElementById('cargaison-poids') as HTMLElement;

    if (!cargaisonName || !cargaisonDate || !cargaisonDepart || !cargaisonArrivee  || !cargaisonTags || !produitList || !cargaisonInfo) {
        console.error('Un ou plusieurs éléments requis sont manquants dans le DOM');
        return;
    }

    if (cargaison.etat_Avancement === 'en cours') {
        alert("Les détails de cette cargaison ne sont pas disponibles car elle est en cours.");
        return;
    }

    cargaisonName.textContent = `Cargaison ${cargaison instanceof CargaisonAerienne ? 'Aérienne' : cargaison instanceof CargaisonMaritime ? 'Maritime' : 'Routière'}`;
    cargaisonDate.textContent = cargaison.dateDepart;
    cargaisonDepart.textContent = cargaison.dateDepart;
    cargaisonArrivee.textContent = cargaison.dateArrivee;

    // Calculer et afficher les informations supplémentaires en fonction du mode de remplissage
    if (cargaison.mode_remplissage === 'poidsMax') {
        const poidsTotal = cargaison.produits.reduce((sum, p) => sum + p.poids, 0);
        const poidsRestant = (cargaison.poidsMax ?? 0) - poidsTotal;
        cargaisonInfo.textContent = `Poids restant: ${poidsRestant} kg`;
    } else if (cargaison.mode_remplissage === 'produitMax') {
        const produitsRestants =  (cargaison.produitMax ?? 0)  - cargaison.produits.length;
        cargaisonInfo.textContent = `Produits restants: ${produitsRestants}`;
    } else {
        cargaisonInfo.textContent = '';
    }

    cargaisonTags.innerHTML = '';
    const tags = [
        cargaison instanceof CargaisonAerienne ? 'Aérien' : cargaison instanceof CargaisonMaritime ? 'Maritime' : 'Routier'
    ];
    tags.forEach(tag => {
        const tagElement = document.createElement('span');
        tagElement.className = `bg-blue-200 text-blue-700 px-2 py-1 rounded mr-2`;
        tagElement.textContent = tag;
        cargaisonTags.appendChild(tagElement);
    });

    produitList.innerHTML = '';

    cargaison.produits.forEach(produit => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">${produit.libelle}</td>
            <td class="px-6 py-4 whitespace-nowrap">${produit instanceof Alimentaire ? 'Alimentaire' : produit instanceof Chimique ? 'Chimique' : (produit as Materiel).typeMateriel}</td>
            <td class="px-6 py-4 whitespace-nowrap">${produit.poids} kg</td>
            <td class="px-6 py-4 whitespace-nowrap">${cargaison.calculerFrais(produit) / produit.poids} f cfa</td>
            <td class="px-6 py-4 whitespace-nowrap">${cargaison.calculerFrais(produit)} f cfa</td>
        `;
        produitList.appendChild(row);
    });
}

const CargaisonList = document.getElementById ('CargaisonList') as HTMLElement ;
const CargaisonDetail = document.getElementById ('CargaisonDetail') as HTMLElement ;
let cargaisonCourante = cargos[1];


function detailFonction() {
    const detailButtons = document.querySelectorAll('.detail-btn');
    detailButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const target = event.target as HTMLElement;
            const cargoIdString = target.dataset.id; // Récupérez l'ID en tant que chaîne de caractères
            if (cargoIdString) {
                const cargoId = parseInt(cargoIdString); // Convertissez l'ID en nombre entier
                const cargo = filteredCargos.find(cargo => cargo.id === cargoId);
                if (cargo) {
                    if (cargo.etat_Avancement === 'en cours') {
                        alert("Les détails de cette cargaison ne sont pas disponibles car elle est en cours.");
                        return;
                    }
                    cargaisonCourante = cargo;
                    afficherCargaison(cargaisonCourante);
                    CargaisonList.classList.add('hidden'); // Masquer la liste des cargaisons
                    CargaisonDetail.classList.remove('hidden'); // Afficher les détails de la cargaison
                } else {
                    console.log('Aucune cargaison trouvée avec cet ID');
                }
            } else {
                console.log("L'ID de la cargaison n'est pas défini dans l'attribut dataset");
            }
        });
    });
}
function displayCargos() {
    const tableBody = document.getElementById('cargoTableBody') as HTMLTableElement;
    tableBody.innerHTML = '';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginateCargos = filteredCargos.slice(start, end);

    paginateCargos.forEach(cargo => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="border p-2">${cargo.numero}</td>
            <td class="border p-2">${cargo.mode_remplissage}</td>
            <td class="border p-2">${cargo.mode_remplissage === 'produitMax' ? cargo.produitMax : cargo.poidsMax}</td>
            <td class="border p-2">${cargo.dateDepart}</td>
            <td class="border p-2">${cargo.dateArrivee}</td>
            <td class="border p-2">${cargo.prix_total}</td>
            <td class="border p-2">${cargo.lieu_depart}</td>
            <td class="border p-2">${cargo.lieu_arrivee}</td>
            <td class="border p-2">${cargo.distanceKm}</td>
            <td class="border p-2">${cargo.type}</td>
            <td class="border p-2">${cargo.etat_Avancement}</td>
            <td class="border p-2">
            <button class="state-btn" data-id="${cargo.id}" data-state="${cargo.etat_globale}">
                ${cargo.etat_globale === 'fermer' ? 'Fermer' : 'Ouvert'}
            </button>
        </td>            <td class="border p-2"><button class="detail-btn" data-id="${cargo.id}">Détails</button></td>
        `;
        tableBody.appendChild(row);
    });

    detailFonction(); // Ajouter les gestionnaires d'événements pour les boutons "Détails"
    FermerOuvert() ;

}

 
// Fonction pour attacher les gestionnaires d'événements aux boutons d'état
function FermerOuvert() {
    const stateButtons = document.querySelectorAll('.state-btn')  ;
    stateButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            const target = event.target as HTMLButtonElement | null;
            if (!target) return;
        
            const id = target.dataset.id;
            if (id) {
                await CargoState(id);
            }
        });
    });
}
async function CargoState(id:string) {
    const cargo = filteredCargos.find(c => c.id.toString() === id);
    if (!cargo) return;

    const currentState = cargo.etat_globale.toLowerCase();
    const newState = currentState === 'ouvert' ? 'fermer' : 'ouvert';

    if (currentState === 'fermer' && cargo.etat_Avancement.toLowerCase() !== 'en attente') {
        alert('La cargaison ne peut pas être rouverte car elle n\'est pas en attente.');
        return;
    }

    // Mettre à jour l'état sur le serveur
    try {
        const response = await fetch('api.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ...cargo, etat_globale: newState })
        });

        if (!response.ok) {
            const errorMessage = await response.json();
            alert(errorMessage.message);
            throw new Error('Failed to update cargo state');
        }

        // Mettre à jour l'état localement si la mise à jour sur le serveur a réussi
        cargo.etat_globale = newState;
        displayCargos();

    } catch (error) {
        console.error('Error updating cargo state:', error);
    }
}

// pagination des tableau
function PaginationFonction() {
    const pageInfo = document.getElementById('pageInfo') as HTMLSpanElement;
    const prevPageButton = document.getElementById('prevPage') as HTMLButtonElement;
    const nextPageButton = document.getElementById('nextPage') as HTMLButtonElement;

    const totalPages = Math.ceil(filteredCargos.length / rowsPerPage);
    pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

    prevPageButton.disabled = currentPage === 1;
    nextPageButton.disabled = currentPage === totalPages;
}
document.getElementById('prevPage')?.addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
         displayCargos();
    }
});

document.getElementById('nextPage')?.addEventListener('click', () => {
    const totalPages = Math.ceil(filteredCargos.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        displayCargos();
        
    }
});






// let currentFilters = {
//     searchNumero: '',
//     dateDepart: '',
//     dateArrivee: '',
//     lieuDepart: '',
//     lieuArrivee: '',
//     Etat: 'fermer' // Filtre par défaut pour les cargaisons fermées
// };



// filtre des donner 
const searchNumeroElement = document.getElementById('searchNumero') as HTMLInputElement;
const dateDepartElement = document.getElementById('DateDepar') as HTMLInputElement;
const dateArriveeElement = document.getElementById('dateArriv') as HTMLInputElement;
const lieuDepartElement = document.getElementById('lieuDepart') as HTMLInputElement;
const lieuArriveeElement = document.getElementById('lieuArrivee') as HTMLInputElement;
const StatutElement = document.getElementById('statut') as HTMLInputElement;
const EtatElement = document.getElementById('Etat') as HTMLSelectElement;


const reset = document.getElementById('resetFilters')  as HTMLButtonElement ;

// function applyFilters() {
//     // Check if the date fields are not empty before converting
//     const FormaDatDep = dateDepartElement.value ? formatDate(new Date(dateDepartElement.value)) : '';
//     const FormaDatArr = dateArriveeElement.value ? formatDate(new Date(dateArriveeElement.value)) : '';

//     const searchNumero = searchNumeroElement ? searchNumeroElement.value.toLowerCase() : '';
//     const dateDepart = FormaDatDep ? FormaDatDep : '';
//     const dateArrivee = FormaDatArr ? FormaDatArr : '';
//     const lieuDepart = lieuDepartElement ? lieuDepartElement.value.toLowerCase() : '';
//     const lieuArrivee = lieuArriveeElement ? lieuArriveeElement.value.toLowerCase() : '';
//     const statut = StatutElement ? StatutElement.value.toLowerCase() : '';
//     const etat = EtatElement ? EtatElement.value.toLowerCase() : ''; // Filtre par défaut pour les cargaisons fermées
//     // console.log(statut);
    
//     // console.log(searchNumero, dateDepart, dateArrivee, lieuDepart, lieuArrivee, statut);

//     filteredCargos = cargos.filter(cargo => {
//         return (
//             (searchNumero === '' || cargo.numero.toLowerCase().includes(searchNumero)) &&
//             (dateDepart === '' || cargo.dateDepart === dateDepart) &&
//             (dateArrivee === '' || cargo.dateArrivee === dateArrivee) &&
//             (lieuDepart === '' || cargo.lieu_depart.toLowerCase().includes(lieuDepart)) &&
//             (lieuArrivee === '' || cargo.lieu_arrivee.toLowerCase().includes(lieuArrivee))&&
//             (statut === '' || cargo.etat_Avancement.toLowerCase().includes(statut)) &&
//             (etat === '' || cargo.etat_globale.toLowerCase().includes(etat))  // Filtre par défaut pour les cargaisons fermées

//         );
//     });

//     currentPage = 1;
//     displayCargos();
// }

// function resetFilters() {
//     searchNumeroElement.value = '';
//     dateArriveeElement.value = '';
//     dateDepartElement.value = '';
//     lieuDepartElement.value = '';
//     lieuArriveeElement.value = '';
//     StatutElement.value = '';
//     EtatElement.value = 'Fermer'; // Filtre par défaut pour les cargaisons fermées
    

//     filteredCargos = [...cargos];  // Reset to original data
//     currentPage = 1;
//     displayCargos();
// }
// // Add input event listeners to call applyFilters when the input changes
// searchNumeroElement.addEventListener('input', applyFilters);
// dateDepartElement.addEventListener('input', applyFilters);
// dateArriveeElement.addEventListener('input', applyFilters);
// lieuDepartElement.addEventListener('input', applyFilters);
// lieuArriveeElement.addEventListener('input', applyFilters);
// StatutElement.addEventListener('input', applyFilters);
// EtatElement.addEventListener('change', applyFilters);

// // Add click event listener for the reset button
// reset.addEventListener('click', resetFilters);






// Récupération des champs du formulaire
const formFields: FormField[] = Array.from(
    document.querySelectorAll(`#cargaisonForm [data-label]`)
).map(field => {
    const htmlField = field as HTMLElement;
    return {
        inputId: htmlField.id,
        errorSpanId: `${htmlField.id}Error`,
        validator: validators[htmlField.dataset.label as keyof typeof validators]
    };
});

// Initialisation du formulaire
const submitNewCargo: SubmitCallback = (formData) => {
    const { distance, dateDepart, dateArrivee, type_cargaison, lieu_depart, lieu_arrivee, mode_remplissage } = formData;

    formData.mode_remplissage = modeRemplissage.value;

    const poidsMaxInput = document.getElementById('poid_max') as HTMLInputElement;
    const produitMaxInput = document.getElementById('produitMax') as HTMLInputElement;

    const poidsMax = poidsMaxInput.value ? parseFloat(poidsMaxInput.value) : null;
    const produitMax = produitMaxInput.value ? parseInt(produitMaxInput.value) : null;

    let finalPoidsMax: number | null = null;
    let finalProduitMax: number | null = null;

    if (formData.mode_remplissage === 'poidsMax') {
        finalPoidsMax = poidsMax;
        finalProduitMax = null;
    } else if (formData.mode_remplissage === 'produitMax') {
        finalPoidsMax = null;
        finalProduitMax = produitMax;
    }

    const distanceKm = parseInt(distance);
    if (isNaN(distanceKm) || !dateDepart || !dateArrivee || !type_cargaison) {
        alert("Les données du formulaire sont invalides.");
        return;
    }

  
    
    const dateOrderValidation = isDateAfter(dateDepart, dateArrivee);
    const ErrorDepart =   document.getElementById('dateDepartError') as HTMLSpanElement
    const ErrorArrivee =   document.getElementById('dateArriveeError') as HTMLSpanElement

    if (!dateOrderValidation.valid) {

        ErrorArrivee.innerText = dateOrderValidation.errorMessage;
        return;
    }
    else{

        ErrorArrivee.innerText = "";

        let newCargo: Cargaison;
    switch (type_cargaison) {
        case "maritime":
            newCargo = new CargaisonMaritime(distanceKm, dateDepart, dateArrivee, finalPoidsMax, finalProduitMax, lieu_depart, lieu_arrivee, formData.mode_remplissage);
            break;
        case "aerienne":
            newCargo = new CargaisonAerienne(distanceKm, dateDepart, dateArrivee, finalPoidsMax, finalProduitMax, lieu_depart, lieu_arrivee, formData.mode_remplissage);
            break;
        case "routiere":
            newCargo = new CargaisonRoutiere(distanceKm, dateDepart, dateArrivee, finalPoidsMax, finalProduitMax, lieu_depart, lieu_arrivee, formData.mode_remplissage);
            break;
        default:
            alert("Type de cargaison invalide.");
            return;
    }

    saveNewCargoToServer(newCargo)
        .then(() => {
            alert("Cargaison ajoutée avec succès.");
            fetchCargos();
        })
        .catch((error) => {
            alert(`Erreur lors de l'ajout de la cargaison : ${error.message}`);
        });
    }

    
};                                                          

new Formulaire("cargaisonForm", formFields, submitNewCargo);

fetchCargos();


// // Initialiser les filtres par défaut
// document.addEventListener('DOMContentLoaded', () => {
//     EtatElement.value = 'fermer';
//     applyFilters();
// });

detailFonction();