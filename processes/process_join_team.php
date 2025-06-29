<?php
session_start();
include_once '../includes/config/config.php';

if (!isset($_SESSION['user_info'])) {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user_info'];
$pseudo = $user['pseudo'];
$id_equipe = intval($_POST['id_equipe'] ?? 0);

$check = mysqli_query($conn, "SELECT * FROM equipe WHERE id_equipe = $id_equipe");
if (mysqli_num_rows($check) === 0) {
    header("Location: ../pages/public/teams.php?error=equipe_not_found");
    exit();
}

$already = mysqli_query($conn, "SELECT * FROM equipe_membre WHERE id_equipe = $id_equipe AND pseudo = '$pseudo'");
if (mysqli_num_rows($already) === 0) {
    mysqli_query($conn, "INSERT INTO equipe_membre (id_equipe, pseudo, poste) VALUES ($id_equipe, '$pseudo', 'Membre')");
}

header("Location: ../pages/public/teams.php?success=joined");
exit();
