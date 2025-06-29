<?php

include_once '../includes/global/session.php';

notLogguedSecurity("../../index.php");

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
$heure_debut = filter_input(INPUT_POST, "fin", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$heure_fin   = filter_input(INPUT_POST, "fin", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categorie   = filter_input(INPUT_POST, "categorie", FILTER_VALIDATE_INT);
$niveau_min  = filter_input(INPUT_POST, "niveau_min", FILTER_VALIDATE_INT);
$commentaire = filter_input(INPUT_POST, "commentaire", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$createur_id = $_SESSION['user_id'];

?>