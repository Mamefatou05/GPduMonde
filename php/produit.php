

<section id="produit-form" class="p-5">
    <h2>Ajouter un Produit</h2>
    <form id="produitForm">
        <label for="libelle">Libellé</label>
        <input type="text" id="libelle" name="libelle" required>

        <label for="poids">Poids (kg)</label>
        <input type="number" id="poids" name="poids" required>

        <label for="type_produit">Type de Produit</label>
        <select id="type_produit" name="type_produit" required>
            <option value="alimentaire">Alimentaire</option>
            <option value="chimique">Chimique</option>
            <option value="materiel">Matériel</option>
        </select>

        <h3>Informations du Client</h3>
        <label for="client_nom">Nom</label>
        <input type="text" id="client_nom" name="client_nom" required>

        <label for="client_telephone">Téléphone</label>
        <input type="text" id="client_telephone" name="client_telephone" required>

        <label for="client_adresse">Adresse</label>
        <input type="text" id="client_adresse" name="client_adresse" required>

        <h3>Informations du Destinataire</h3>
        <label for="destinataire_nom">Nom</label>
        <input type="text" id="destinataire_nom" name="destinataire_nom" required>

        <label for="destinataire_telephone">Téléphone</label>
        <input type="text" id="destinataire_telephone" name="destinataire_telephone" required>

        <label for="destinataire_adresse">Adresse</label>
        <input type="text" id="destinataire_adresse" name="destinataire_adresse" required>

        <button class="bg-purple-600 p-3" type="submit">Ajouter Produit</button>
    </form>
</section>