<?php

include_once '../includes/global/session.php';

notLogguedSecurity("../../index.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Méthode non autorisée.";
    header("Location: ../create_match");
    exit();
}

$nom_match   = $_POST['nom_match'] ?? '';
$localisation = $_POST['localisation'] ?? '';
$date        = $_POST['date'] ?? '';
$heure_debut = $_POST['debut'] ?? '';
$heure_fin   = $_POST['fin'] ?? '';
$categorie   = $_POST['categorie'] ?? '';
$niveau_min  = $_POST['niveau_min'] ?? 0;
$commentaire = $_POST['commentaire'] ?? '';
$createur_id = $_SESSION['user_id'] ?? null;

$joueurs_par_equipe = match ((int)$categorie) {
    0 => 1,
    1 => 2,
    2 => 3,
    3 => 4,
    default => 5
};

if (
    empty($nom_match) || empty($localisation) || empty($date) ||
    empty($heure_debut) || empty($heure_fin) || $categorie === '' || !is_numeric($niveau_min)
) {
    $_SESSION['error'] = "Tous les champs doivent être remplis.";
    header("Location: ../create_match");
    exit();
}

try {
    $stmtTerrain = $pdo->prepare("INSERT INTO terrain (nom, localisation, disponibilite) VALUES (:nom, :localisation, 'disponible')");
    $stmtTerrain->execute([
        ':nom' => $nom_match,
        ':localisation' => $localisation
    ]);
    $idTerrain = $pdo->lastInsertId();

    $stmtEquipe = $pdo->prepare("INSERT INTO equipe (nom, date_creation) VALUES (:nom, CURDATE())");

    $stmtEquipe->execute([':nom' => "Équipe A"]);
    $idEquipe1 = $pdo->lastInsertId();

    $stmtEquipe->execute([':nom' => "Équipe B"]);
    $idEquipe2 = $pdo->lastInsertId();

    $stmtMatch = $pdo->prepare("
        INSERT INTO match (id_equipe1, id_equipe2, statut, message, id_createur)
        VALUES (:id1, :id2, 'en_attente', :message, :id_createur)
    ");
    $stmtMatch->execute([
        ':id1' => $idEquipe1,
        ':id2' => $idEquipe2,
        ':message' => $commentaire,
        'id_createur' => $createur_id
    ]);
    $idMatch = $pdo->lastInsertId();

    $stmtReservation = $pdo->prepare("INSERT INTO reserver (id_terrain, id_match, date_reservation, heure_debut, heure_fin, statut) VALUES (:id_terrain, :id_match, :date, :debut, :fin, 'en attente')");
    $stmtReservation->execute([
        ':id_terrain' => $idTerrain,
        ':id_match' => $idMatch,
        ':date' => $date,
        ':debut' => $heure_debut,
        ':fin' => $heure_fin
    ]);

    $_SESSION['success'] = "Match, équipes, terrain et réservation créés avec succès.";
    header("Location: ../matches");
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la création : " . $e->getMessage();
    header("Location: ../create_match");
    exit();
}
