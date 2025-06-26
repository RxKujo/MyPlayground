<?php
include_once '../includes/global/session.php';
notLogguedSecurity("../index.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_equipe'])) {
    header("Location: ../matches?error=Requête invalide");
    exit();
}



$userId = $_SESSION['user_info']['id'];
$idEquipe = (int)$_POST['id_equipe'];

try {
    $stmt = $pdo->prepare("DELETE FROM appartenir WHERE id = ? AND id_equipe = ?");
    $stmt->execute([$userId, $idEquipe]);
    header("Location: ../matches?success=Vous avez quitté l'équipe.");
    exit();
} catch (PDOException $e) {
    header("Location: ..//matches?error=Erreur lors de la suppression");
    exit();
}
