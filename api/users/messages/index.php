<?php

include_once '../../../includes/global/session.php';

header("Content-Type: application/json");

$id_requester = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $contenu = trim($input['contenu'] ?? '');
    $id_groupe = (int)($input['id_groupe'] ?? 0);

    if (!$contenu || !$id_groupe || !$id_requester) {
        http_response_code(400);
        echo json_encode(['error' => 'Contenu ou groupe manquant']);
        exit();
    }

    $stmt = $pdo->prepare(
        "INSERT INTO echanger 
            (id_utilisateur, id_groupe, message, date_envoi)
         VALUES (:id_utilisateur, :id_groupe, :message, NOW())");
         
    $stmt->execute([
        ":id_utilisateur" => $id_requester,
        ":id_groupe" => $id_groupe,
        ":message" =>$contenu
    ]);

    echo json_encode(['success' => true]);
    exit();
} else if ($method === 'GET') {
    $id_groupe = filter_input(INPUT_GET, 'id_groupe', FILTER_VALIDATE_INT);
    if (!$id_groupe) {
        http_response_code(400);
        echo json_encode(['error' => 'ID du groupe manquant']);
        exit();
    }

    $messages = getMessagesByGroup($pdo, $id_groupe);
    echo json_encode($messages);
    exit();
}


?>