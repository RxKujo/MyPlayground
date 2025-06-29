<?php

include_once '../../includes/global/session.php';

header("Content-Type: application/json");

$id_requester = $_SESSION['user_info']['id'];

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {

} else if ($method === "GET") {
    $teams = getAllTeams($pdo);
    echo json_encode([
        'success' => true,
        'id_requester' => $id_requester,
        'teams' => $teams
    ]);

}

exit();
?>