import {ClientData,EtatProduit, ProduitData} from "./interface";


export class Client {
    nom: string;
    prenom: string;
    telephone: string;
    adresse: string;
    email: string;

    constructor(clientData: ClientData) {
        this.nom = clientData.nom;
        this.prenom = clientData.prenom;
        this.telephone = clientData.telephone;
        this.adresse = clientData.adresse;
        this.email = clientData.email;
    }
}

export abstract class Produit implements ProduitData {
    libelle: string;
    poids: number;
    type_produit: string;
    client: Client;
    destinataire: Client;
    code: string;
    etat: EtatProduit;
    id: number;
    static dernierId: number = 0;

    constructor(id:number, libelle: string, poids: number, type_produit: string, clientData: ClientData, destinataireData: ClientData, code: string) {
        this.libelle = libelle;
        this.poids = poids;
        this.type_produit = type_produit;
        this.client = new Client(clientData);
        this.destinataire = new Client(destinataireData);
        this.code = code;
        this.etat = 'en attente';
        this.id = id;


    }
}
export class Alimentaire extends Produit {
    id: number;
    constructor(id:number,libelle: string, poids: number, client: ClientData, destinataire: ClientData, code: string) {
        super(id, libelle, poids, 'alimentaire', client, destinataire, code);
        this.id = ++Produit.dernierId;
    }
}

export class Chimique extends Produit {

    toxicite: number;
    id: number;

    constructor(id:number,libelle: string, poids: number, client: ClientData, destinataire: ClientData, toxicite: number, code: string) {
        super(id, libelle, poids, 'chimique', client, destinataire, code);
        this.toxicite = toxicite;
        this.id = ++Produit.dernierId;

    }
}

export class Materiel extends Produit {

    typeMateriel: string;
    id: number;

    constructor(id:number,libelle: string, poids: number, client: ClientData, destinataire: ClientData, typeMateriel: string, code: string) {
        super(id, libelle, poids, 'materiel', client, destinataire, code);
        this.typeMateriel = typeMateriel;
        this.id = ++Produit.dernierId;
    }
}

export class ProduitFactory {
    static createProduit(produitData: ProduitData): Produit {

        switch (produitData.type_produit.toLowerCase()) {
            case 'alimentaire':
                return new Alimentaire(produitData.id,produitData.libelle, produitData.poids, produitData.client, produitData.destinataire, produitData.code);
            case 'chimique':
                return new Chimique(produitData.id,produitData.libelle, produitData.poids, produitData.client, produitData.destinataire, (produitData as Chimique).toxicite, produitData.code);
            case 'materiel':
                return new Materiel(produitData.id,produitData.libelle, produitData.poids, produitData.client, produitData.destinataire, (produitData as Materiel).typeMateriel, produitData.code);
            default:
                throw new Error("Invalid produit type");
        }
    }
}
