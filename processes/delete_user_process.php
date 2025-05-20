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
include_once '../includes/config/config.php';

$sql = 'DELETE FROM utilisateur WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    // Optional: redirect after success
    header("Location: ../admin/users");
    exit();
} else {
    // Handle error
    echo "Erreur lors de la suppression de l'utilisateur.";
}

?>