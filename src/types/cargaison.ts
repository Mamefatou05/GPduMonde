import { Produit, Alimentaire, Chimique, Materiel } from '../produit';
import { displayCargos } from '../cargaisons';

export interface ICargaison {
    id: number;
    numero: string;
    poidsMax: number | null;
    produitMax: number | null;
    prix_total: number;
    lieu_depart: string;
    lieu_arrivee: string;
    produits: Produit[];
    dateDepart: Date;
    dateArrivee: Date;
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

export abstract class Cargaison implements ICargaison {
    static dernierNumero: number = 0; // Attribut statique pour suivre le dernier numéro attribué

    id: number;
    numero: string;
    poidsMax: number | null;
    produitMax: number | null;
    prix_total: number;
    lieu_depart: string;
    lieu_arrivee: string;
    produits: Produit[];
    dateDepart: Date;
    dateArrivee: Date;
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
        lieu_arrivee:string,
        mode_remplissage: string,

    ) {
        this.dateDepart = new Date(dateDepart);
        this.dateArrivee = new Date(dateArrivee);
        this.poidsMax = poidsMax;
        this.produitMax = produitMax;
        this.id = Cargaison.length + 1;
        this.numero = Cargaison.genererNumero();
        this.etat_Avancement = "En attente";
        this.etat_globale = "ouvert";
        this.prix_total = 0; // Initialize prix_total to 0
        this.lieu_depart = lieu_depart;
        this.lieu_arrivee = lieu_arrivee;
        this.mode_remplissage = mode_remplissage;
        this.produits = []; // Initialize produits to an empty array
        this.distanceKm = distance;
        this.type = type;
    }

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
   // Méthode statique pour générer le prochain numéro de cargaison
   private static genererNumero(): string {
    const prochainNumero = Cargaison.dernierNumero + 1;
    Cargaison.dernierNumero = prochainNumero;
    return `CRG${prochainNumero.toString().padStart(3, '0')}`;
}

    abstract calculerFrais(produit: Produit): number;

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
