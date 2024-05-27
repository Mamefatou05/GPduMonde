<?php

header('Content-Type: application/json');
$data = json_decode(file_get_contents('data.json'), true);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$cargaisonId = isset($_GET['id']) ? $_GET['id'] : null;
$productAction = isset($_GET['products']);

/**
 * Recherche une cargaison par ID.
 * @param array $data Données de toutes les cargaisons.
 * @param string $cargaisonId ID de la cargaison à rechercher.
 * @return array|null Retourne la cargaison si trouvée, sinon null.
 */
function findCargaison(&$data, $cargaisonId) {
    foreach ($data['cargaisons'] as &$cargaison) {
        if ($cargaison['id'] == $cargaisonId) {
            return $cargaison;
        }
    }
    return null;
}

/**
 * Sauvegarde les données dans le fichier JSON.
 * @param array $data Données à sauvegarder.
 */
function saveData($data) {
    if (file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT)) === false) {
        http_response_code(500);
        echo json_encode(array("message" => "Erreur lors de la sauvegarde des données"));
        exit();
    }
}

/**
 * Mise à jour de l'état d'un produit.
 * @param array $products Liste des produits de la cargaison.
 * @param string $productId ID du produit à mettre à jour.
 * @param string $newState Nouvel état du produit.
 * @return bool Retourne true si le produit est trouvé et mis à jour, sinon false.
 */

// Gestion des requêtes GET
if ($requestMethod === 'GET') {
    if ($cargaisonId) {
        $cargaison = findCargaison($data, $cargaisonId);
        if ($cargaison) {
            if ($productAction) {
                echo json_encode($cargaison['products']);
            } else {
                echo json_encode($cargaison);
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Cargaison non trouvée"));
        }
    } else {
        echo json_encode($data);
    }
}


// Gestion des requêtes POST
if ($requestMethod === 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);
    if ($cargaisonId && $productAction) {
        foreach ($data['cargaisons'] as &$cargaison) {
            if ($cargaison['id'] == $cargaisonId) {
                if ($cargaison['state'] === 'fermé') {
                    http_response_code(403); // Forbidden
                    echo json_encode(array("message" => "La cargaison est fermée et ne peut pas recevoir de produit"));
                    return;
                }
                $cargaison['products'][] = $inputData;
                saveData($data);
                http_response_code(201);
                echo json_encode(array("message" => "Produit ajouté avec succès à la cargaison"));
                return;
            }
        }
        http_response_code(404);
        echo json_encode(array("message" => "Cargaison non trouvée"));
    } else {
        $data['cargaisons'][] = $inputData;
        saveData($data);
        http_response_code(201);
        echo json_encode(array("message" => "Cargaison ajoutée avec succès"));
    }
}
