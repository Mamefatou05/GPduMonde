import { FormField, validators, SubmitCallback, Formulaire } from "./utils";
import {readDataFromServer, saveNewCargoToServer} from "./api";
import { Cargaison, CargaisonAerienne, CargaisonMaritime, CargaisonRoutiere, ICargaison } from "./types/cargaison";
import { Alimentaire, Chimique, Materiel } from "./produit";

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

let cargos: ICargaison[] = [];
let filteredCargos: ICargaison[] = [];
let currentPage = 1;
const rowsPerPage = 3;
// Fonction pour récupérer les cargos
export async function fetchCargos(): Promise<void> {
    try {
        console.log('Fetching cargos...');
        const data = await readDataFromServer<{cargaisons: Array<ICargaison>}>('../php/api.php');
        const cargaisons = data?.cargaisons || [];    
        cargos = cargaisons; // Assignation directe car nous avons vérifié que c'est un tableau
        filteredCargos = [...cargos];
        displayCargos(); // Assurez-vous que cette fonction est définie ailleurs dans votre code
        console.log('Cargos fetched successfully');
    } catch (error) {
        console.error('Error fetching cargos:', error);
    }
}
export function displayCargos(): void {
    const tableBody = document.getElementById('cargoTableBody') as HTMLTableElement;
    tableBody.innerHTML = '';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedCargos = filteredCargos.slice(start, end);

    for (const cargo of paginatedCargos) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="border p-2">${cargo.numero}</td>
            <td class="border p-2">${cargo.mode_remplissage}</td>
            <td id="champ_value" class="border p-2">${cargo.mode_remplissage === 'produitMax' ? cargo.produitMax : cargo.poidsMax}</td>
            <td class="border p-2">${cargo.dateDepart}</td>
            <td class="border p-2">${cargo.dateArrivee}</td>
            <td class="border p-2">${cargo.prix_total}</td>
            <td class="border p-2">${cargo.lieu_depart}</td>
            <td class="border p-2">${cargo.lieu_arrivee}</td>
            <td class="border p-2">${cargo.distanceKm}</td>
            <td class="border p-2">${cargo.type}</td>
            <td class="border p-2">${cargo.etat_Avancement}</td>
            <td class="border p-2">${cargo.etat_globale}</td>
        `;
        tableBody.appendChild(row);
    }

    updatePaginationControls();

}

// function afficherCargaisons(cargaisons: Cargo[]): void {
//     const tbody = document.querySelector("#tbody_cargo") as HTMLTableSectionElement;
//     tbody.innerHTML = "";

//     cargaisons.forEach(cargo => {
//         const tr = document.createElement("tr");
//         tr.innerHTML = `
//             <td>${cargo.id}</td>
//             <td>${cargo.numero}</td>
//             <td>${cargo.type}</td>
//             <td>${cargo.distance_km}</td>
//             <td>${cargo.prix_total}</td>
//             <td>${cargo.mode_remplissage === 'produit' ? cargo.produit_max : cargo.poids_max}</td>
//             <td>${cargo.lieu_depart}</td>
//             <td>${cargo.lieu_arrivee}</td>
//             <td>${cargo.mode_remplissage}</td>
//             <td>${cargo.etat_avancement}</td>
//             <td>${cargo.etat_globale}</td>
//         `;
//         tbody.appendChild(tr);
//     });
// }



function updatePaginationControls() {
    const pageInfo = document.getElementById('pageInfo') as HTMLSpanElement;
    const prevPageButton = document.getElementById('prevPage') as HTMLButtonElement;
    const nextPageButton = document.getElementById('nextPage') as HTMLButtonElement;

    const totalPages = Math.ceil(filteredCargos.length / rowsPerPage);
    pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

    prevPageButton.disabled = currentPage === 1;
    nextPageButton.disabled = currentPage === totalPages;
}
function applyFilters() {
    const searchNumero = (document.getElementById('searchNumero') as HTMLInputElement).value.toLowerCase();
    const filterCategorie = (document.getElementById('filterCategorie') as HTMLSelectElement).value;
    const filterValue = (document.getElementById('filterValue') as HTMLInputElement).value.toLowerCase();

    filteredCargos = cargos.filter(cargo => {
        return (
            (searchNumero === '' || cargo.numero.toLowerCase().includes(searchNumero)) &&
            (filterCategorie === 'all' ||
                (filterCategorie === 'dateDepart' && cargo.dateDepart.toISOString().split('T')[0] === filterValue) ||
                (filterCategorie === 'dateArrivee' && cargo.dateArrivee.toISOString().split('T')[0] === filterValue) ||
                (filterCategorie === 'lieu_depart' && cargo.lieu_depart.toLowerCase().includes(filterValue)) ||
                (filterCategorie === 'lieu_arrivee' && cargo.lieu_arrivee.toLowerCase().includes(filterValue)))
        );
    });

    currentPage = 1;
    displayCargos();
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




// Fonction pour soumettre une nouvelle cargaison
const submitNewCargo: SubmitCallback = (formData) => {
    // Ajout de la récupération du mode de remplissage
    formData.mode_remplissage =  modeRemplissage.value;

    const { distance, dateDepart, dateArrivee, poidsMax, produitMax, type_cargaison, lieu_depart, lieu_arrivee, mode_remplissage } = formData;

    console.log(formData);

    let newCargo: Cargaison;
    // Vérification et conversion des champs numériques
    const distanceKm = parseInt(distance);
    const poidsMaximum = poidsMax ? parseInt(poidsMax) : null;
    const produitMaximum = produitMax ? parseInt(produitMax) : null;

    // Vérification des champs
    if (isNaN(distanceKm) || !dateDepart || !dateArrivee || !type_cargaison) {
        alert("Les données du formulaire sont invalides.");
        return;
    }

    // Création d'une nouvelle cargaison selon le type sélectionné
    switch (type_cargaison) {
        case "maritime":
            newCargo = new CargaisonMaritime(distanceKm, dateDepart, dateArrivee, poidsMaximum, produitMaximum, lieu_arrivee, lieu_depart, mode_remplissage);
            break;
        case "aerienne":
            newCargo = new CargaisonAerienne(distanceKm, dateDepart, dateArrivee, poidsMaximum, produitMaximum, lieu_arrivee, lieu_depart, mode_remplissage);
            break;
        case "routiere":
            newCargo = new CargaisonRoutiere(distanceKm, dateDepart, dateArrivee, poidsMaximum, produitMaximum, lieu_arrivee, lieu_depart, mode_remplissage);
            break;
        default:
            alert("Type de cargaison invalide.");
            return;
    }

    // Save new cargo to server
    saveNewCargoToServer(newCargo).then(() => {
        alert("Cargaison ajoutée avec succès.");
        // Refresh cargo list
        fetchCargos();
    }).catch((error) => {
        alert(`Erreur lors de l'ajout de la cargaison : ${error.message}`);
    });
}

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
new Formulaire("cargaisonForm", formFields, submitNewCargo);


document.getElementById('applyFilters')?.addEventListener('click', applyFilters);

fetchCargos();

// document.addEventListener('DOMContentLoaded', () => {
   
//     // Récupérer les données dès le chargement de la page
//     fetchCargos();
// });