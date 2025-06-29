<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../../../index.php");


header("Content-Type: application/json");


$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $matches = getAllMatches($pdo);
    
    if (!$matches) {
        echo json_encode(["error" => "Pas de matchs ou mauvaise réponse", "reponse" => $matches]);
        exit();
    }

    echo json_encode([
        "waiter" => $_SESSION['user_info']['id'],
        "matches" => $matches
    ]);
}

exit();

?>
