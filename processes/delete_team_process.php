<?php
// filepath: c:\xampp\htdocs\MyPlayground\processes\delete_team_process.php
session_start();
require_once '../includes/config/config.php';

$id_equipe = $_POST['id_equipe'] ?? null;

if (!$id_equipe) {
    $_SESSION['modif_success'] = "Aucune équipe sélectionnée pour la suppression.";
    header("Location: ../pages/admin/teams.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM equipe WHERE id_equipe = ?");
    $stmt->execute([$id_equipe]);
    $_SESSION['modif_success'] = "Équipe supprimée avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur lors de la suppression : " . $e->getMessage();
}
header("Location: ../pages/admin/teams.php");
exit;