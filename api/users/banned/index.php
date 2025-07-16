<?php

include_once '../../../includes/global/session.php';

notLogguedSecurity("/index.php");

if (!isAdmin($_SESSION['user_info'])) {
    header("location: /pages/errors/401.html");   
    exit();
}

header("Content-Type: application/json");

$waiter = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {

    $r = $pdo->query(
        "SELECT DISTINCT * FROM (
            SELECT u.*, b.raison, b.date_debut, b.date_fin 
            FROM utilisateur AS u
            JOIN bannissement AS b
            ON u.id = b.utilisateur_id 
            WHERE u.is_banned = 1)
        AS sub
        ORDER BY date_debut DESC LIMIT 1");
    
    $r = $r->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "waiter" => $waiter,
        "users" => $r
    ]);
}

exit();

?>
