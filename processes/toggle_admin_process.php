<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../admin/users');
    exit();
}

include_once '../includes/config/config.php';



$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$new_droits = filter_input(INPUT_POST, 'new_droits', FILTER_VALIDATE_INT);

$sql = "UPDATE utilisateur SET droits = :droits WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':droits' => $new_droits,
    ':id' => $id
]);

header('location: ../admin/users');
exit();

?>