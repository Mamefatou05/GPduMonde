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

// Gestion des requêtes PUT ou PATCH
if ($requestMethod === 'PUT' || $requestMethod === 'PATCH') {
    $updatedCargaison = json_decode(file_get_contents('php://input'), true);
    foreach ($data['cargaisons'] as &$cargaison) {
        if ($cargaison['id'] == $updatedCargaison['id']) {
            // Si la cargaison est fermée, vérifier si elle peut être rouverte
            if ($cargaison['state'] === 'fermé' && $updatedCargaison['state'] === 'ouvert') {
                if ($cargaison['advancement'] === 'EN ATTENTE') {
                    $cargaison['state'] = 'ouvert';
                } else {
                    http_response_code(403); // Forbidden
                    echo json_encode(array("message" => "La cargaison ne peut pas être rouverte"));
                    return;
                }
            } else {
                $cargaison = $updatedCargaison;
            }
            saveData($data);
            http_response_code(200);
            echo json_encode(array("message" => "Cargaison mise à jour avec succès"));
            return;
        }
    }
    http_response_code(404);
    echo json_encode(array("message" => "Cargaison non trouvée"));
}

// Gestion des requêtes DELETE
if ($requestMethod === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteParams);
    if ($cargaisonId && $productAction) {
        $productId = $deleteParams['productId'];
        foreach ($data['cargaisons'] as &$cargaison) {
            if ($cargaison['id'] == $cargaisonId) {
                foreach ($cargaison['products'] as $key => $product) {
                    if ($product['id'] == $productId) {
                        unset($cargaison['products'][$key]);
                        $cargaison['products'] = array_values($cargaison['products']); // Réindexation des clés
                        saveData($data);
                        http_response_code(200);
                        echo json_encode(array("message" => "Produit supprimé avec succès de la cargaison"));
                        return;
                    }
                }
                http_response_code(404);
                echo json_encode(array("message" => "Produit non trouvé dans la cargaison"));
                return;
            }
        }
        http_response_code(404);
        echo json_encode(array("message" => "Cargaison non trouvée"));
    } else {
        foreach ($data['cargaisons'] as $key => $cargaison) {
            if ($cargaison['id'] == $deleteParams['id']) {
                unset($data['cargaisons'][$key]);
                $data['cargaisons'] = array_values($data['cargaisons']); // Réindexation des clés
                saveData($data);
                http_response_code(200);
                echo json_encode(array("message" => "Cargaison supprimée avec succès"));
                return;
            }
        }
        http_response_code(404);
        echo json_encode(array("message" => "Cargaison non trouvée"));
    }
}

function updateProductState(&$products, $productId, $newState) {
    foreach ($products as &$product) {
        if ($product['id'] == $productId) {
            $product['state'] = $newState;
            if ($newState === 'RECUPERE') {
                $product['code'] = null; // Détruire le code du colis
            }
            return true;
        }
    }
    return false;
}


// Gestion des changements d'état pour les produits (colis)
if ($requestMethod === 'PATCH' && $cargaisonId && $productAction) {
    $inputData = json_decode(file_get_contents('php://input'), true);
    $productId = $inputData['productId'];
    $newState = $inputData['state'];

    foreach ($data['cargaisons'] as &$cargaison) {
        if ($cargaison['id'] == $cargaisonId) {
            if (updateProductState($cargaison['products'], $productId, $newState)) {
                saveData($data);
                http_response_code(200);
                echo json_encode(array("message" => "État du produit mis à jour avec succès"));
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Produit non trouvé"));
            }
            return;
        }
    }
    http_response_code(404);
    echo json_encode(array("message" => "Cargaison non trouvée"));
}
?>
