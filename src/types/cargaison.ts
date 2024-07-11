import { Produit, Alimentaire, Chimique, Materiel } from '../produit';

export interface ICargaison {
    id: number;
    numero: string;
    poidsMax: number | null;
    produitMax: number | null;
    prix_total: number;
    lieu_depart: string;
    lieu_arrivee: string;
    produits: Produit[];
    dateDepart: string;
    dateArrivee: string;
    mode_remplissage: string;
    etat_Avancement: string;
    etat_globale: string;
    type: string;
    distanceKm: number;

    ajouterProduit(produit: Produit): void;
    calculerFrais(produit: Produit): number;
    sommeTotale(): number;
    sommePoids(): number;
    nbProduits(): number;
}


export const formatDate = (date: Date) => {
    const day = String(date.getUTCDate()).padStart(2, '0');
    const month = String(date.getUTCMonth() + 1).padStart(2, '0'); // Months are 0-based
    const year = date.getUTCFullYear();
    return `${day}/${month}/${year}`;
}


export abstract class Cargaison implements ICargaison {
    private static dernierId: number = 0; // Static attribute to track the last assigned number

    id: number;
    numero: string;
    poidsMax: number | null;
    produitMax: number | null;
    prix_total: number;
    lieu_depart: string;
    lieu_arrivee: string;
    produits: Produit[];
    dateDepart: string;
    dateArrivee: string;
    mode_remplissage: string;
    etat_Avancement: string;
    etat_globale: string;
    type: string;
    distanceKm: number;

    constructor(
        distance: number,
        dateDepart: string,
        dateArrivee: string,
        poidsMax: number | null,
        produitMax: number | null,
        type: string,
        lieu_depart: string,
        lieu_arrivee: string,
        mode_remplissage: string,
    ) {
        // this.id = ++Cargaison.dernierId; // Increment last number and assign to id
        this.id = ++Cargaison.dernierId;
        this.numero = Cargaison.genererNumero(this.id);
        this.poidsMax = poidsMax;
        this.produitMax = produitMax;
        this.prix_total = 0; // Initialize prix_total to 0
        this.lieu_depart = lieu_depart;
        this.lieu_arrivee = lieu_arrivee;
        this.produits = []; // Initialize produits to an empty array
        this.dateDepart = formatDate(new Date(dateDepart));
        this.dateArrivee = formatDate(new Date(dateArrivee));
        this.mode_remplissage = mode_remplissage;
        this.etat_Avancement = "En attente";
        this.etat_globale = "ouvert";
        this.type = type;
        this.distanceKm = distance;
    }

    static genererIdUnique(): number {
        return Date.now();
    }
    
    // private static genrerId(): number {
    //     return Math.floor(Math.random() * 10);
    // }
    static genererNumero(id: number): string {
        return `CRG${id.toString().padStart(3, '0')}`;
    }


    abstract calculerFrais(produit: Produit): number;

    ajouterProduit(produit: Produit): void {
        if (this.produitMax && this.produits.length >= this.produitMax) {
            alert("La cargaison est pleine.");
            return;
        }

        if (this.poidsMax && this.sommePoids() + produit.poids > this.poidsMax) {
            alert("Le poids maximum de la cargaison est atteint.");
            return;
        }

        if (produit instanceof Chimique && !(this instanceof CargaisonMaritime)) {
            alert("Les produits chimiques doivent toujours transiter par voie maritime.");
            return;
        }

        if (produit instanceof Materiel && produit.typeMateriel === "fragile" && this instanceof CargaisonMaritime) {
            alert("Les produits fragiles ne doivent jamais passer par voie maritime.");
            return;
        }

        this.produits.push(produit);
        console.log(`Produit ajouté: ${produit.libelle}`);
        console.log(`Montant actuel de la cargaison: ${this.sommeTotale()}`);
    }

    sommeTotale(): number {
        return this.produits.reduce((total, produit) => total + this.calculerFrais(produit), 0);
    }

    sommePoids(): number {
        return this.produits.reduce((total, produit) => total + produit.poids, 0);
    }

    nbProduits(): number {
        return this.produits.length;
    }
}

export class CargaisonMaritime extends Cargaison {
    constructor(
        distance: number,
        dateDepart: string,
        dateArrivee: string,
        poidsMax: number | null,
        produitMax: number | null,
        lieu_depart: string,
        lieu_arrivee: string,
        mode_remplissage: string,
    ) {
        super(distance, dateDepart, dateArrivee, poidsMax, produitMax, "maritime", lieu_depart, lieu_arrivee, mode_remplissage);
    }

    calculerFrais(produit: Produit): number {
        return produit.poids * this.distanceKm * 90;
    }
}

export class CargaisonAerienne extends Cargaison {
    constructor(
        distance: number,
        dateDepart: string,
        dateArrivee: string,
        poidsMax: number | null,
        produitMax: number | null,
        lieu_depart: string,
        lieu_arrivee: string,
        mode_remplissage: string,
    ) {
        super(distance, dateDepart, dateArrivee, poidsMax, produitMax, "aerienne", lieu_depart, lieu_arrivee, mode_remplissage);
    }

    calculerFrais(produit: Produit): number {
        return produit.poids * this.distanceKm * 100;
    }
}

export class CargaisonRoutiere extends Cargaison {
    constructor(
        distance: number,
        dateDepart: string,
        dateArrivee: string,
        poidsMax: number | null,
        produitMax: number | null,
        lieu_depart: string,
        lieu_arrivee: string,
        mode_remplissage: string,
    ) {
        super(distance, dateDepart, dateArrivee, poidsMax, produitMax, "routiere", lieu_depart, lieu_arrivee, mode_remplissage);
    }

    calculerFrais(produit: Produit): number {
        return produit.poids * this.distanceKm * 300;
    }
}
