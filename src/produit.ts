// Produit.ts
export class Produit {
    constructor(public libelle: string, public poids: number) {}
}

export class Alimentaire extends Produit {}

export class Chimique extends Produit {
    constructor(libelle: string, poids: number, public toxicite: number) {
        super(libelle, poids);
    }
}

export class Materiel extends Produit {
    constructor(libelle: string, poids: number, public typeMateriel: string) {
        super(libelle, poids);
    }
}
