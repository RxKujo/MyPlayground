<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ../index.php");
    exit();
}

if ($_POST['id']) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
} else {
    if (isset($_SESSION) && $_SESSION['user_id']) {
        $id = $_SESSION['user_id'];
    } else {
        header("location: ../index.php");
        exit();
    }
}

$space = filter_input(INPUT_POST, 'userspace', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

include_once '../includes/config/config.php';
include_once '../includes/config/functions.php';

$sql = 'DELETE FROM utilisateur WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    // Optional: redirect after success

    if ($space === 'admin') {
        header("Location: ../admin/users");
        exit();
    } else if ($space === 'user') {
        clearSession();
    }
} else {
    // Handle error
    echo "Erreur lors de la suppression de l'utilisateur.";
}

?>