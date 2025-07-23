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
    addToGroup($pdo, $groupId, $id_requester);
    
    foreach ($guests as $guest) {
        $guest = trim($guest);
        addToGroup($pdo, $groupId, getUserIdFromUsername($pdo, $guest));
    }

    echo json_encode(["success" => true]);

} else if ($method === "PUT") {
    $input = json_decode(file_get_contents('php://input'), true);
    $groupId = intval($input['groupId'] ?? 0);
    $name = trim($input['newName'] ?? "");


    if ($name === "" || $groupId <= 0) {
        echo json_encode(["success" => false, "error" => "Données invalides"]);
        exit();
    }

    setGroupName($pdo, $groupId, $name);

    echo json_encode(["success" => true]);
} else if ($method === "DELETE") {
    $input = json_decode(file_get_contents('php://input'), true);
    $groupId = intval($input['groupId'] ?? 0);


    if ($groupId <= 0) {
        echo json_encode(["success" => false, "error" => "Données invalides"]);
        exit();
    }

    deleteGroup($pdo, $groupId);
} else if ($method === "PATCH") {
    $input = json_decode(file_get_contents('php://input'), true);
    $groupId = intval($input['groupId'] ?? 0);


    if ($groupId <= 0) {
        echo json_encode(["success" => false, "error" => "Données invalides"]);
        exit();
    }

    leaveGroup($pdo, $groupId, $id_requester);
}

exit();

?>