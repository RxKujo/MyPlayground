<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../includes/config/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    echo "ID captcha manquant ou invalide.";
    exit();
}

try {
    
    $stmt = $pdo->prepare('DELETE FROM captcha_reponse WHERE id_captcha = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    
    $stmt = $pdo->prepare('DELETE FROM captcha WHERE id_captcha = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    exit();
}

header("Location: ../pages/admin/captchas.php");
exit();