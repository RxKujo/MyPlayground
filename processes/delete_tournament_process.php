<?php
session_start();
require_once '../includes/config/config.php';

$id_tournoi = $_POST['id_tournoi'] ?? null;

if (!$id_tournoi) {
    $_SESSION['modif_success'] = "Aucun tournoi sélectionné pour la suppression.";
    header("Location: ../pages/admin/tournaments.php");
    exit;
}

try {
    // Supprimer d'abord les dépendances si besoin (ex: inscriptions, matchs)
    $pdo->prepare("DELETE FROM inscription_tournoi WHERE id_tournoi = ?")->execute([$id_tournoi]);
    $pdo->prepare("DELETE FROM match WHERE id_tournoi = ?")->execute([$id_tournoi]);
    // Puis supprimer le tournoi
    $stmt = $pdo->prepare("DELETE FROM tournoi WHERE id_tournoi = ?");
    $stmt->execute([$id_tournoi]);
    $_SESSION['modif_success'] = "Tournoi supprimé avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur lors de la suppression : " . $e->getMessage();
}
header("Location: ../pages/admin/tournaments.php");
exit;