<?php
include_once '../includes/global/session.php';
include_once '../includes/config/config.php';

$term = trim($_GET['q'] ?? '');

if (strlen($term) < 2) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT id_utilisateur, pseudo FROM utilisateur WHERE pseudo LIKE :term LIMIT 5");
$stmt->execute([':term' => $term . '%']);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
