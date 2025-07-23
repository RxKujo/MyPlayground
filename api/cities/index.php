<?php
include_once '../../includes/config/variables.php';
include_once $includesConfig . 'functions.php';
include_once $includesConfig . 'config.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $q = $_GET['q'] ?? '';
    if (strlen($q) < 2) {
        echo json_encode(['cities' => []]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, ville, code_postal FROM villes_cp WHERE ville LIKE ? ORDER BY ville ASC LIMIT 10");
    $stmt->execute([$q . '%']);
    echo json_encode(['cities' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
}

exit();
?>