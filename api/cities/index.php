<?php
include_once '../../includes/config/variables.php';
include_once $includesConfig . 'functions.php';
include_once $includesConfig . 'config.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $q = $_GET['q'] ?? '';
    if (strlen($q) < 2) {
        echo json_encode(['cities' => []]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, nom, code_postal FROM ville WHERE nom LIKE ? ORDER BY nom ASC LIMIT 10");
    $stmt->execute([$q . '%']);

    echo json_encode(['cities' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    exit;
}
?>
