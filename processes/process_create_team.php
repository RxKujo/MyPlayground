<?php
session_start();
require_once '../includes/config/config.php';

if (!isset($_SESSION['user_info'])) {
    header("Location: ../index.php");
    exit();
}

if (
    !isset($_POST['team_name']) ||
    !isset($_POST['position']) ||
    !isset($_POST['pseudo']) ||
    !isset($_POST['age'])
) {
    die("Tous les champs sont requis.");
}

$team_name = trim($_POST['team_name']);
$position = trim($_POST['position']);
$pseudo = trim($_POST['pseudo']);
$age = intval($_POST['age']);

try {
    
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO equipe (nom, date_creation) VALUES (?, NOW())");
    $stmt->execute([$team_name]);
    $id_equipe = $pdo->lastInsertId();

  
    $stmt = $pdo->prepare("INSERT INTO equipe_membre (id_equipe, pseudo, poste) VALUES (?, ?, ?)");
    $stmt->execute([$id_equipe, $pseudo, $position]);

    $pdo->commit();

    
    header("Location: ../pages/public/teams.php?success=1");
    exit();

} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Erreur lors de la création de l'équipe : " . $e->getMessage();
    exit();
}
