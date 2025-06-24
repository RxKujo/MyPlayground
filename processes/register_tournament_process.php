<?php


session_start();
include_once __DIR__ . '/../includes/global/session.php';
include_once __DIR__ . '/../includes/config/config.php';
notLogguedSecurity("/MyPlayground/index.php"); 

$id_equipe = $_POST['id_equipe'] ?? null;
$id_tournoi = $_POST['id_tournoi'] ?? null;

if (empty($id_equipe) || empty($id_tournoi)) {
    $_SESSION['error'] = "Veuillez sélectionner une équipe et un tournoi.";
    header("Location: /MyPlayground/pages/public/register_tournament.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inscription_tournoi WHERE id_equipe = ? AND id_tournoi = ?");
    $stmt->execute([$id_equipe, $id_tournoi]);
    $alreadyRegistered = $stmt->fetchColumn();

    if ($alreadyRegistered > 0) {
        $_SESSION['error'] = "Cette équipe est déjà inscrite à ce tournoi.";
        header("Location: /MyPlayground/pages/public/register_tournament.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO inscription_tournoi (id_equipe, id_tournoi, statut) VALUES (?, ?, 'en attente')");
    $stmt->execute([$id_equipe, $id_tournoi]);

    $_SESSION['success'] = "L'équipe a été inscrite au tournoi avec succès !";
} catch (PDOException $e) {
    $_SESSION['error'] = "Une erreur est survenue lors de l'inscription : " . $e->getMessage();
}

header("Location: /MyPlayground/pages/public/register_tournament.php");
exit;
