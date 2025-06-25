<?php

include_once '../../../includes/global/session.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_info']['id'];
$id_groupe = filter_input(INPUT_GET, 'id_groupe', FILTER_VALIDATE_INT);

if (!$id_groupe) {
    http_response_code(400);
    echo json_encode(['error' => 'ID du groupe manquant']);
    exit();
}

$interlocutors = getAllUsersInDiscussion($pdo, $id_groupe, $userId);


if (is_null($interlocutors) || count($interlocutors) === 0) {
    echo json_encode(['error' => 'Aucun interlocuteur']);
    exit();
}

$names = [];
$pfps = [];
$onlineCount = 0;

foreach ($interlocutors as $user) {
    $pseudo = $user['pseudo'];
    $names[] = $pseudo;
    $pfps[$pseudo] = showPfpOffline($user);

    if (isUserOnline($pdo, $user['id'])) {
        $onlineCount++;
    }
}

$status = "";

if (count($names) === 1) {
    $status = $onlineCount === 1 ? "En ligne" : "Hors ligne";
} elseif ($onlineCount === count($interlocutors)) {
    $status = "Tous en ligne";
} elseif ($onlineCount > 0) {
    $status = "$onlineCount en ligne";
} else {
    $status = "Tous hors ligne";
}

echo json_encode([
    'noms' => $names,
    'pfps' => $pfps,
    'status' => $status
]);
