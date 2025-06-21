<?php
// filepath: c:\xampp\htdocs\MyPlayground\processes\edit_team_process.php
session_start();
require_once '../includes/config/config.php';

$id_equipe = $_POST['id_equipe'] ?? null;
$nom = trim($_POST['nom'] ?? '');
$privee = isset($_POST['privee']) ? (int)$_POST['privee'] : 0;
$code = trim($_POST['code'] ?? '');

if (!$id_equipe || $nom === '') {
    $_SESSION['modif_success'] = "Données manquantes pour la modification.";
    header("Location: ../pages/admin/teams.php");
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE equipe SET nom = ?, privee = ?, code = ? WHERE id_equipe = ?");
    $stmt->execute([$nom, $privee, $privee ? $code : null, $id_equipe]);
    $_SESSION['modif_success'] = "Équipe modifiée avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur lors de la modification : " . $e->getMessage();
}
header("Location: ../pages/admin/teams.php");
exit;