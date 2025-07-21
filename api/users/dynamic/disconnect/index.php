<?php

include_once '../../../../includes/global/session.php';

notLogguedSecurity("/");


header("Content-Type: application/json");

$waiter = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST") {

    $r = $pdo->query("UPDATE utilisateur SET is_online = 0 WHERE id = $waiter");
    
    echo json_encode([
        "waiter" => $waiter,
        "response" => $r ? "ok" : "error"
    ]);
}

exit();

?>
