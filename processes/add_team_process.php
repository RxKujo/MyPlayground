<?php
// filepath: c:\xampp\htdocs\MyPlayground\processes\add_team_process.php
session_start();
require_once '../includes/config/config.php';

$nom = trim($_POST['nom'] ?? '');
$privee = isset($_POST['privee']) ? (int)$_POST['privee'] : 0;
$code = trim($_POST['code'] ?? '');

if ($nom === '') {
    $_SESSION['modif_success'] = "Le nom de l'équipe est obligatoire.";
    header("Location: ../pages/admin/teams.php");
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO equipe (nom, privee, code) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $privee, $privee ? $code : null]);
    $_SESSION['modif_success'] = "Équipe ajoutée avec succès.";
} catch (PDOException $e) {
    $_SESSION['modif_success'] = "Erreur lors de l'ajout : " . $e->getMessage();
}
header("Location: ../pages/admin/teams.php");
exit;