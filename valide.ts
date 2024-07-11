

import { ICargaison, EtatAvancement, EtatGlobale, EtatProduit,  ClientData,  ProduitData} from "./src/types/interface";




function isValidAdvancementTransition(current: EtatAvancement, next: EtatAvancement,etatGlobale:EtatGlobale ): boolean {
    const validTransitions: Record<EtatAvancement, EtatAvancement[]> = {
        'en attente': ['en cours'],
        'en cours': ['arriver', 'perdu'],
        'arriver': [],
        'perdu': []
         
    };
    if (etatGlobale === 'ouvert' && next === 'en cours') {
        return false; // Une cargaison ouverte ne peut pas passer à "en cours"
    }
    return validTransitions[current].includes(next);
}
function getEtatOptions(currentEtat: EtatProduit, etatCargaison: EtatAvancement): string {
    let etats: EtatProduit[] = [];
    switch (etatCargaison) {
        case 'en attente':
            etats = ['en attente'];
            break;
        case 'en cours':
            etats = ['en cours'];
            break;
        case 'arriver':
            etats = ['arriver', 'perdu', 'recuperer', 'archiver'];
            break;
        case 'perdu':
            etats = ['perdu'];
            break;
    }
    return etats.map(etat => 
        `<option value="${etat}" ${etat === currentEtat ? 'selected' : ''}>${etat}</option>`
    ).join('');
}
async function updateCargaisonState(id: number, newState: Partial<ICargaison>): Promise<void> {
    const cargo = filteredCargos.find(c => c.id === id);
    if (!cargo) return;

    const currentAdvancement: EtatAvancement = cargo.etat_Avancement;
    const currentState: EtatGlobale = cargo.etat_globale;

    if (newState.etat_Avancement && !isValidAdvancementTransition(currentAdvancement, newState.etat_Avancement)) {
        alert('Transition d\'état d\'avancement invalide');
        return;
    }

    Object.assign(cargo, newState);

    if (newState.etat_Avancement) {
        cargo.produits.forEach(produit => {
            produit.etat = newState.etat_Avancement as EtatProduit;
        });
    }

    try {
        const response = await updateState(cargo);
        if (response) {
            displayCargos();
        }
    } catch (error) {
        console.error('Error updating cargo state:', error);
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const cargoNumberInput = document.getElementById('cargoNumber') as HTMLInputElement;
    const stateRadios = document.querySelectorAll('input[name="state"]') as NodeListOf<HTMLInputElement>;

    cargoNumberInput.addEventListener('input', () => {
        const cargoNumber = cargoNumberInput.value;
        const cargo = filteredCargos.find(c => c.numero.toString() === cargoNumber);

        if (!cargo) {
            stateRadios.forEach(radio => radio.disabled = true);
            return;
        }

        const currentAdvancement = cargo.etat_Avancement;

        stateRadios.forEach(radio => {
            const radioValue = radio.getAttribute('value') as EtatAvancement;
            radio.disabled = !isValidAdvancementTransition(currentAdvancement, radioValue);
        });
    });

    const produitList = document.getElementById('produitList') as HTMLElement;

    cargaison.produits.forEach(produit => {
        const row = document.createElement('tr');
        const etatOptions = getEtatOptions(produit.etat, cargaison.etat_Avancement);
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">${produit.libelle}</td>
            <td class="px-6 py-4 whitespace-nowrap">${produit instanceof Alimentaire ? 'Alimentaire' : produit instanceof Chimique ? 'Chimique' : (produit as Materiel).typeMateriel}</td>
            <td class="px-6 py-4 whitespace-nowrap">${produit.poids} kg</td>
            <td class="px-6 py-4 whitespace-nowrap">${cargaison.calculerFrais(produit) / produit.poids} f cfa</td>
            <td class="px-6 py-4 whitespace-nowrap">${cargaison.calculerFrais(produit)} f cfa</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <select class="etat-select" data-id="${produit.id}" ${cargaison.etat_Avancement !== 'arriver' ? 'disabled' : ''}>
                    ${etatOptions}
                </select>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded supPro" data-id="${produit.id}">Supprimer</button>
            </td>
        `;
        produitList.appendChild(row);
    });

    document.querySelectorAll('.etat-select').forEach(select => {
        select.addEventListener('change', async (event) => {
            const target = event.target as HTMLSelectElement;
            const produitId = parseInt(target.dataset.id!);
            const newEtat = target.value as EtatProduit;

            const produit = cargaison.produits.find(p => p.id === produitId);
            if (!produit) return;

            const updatedProduit: Partial<Produit> = { id: produit.id, etat: newEtat };

            try {
                const response = await updateState(updatedProduit);
                if (response) {
                    console.log(response.message);
                }
            } catch (error) {
                console.error('Error updating product state:', error);
            }
        });
    });
});
