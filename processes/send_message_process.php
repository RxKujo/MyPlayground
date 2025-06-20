<?php
session_start();
include_once '../includes/config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$id_utilisateur = $_SESSION['user_id'];
$id_groupe = $_POST['id_groupe'] ?? null;
$contenu = trim($_POST['message'] ?? '');

if (!$id_groupe || $contenu === '') {
    header('Location: ../messages.php');
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO echanger (id_utilisateur, id_groupe, contenu, date_envoi) VALUES (:id_utilisateur, :id_groupe, :contenu, NOW())");
    $stmt->execute([
        ':id_utilisateur' => $id_utilisateur,
        ':id_groupe' => $id_groupe,
        ':contenu' => $contenu
    ]);

    header("Location: ../messages.php?id_groupe=" . $id_groupe);
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de l'envoi du message : " . $e->getMessage();
    header('Location: ../messages.php');
    exit();
}
