<?php
// filepath: c:\xampp\htdocs\MyPlayground\processes\edit_tournament_process.php
session_start();
require_once '../includes/config/config.php';

$id_tournoi = $_POST['id_tournoi'] ?? null;
$nom = trim($_POST['nom'] ?? '');
$date_tournoi = $_POST['date_tournoi'] ?? '';

if (!$id_tournoi || $nom === '' || $date_tournoi === '') {
    $_SESSION['modif_success'] = "Données manquantes pour la modification.";
    header("Location: ../pages/admin/tournaments.php");
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE tournoi SET nom = ?, date_tournoi = ? WHERE id_tournoi = ?");
    $stmt->execute([$nom, $date_tournoi, $id_tournoi]);
    $_SESSION['modif_success'] = "Tournoi modifié avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur lors de la modification : " . $e->getMessage();
}
header("Location: ../pages/admin/tournaments.php");
exit;