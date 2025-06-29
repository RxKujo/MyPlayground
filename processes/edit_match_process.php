<?php

session_start();
require_once '../includes/config/config.php';

$id_match = $_POST['id_match'] ?? null;

$terrain = trim($_POST['terrain'] ?? '');
$localisation = trim($_POST['localisation'] ?? '');
$statut = trim($_POST['statut'] ?? '');
$message = trim($_POST['message'] ?? '');
$createur = trim($_POST['createur'] ?? '');

if (!$id_match) {
    $_SESSION['modif_success'] = "ID du match manquant.";
    header("Location: ../admin/matches");
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE `match`
        SET 
            message = :message,
            statut = :statut
        WHERE id_match = :id_match
    ");

    $stmt->execute([
        ':message' => $message,
        ':statut' => $statut,
        ':id_match' => $id_match
    ]);

    $_SESSION['modif_success'] = "Match modifié avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur : " . $e->getMessage();
}

header("Location: ../admin/matches");
exit;
