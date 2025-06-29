<?php

include_once '../../../includes/global/session.php';

header("Content-Type: application/json");

$id_requester = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = trim($input['name'] ?? "");
    $guests = $input['guests'] ?? [];

    if ($name === "" || !is_array($guests)) {
        echo json_encode(["success" => false, "error" => "Données invalides"]);
        exit();
    }

    $groupId = createGroup($pdo, $name, $id_requester);

    foreach ($guests as $guest) {
        $guest = trim($guest);
        addToGroup($pdo, $groupId, getUserIdFromUsername($pdo, $guest));
    }

    echo json_encode(["success" => true]);

} else if ($method === "GET") {

}


exit();
?>