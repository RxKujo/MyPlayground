<?php

include_once '../../includes/global/session.php';

header("Content-Type: application/json");

$id_requester = $_SESSION['user_info']['id'];

$method = $_SERVER['REQUEST_METHOD'];

if (is_null($id_requester)) {
    echo json_encode([
        'success' => false,
        'error' => "Vous devez vous connecter pour voir les informations"
    ]);
}

if ($method === "POST") {

} else if ($method === "GET") {
    $tournaments = getAllTourneys($pdo);
    echo json_encode([
        'success' => true,
        'id_requester' => $id_requester,
        'tournaments' => $tournaments
    ]);

}

exit();
?>