<?php
include_once '../includes/global/session.php';
include_once '../includes/config.php';

if (!isset($_GET['groupe_id'])) {
    http_response_code(400);
    exit();
}

$idGroupe = intval($_GET['groupe_id']);

$stmt = $pdo->prepare("
    SELECT e.message, e.date_envoi, u.pseudo
    FROM echanger e
    JOIN utilisateur u ON u.id = e.id_envoyeur
    WHERE e.id_groupe = ?
    ORDER BY e.date_envoi ASC
");
$stmt->execute([$idGroupe]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($messages);
