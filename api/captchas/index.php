<?php

include_once '../../includes/global/session.php';

header("Content-Type: application/json");

$captchas = getAllCaptchas($pdo);

if (!$users) {
    echo json_encode(["error" => "Pas de users ou mauvaise réponse", "reponse" => $captchas]);
    exit();
}


echo json_encode([
    "waiter" => $_SESSION['user_info']['id'],
    "captchas" => $captchas
]);
