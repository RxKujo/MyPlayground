<?php
include_once '../../includes/global/session.php';
include_once '../../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_match = $_POST['nom_match'] ?? '';
    $localisation = $_POST['localisation'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $nb_joueurs = $_POST['nb_joueurs'] ?? 0;
    $niveau_min = $_POST['niveau_min'] ?? 0;
    $commentaire = $_POST['commentaire'] ?? '';
    $createur_id = $_SESSION['user_id'];

    if (
        empty($nom_match) || empty($localisation) || empty($date_debut) ||
        empty($date_fin) || empty($nb_joueurs) || !is_numeric($niveau_min)
    ) {
        $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis.";
        header("Location: ../profile/create_match.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO match (nom, createur_id, date_debut, date_fin, nb_joueurs, niveau_minimum, localisation, commentaire)
            VALUES (:nom, :createur_id, :date_debut, :date_fin, :nb_joueurs, :niveau_minimum, :localisation, :commentaire)");

        $stmt->execute([
            ':nom' => $nom_match,
            ':createur_id' => $createur_id,
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
            ':nb_joueurs' => $nb_joueurs,
            ':niveau_minimum' => $niveau_min,
            ':localisation' => $localisation,
            ':commentaire' => $commentaire
        ]);

        header("Location: ../profile/profile.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la création du match : " . $e->getMessage();
        header("Location: ../profile/create_match.php");
        exit();
    }
}

header("Location: ../profile/create_match.php");
exit();
