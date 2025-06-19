<?php
session_start();
include_once '../../includes/config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Méthode non autorisée.";
    header("Location: ../create_match");
    exit();
}

$nom_match = $_POST['nom_match'] ?? '';
$localisation = $_POST['localisation'] ?? '';
$date_debut = $_POST['date_debut'] ?? '';
$date_fin = $_POST['date_fin'] ?? '';
$categorie = $_POST['categorie'] ?? '';
$niveau_min = $_POST['niveau_min'] ?? 0;
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
    empty($nom_match) || empty($localisation) || empty($date_debut) ||
    empty($date_fin) || $categorie === '' || !is_numeric($niveau_min)
) {
    $_SESSION['error'] = "Tous les champs doivent être remplis.";
    header("Location: ../create_match");
    exit();
}

try {
    $pdo->beginTransaction();

    $stmtEquipe = $pdo->prepare("INSERT INTO equipe (nom, date_creation) VALUES (:nom, CURDATE())");

    $stmtEquipe->execute([':nom' => "Équipe A"]);
    $idEquipe1 = $pdo->lastInsertId();

    $stmtEquipe->execute([':nom' => "Équipe B"]);
    $idEquipe2 = $pdo->lastInsertId();

    $stmtMatch = $pdo->prepare("
        INSERT INTO `match` (id_equipe1, id_equipe2, statut, message)
        VALUES (:id1, :id2, 'en_attente', :message)
    ");
    $stmtMatch->execute([
        ':id1' => $idEquipe1,
        ':id2' => $idEquipe2,
        ':message' => $commentaire
    ]);

    $pdo->commit();

    $_SESSION['success'] = "Match et équipes créés avec succès.";
    header("Location: ../match");
    exit();

} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Erreur lors de la création : " . $e->getMessage();
    header("Location: ../create_match");
    exit();
}
