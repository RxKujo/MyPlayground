<?php
include_once '../includes/global/session.php';
notLogguedSecurity("../index.php");

$user = $_SESSION['user_info'];
$id_user = $user['id'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_match = intval($_POST['id_match'] ?? 0);
    $id_equipe = intval($_POST['equipe'] ?? 0);

    if ($id_match <= 0 || $id_equipe <= 0) {
        header("Location: ../matches");
        exit();
    }

    try {
        $check = $pdo->prepare("SELECT COUNT(*) FROM appartenir WHERE id = ? AND id_equipe = ?");
        $check->execute([$id_user, $id_equipe]);
        if ($check->fetchColumn() > 0) {
            header("Location: ../matches");
            exit();
        }

        $insert = $pdo->prepare("INSERT INTO appartenir (id, id_equipe) VALUES (?, ?)");
        $insert->execute([$id_user, $id_equipe]);

        header("Location: ../matches");
        exit();
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
} else {
    header("Location: ../matches");
    exit();
}
