<?php

include_once '../../includes/global/session.php';

header("Content-Type: application/json");
$waiter = $_SESSION['user_info']['id'];
$method = $_SERVER['REQUEST_METHOD'];

$captchas = getAllCaptchas($pdo);

if (!$users) {
    echo json_encode(["error" => "Pas de users ou mauvaise réponse", "reponse" => $captchas]);
    exit();
}


echo json_encode([
    "waiter" => $_SESSION['user_info']['id'],
    "captchas" => $captchas
]);
