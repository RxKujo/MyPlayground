<?php
session_start();
include_once '../includes/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $nom = trim($_POST['nom_tournoi'] ?? '');
    $lieu = trim($_POST['lieu'] ?? '');
    $date_tournoi = $_POST['date_tournoi'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $age = intval($_POST['age'] ?? 0);
    $nombre_utilisateurs_max = intval($_POST['nombre_utilisateurs_max'] ?? 0);
    $statut = $_POST['statut'] ?? '';
    $description = trim($_POST['description'] ?? '');

    // Validation simple
    if (empty($nom) || empty($lieu) || empty($date_tournoi) || empty($categorie) || $age <= 0 || $nombre_utilisateurs_max <= 0 || empty($statut)) {
        $_SESSION['error'] = "Tous les champs obligatoires doivent être remplis correctement.";
        header("Location: ../create_tournament");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO tournoi (nom, date_tournoi, lieu, description, categorie, age, nombre_utilisateurs_max, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $date_tournoi, $lieu, $description, $categorie, $age, $nombre_utilisateurs_max, $statut]);

        $_SESSION['success'] = "Tournoi créé avec succès.";
        header("Location: ../tournaments");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la création du tournoi : " . $e->getMessage();
        header("Location: ../create_tournament");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
