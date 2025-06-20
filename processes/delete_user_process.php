<?php

include_once '../includes/global/session.php';

notLogguedSecurity("../index.php");

$user = $_SESSION['user_info'];

if ($_POST['id']) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
}


$space = filter_input(INPUT_POST, 'userspace', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

include_once '../includes/config/config.php';
include_once '../includes/config/functions.php';

$sql = 'DELETE FROM utilisateur WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    if ($space === 'admin') {
        header("Location: ../admin/users");
        exit();
    } else if ($space === 'user') {
        clearSession($pdo, $user['id']);
    }
} else {
    echo "Erreur lors de la suppression de l'utilisateur.";
}

header("Location: ../admin/users");
exit();

?>