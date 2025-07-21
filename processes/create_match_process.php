<?php

include_once '../includes/global/session.php';

notLogguedSecurity("/");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Méthode non autorisée.";
    header("Location: ../create_match");
    exit();
}

$user = $_SESSION['user_info'];
$isAdmin = isAdmin($user);

$nom_match   = filter_input(INPUT_POST, "nom_match", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$localisation = filter_input(INPUT_POST, "nom_match", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date        = filter_input(INPUT_POST, "date", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date_reservation = DateTime::createFromFormat('Y-m-d', $date);
$today = new DateTime();
$today->setTime(0, 0, 0);

if (!$date_reservation) {
    $_SESSION['error'] = "La date fournie est invalide.";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../create_match");
    exit();
}

$interval = $today->diff($date_reservation);
$days_diff = (int)$interval->format('%r%a');

if ($days_diff < 0) {
    $_SESSION['error'] = "La date ne peut pas être dans le passé.";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../create_match");
    exit();
}

if ($days_diff > 14) {
    $_SESSION['error'] = "Un match ne peut pas être créé avec plus de deux semaines d'avance";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../create_match");
    exit();
}

$heure_debut = filter_input(INPUT_POST, "debut", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$heure_fin   = filter_input(INPUT_POST, "fin", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$debut = DateTime::createFromFormat('H:i', $heure_debut);
$fin = DateTime::createFromFormat('H:i', $heure_fin);

if (!$debut || !$fin) {
    $_SESSION['error'] = "Heure invalide.";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../create_match");
    exit();
}

if ($fin <= $debut) {
    $_SESSION['error'] = "L'heure de fin doit être après l'heure de début.";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../create_match");
    exit();
}

$categorie   = filter_input(INPUT_POST, "categorie", FILTER_VALIDATE_INT);
$niveau_min  = filter_input(INPUT_POST, "niveau_min", FILTER_VALIDATE_INT);
$commentaire = filter_input(INPUT_POST, "commentaire", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$createur_id = $_SESSION['user_id'];

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

    $stmtEquipe = $pdo->prepare(
        "INSERT INTO equipe (nom, date_creation, privee, code, categorie_age, ville, niveau_min, commentaire, logo, id_createur) 
        VALUES 
        (:nom, CURDATE(), 0, NULL, NULL, NULL, :niveau_min, :commentaire, NULL, :id_createur)");

    $stmtEquipe->execute([
        ':nom' => "Équipe A",
        ':niveau_min' => $niveau_min,
        ':commentaire' => $commentaire,
        ':id_createur' => $createur_id
    ]);

    $idEquipe1 = $pdo->lastInsertId();

    $stmtEquipe->execute([
        ':nom' => "Équipe B",
        ':niveau_min' => $niveau_min,
        ':commentaire' => $commentaire,
        ':id_createur' => $createur_id
    ]);
    
    $idEquipe2 = $pdo->lastInsertId();

    $stmtMatch = $pdo->prepare("
        INSERT INTO `match` (id_equipe1, id_equipe2, statut, message, id_createur)
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
    if ($isAdmin) {
        header('Location: ../admin/matches');
        exit();
    }
    header("Location: ../matches");
    exit();

} catch (PDOException $e) {
    $_SESSION['match_creation_error'] = "Erreur lors de la création : " . $e->getMessage();
    header("Location: ../create_match");
    exit();
}
