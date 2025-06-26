<?php
include_once '../includes/global/session.php';
notLogguedSecurity("../index.php");

if (!isset($_POST['id_match'])) {
    header('Location: ../pages/match.php');
    exit();
}

include_once '../includes/config.php';

$idMatch = intval($_POST['id_match']);
$currentUserId = $_SESSION['user_info']['id'];

try {
    $pdo->beginTransaction();

    // Récupérer les infos du match
    $stmt = $pdo->prepare("SELECT id_equipe1, id_equipe2, id_createur FROM `match` WHERE id_match = ?");
    $stmt->execute([$idMatch]);
    $match = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$match) {
        throw new Exception("Match introuvable.");
    }

    if ($match['id_createur'] != $currentUserId) {
        throw new Exception("Non autorisé à supprimer ce match.");
    }

    $idEquipe1 = $match['id_equipe1'];
    $idEquipe2 = $match['id_equipe2'];

    // Supprimer les dépendances du match
    $pdo->prepare("DELETE FROM reserver WHERE id_match = ?")->execute([$idMatch]);
    $pdo->prepare("DELETE FROM participer_match WHERE id_match = ?")->execute([$idMatch]);
    $pdo->prepare("DELETE FROM arbitrer WHERE id_match = ?")->execute([$idMatch]);
    $pdo->prepare("DELETE FROM inclure WHERE id_match = ?")->execute([$idMatch]);

    // Supprimer le match
    $pdo->prepare("DELETE FROM `match` WHERE id_match = ?")->execute([$idMatch]);

    // Supprimer les appartenances aux équipes
    $pdo->prepare("DELETE FROM appartenir WHERE id_equipe = ?")->execute([$idEquipe1]);
    $pdo->prepare("DELETE FROM appartenir WHERE id_equipe = ?")->execute([$idEquipe2]);

    // Supprimer les équipes
    $pdo->prepare("DELETE FROM equipe WHERE id_equipe = ?")->execute([$idEquipe1]);
    $pdo->prepare("DELETE FROM equipe WHERE id_equipe = ?")->execute([$idEquipe2]);

    $pdo->commit();
    header("Location: ../matches?success=1");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    header("Location: ../matches?error=" . urlencode($e->getMessage()));
    exit();
}
