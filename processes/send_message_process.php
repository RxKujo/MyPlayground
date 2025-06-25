<?php
include_once '../includes/global/session.php';
include_once '../includes/global/pdo.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$id_envoyeur = $_SESSION['user_id'];
$id_groupe = $_POST['id_groupe'] ?? null;
$message = trim($_POST['message'] ?? '');

if (!$id_groupe || $message === '') {
    header('Location: ../messages');
    exit();
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO echanger (id_envoyeur, id_groupe, message, date_envoi)
        VALUES (:id_envoyeur, :id_groupe, :message, NOW())
    ");
    $stmt->execute([
        ':id_envoyeur' => $id_envoyeur,
        ':id_groupe' => $id_groupe,
        ':message' => $message
    ]);

    header("Location: ../messages?id_groupe=" . $id_groupe);
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de l'envoi du message : " . $e->getMessage();
    header('Location: ../messages');
    exit();
}
