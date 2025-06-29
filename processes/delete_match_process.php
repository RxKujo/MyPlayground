<?php

include_once '../includes/global/session.php';
notLogguedSecurity("../index.php");

$idMatch = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$user = $_SESSION['user_info'];
$isAdmin = isAdmin($user);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id_equipe1, id_equipe2, id_createur FROM `match` WHERE id_match = ?");
    $stmt->execute([$idMatch]);
    $match = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$match) {
        throw new Exception("Match introuvable.");
    }

    if ($match['id_createur'] != $user['id'] && !isAdmin($user)) {
        throw new Exception("Non autorisé à supprimer ce match.");
    }

    $idEquipe1 = $match['id_equipe1'];
    $idEquipe2 = $match['id_equipe2'];

    $pdo->prepare("DELETE FROM reserver WHERE id_match = ?")->execute([$idMatch]);
    $pdo->prepare("DELETE FROM participer_match WHERE id_match = ?")->execute([$idMatch]);
    $pdo->prepare("DELETE FROM arbitrer WHERE id_match = ?")->execute([$idMatch]);
    $pdo->prepare("DELETE FROM inclure WHERE id_match = ?")->execute([$idMatch]);

    $pdo->prepare("DELETE FROM `match` WHERE id_match = ?")->execute([$idMatch]);

    $pdo->prepare("DELETE FROM appartenir WHERE id_equipe = ?")->execute([$idEquipe1]);
    $pdo->prepare("DELETE FROM appartenir WHERE id_equipe = ?")->execute([$idEquipe2]);

    $pdo->prepare("DELETE FROM equipe WHERE id_equipe = ?")->execute([$idEquipe1]);
    $pdo->prepare("DELETE FROM equipe WHERE id_equipe = ?")->execute([$idEquipe2]);

    $pdo->commit();

    if ($isAdmin && $_SERVER['HTTP_REFERER'] === $_SERVER['HTTP_HOST'] . "/admin/matches") {
        header("Location: ../admin/matches");
    } else {
        header("Location: ../matches?success=1");
    }
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    header("Location: ../matches?error=" . urlencode($e->getMessage()));
    exit();
}
