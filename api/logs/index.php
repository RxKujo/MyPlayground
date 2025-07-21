<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("/");

if (!isAdmin($_SESSION['user_info'])) {
    header("location: /pages/errors/401.html");   
    exit();
}

header("Content-Type: application/json");
$waiter = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    
    $logs = getAllLogs($pdo);

    if (!$logs) {
        echo json_encode(["error" => "Pas de logs ou mauvaise réponse", "reponse" => $captchas]);
        exit();
    }


    echo json_encode([
        "waiter" => $waiter,
        "logs" => $logs
    ]);
}

exit();

?>