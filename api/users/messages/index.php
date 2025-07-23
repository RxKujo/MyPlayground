<?php

include_once '../../../includes/global/session.php';

header("Content-Type: application/json");

$id_requester = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $content = trim($input['content'] ?? '');
    $groupId = (int)($input['groupId'] ?? 0);

    if (!$content || !$groupId || !$id_requester) {
        http_response_code(400);
        echo json_encode(['error' => 'Contenu ou groupe manquant']);
        exit();
    }

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO echanger 
                (id_envoyeur, id_groupe, message, date_envoi)
             VALUES (:id_envoyeur, :id_groupe, :message, NOW())"
        );
    
        $stmt->bindParam(":id_envoyeur", $id_requester);
        $stmt->bindParam(":id_groupe", $groupId);
        $stmt->bindParam(":message", $content);
    
        $stmt->execute();

        $r = $pdo->query("SELECT id_message FROM echanger WHERE id_groupe = $groupId ORDER BY date_envoi DESC LIMIT 1");
        $id_dernier_message = $r->fetch(PDO::FETCH_COLUMN);

        $stmt = $pdo->prepare("UPDATE groupe_discussion SET id_dernier_message = $id_dernier_message WHERE id = :id");
        $stmt->execute([
            ":id" => $groupId
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['error' => $e]);
        exit();
    }

    echo json_encode(['success' => true]);
    exit();

} else if ($method === 'PATCH') {
    $input = json_decode(file_get_contents('php://input'), true);
    $content = trim($input['content'] ?? '');
    $groupId = (int)($input['groupId'] ?? 0);
    $senderId = (int)($input['senderId'] ?? 0);

    if ($senderId === -99) {

    }
    $messages = getMessagesByGroup($pdo, $id_groupe);
    echo json_encode([
        "waiter" => $id_requester,
        "messages" => $messages
    ]);

    exit();
} else if ($method === 'GET') {
    $id_groupe = filter_input(INPUT_GET, 'id_groupe', FILTER_VALIDATE_INT);

    if (!$id_groupe) {
        http_response_code(400);
        
        echo json_encode(['error' => 'ID du groupe manquant']);

        exit();
    }

    $messages = getMessagesByGroup($pdo, $id_groupe);
    echo json_encode([
        "waiter" => $id_requester,
        "messages" => $messages
    ]);
    exit();

}
?>