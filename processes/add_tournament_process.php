<?php
session_start();
require_once '../includes/config/config.php';

$nom = trim($_POST['nom'] ?? '');
$date_tournoi = $_POST['date_tournoi'] ?? '';

if ($nom === '' || $date_tournoi === '') {
    $_SESSION['modif_success'] = "Tous les champs sont obligatoires.";
    header("Location: ../pages/admin/tournaments.php");
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO tournoi (nom, date_tournoi) VALUES (?, ?)");
    $stmt->execute([$nom, $date_tournoi]);
    $_SESSION['modif_success'] = "Tournoi ajouté avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur lors de l'ajout : " . $e->getMessage();
}
header("Location: ../pages/admin/tournaments.php");
exit;