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
    $categorie = $_POST['niveau'] ?? '';
    $niveau_min = $_POST['niveau_min'] ?? 0;
    $commentaire = $_POST['commentaire'] ?? '';
    $createur_id = $_SESSION['user_id'];

    $joueurs_par_equipe = match ((int)$categorie) {
        0 => 1,
        1 => 2,
        2 => 3,
        3 => 4,
        default => 5
    };

    if (
        empty($nom_match) || empty($localisation) || empty($date_debut) ||
        empty($date_fin) || $categorie === '' || !is_numeric($niveau_min)
    ) {
        $_SESSION['error'] = "Tous les champs doivent être remplis.";
        header("Location: ../profile/create-match.php");
        exit();
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO match (nom, createur_id, date_debut, date_fin, nb_joueurs, niveau_minimum, localisation, commentaire)
            VALUES (:nom, :createur_id, :date_debut, :date_fin, :nb_joueurs, :niveau_minimum, :localisation, :commentaire)");

        $stmt->execute([
            ':nom' => $nom_match,
            ':createur_id' => $createur_id,
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin,
            ':nb_joueurs' => $joueurs_par_equipe * 2,
            ':niveau_minimum' => $niveau_min,
            ':localisation' => $localisation,
            ':commentaire' => $commentaire
        ]);

        $match_id = $pdo->lastInsertId();

        // Créer deux équipes liées au match
        $stmtEquipe = $pdo->prepare("INSERT INTO equipe (nom_equipe, match_id, nb_joueurs_max) VALUES (:nom, :match_id, :max)");

        $stmtEquipe->execute([
            ':nom' => "Equipe 1",
            ':match_id' => $match_id,
            ':max' => $joueurs_par_equipe
        ]);

        $stmtEquipe->execute([
            ':nom' => "Equipe 2",
            ':match_id' => $match_id,
            ':max' => $joueurs_par_equipe
        ]);

        $pdo->commit();

        header("Location: ../profile/profile.php");
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Erreur lors de la création du match : " . $e->getMessage();
        header("Location: ../profile/create-match.php");
        exit();
    }
}

header("Location: ../profile/create-match.php");
exit();
    