<?php

include_once '../../../../includes/global/session.php';

notLogguedSecurity("/");


header("Content-Type: application/json");


$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $users = getAllUsers($pdo);

    if (!$users) {
        echo json_encode(["error" => "Pas de users ou mauvaise réponse", "reponse" => $users]);
        exit();
    }

    echo json_encode([
        "waiter" => $_SESSION['user_info']['id'],
        "users" => $users
    ]);
}

exit();

?>
