<?php
// filepath: c:\xampp\htdocs\MyPlayground\pages\public\inscription_tournoi.php

include_once '../../includes/global/session.php';
include_once '../../includes/config/functions.php';

if (!isset($_SESSION['user_info']['id'])) {
    header('Location: /login.php');
    exit;
}

$id_tournoi = $_GET['id'] ?? null;
$user_id = $_SESSION['user_info']['id'];

if (!$id_tournoi) {
    echo "Aucun tournoi sélectionné.";
    exit;
}

$stmt = $pdo->prepare("SELECT e.id_equipe, e.nom FROM equipe e
    JOIN equipe_membre em ON em.id_equipe = e.id_equipe
    WHERE em.id_utilisateur = ?");
$stmt->execute([$user_id]);
$equipes = $stmt->fetchAll();
if (count($equipes) === 0) {
    $result = [
        'success' => false,
        'message' => "Vous n'avez pas rejoint d'équipe."
    ];
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_equipe'])) {
        $id_equipe = $_POST['id_equipe'];
    } elseif (count($equipes) === 1) {
        $id_equipe = $equipes[0]['id_equipe'];
    } else {
        echo "<form method='post' class='mt-5'>";
        echo "<label for='id_equipe'>Choisissez votre équipe :</label>";
        echo "<select name='id_equipe' id='id_equipe' class='form-select mb-2'>";
        foreach ($equipes as $equipe) {
            echo "<option value='{$equipe['id_equipe']}'>{$equipe['nom']}</option>";
        }
        echo "</select>";
        echo "<button type='submit' class='btn btn-primary'>S'inscrire</button>";
        echo "</form>";
        exit;
    }

    $nb_requis = 5;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM equipe_membre WHERE id_equipe = ?");
    $stmt->execute([$id_equipe]);
    $nb_membres = $stmt->fetchColumn();

    if ($nb_membres < $nb_requis) {
        $result = [
            'success' => false,
            'message' => "Votre équipe n'est pas complète."
        ];
    } else {
        $result = inscrireEquipeTournoi($pdo, $id_tournoi, $id_equipe);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription au tournoi</title>
    <link rel="stylesheet" href="/assets/admin/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Inscription au tournoi</h1>
        <div class="alert <?= $result['success'] ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($result['message']) ?>
        </div>
        <a href="/tournaments_list" class="btn btn-primary mt-3">Retour à la liste des tournois</a>
    </div>
</body>
</html>