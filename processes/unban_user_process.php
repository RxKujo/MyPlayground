<?php

include_once '../includes/global/session.php';

notLogguedSecurity("/");

$user = $_SESSION['user_info'];

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$sql = 'UPDATE utilisateur SET is_banned = 0 WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: ../admin/banned");
exit();

?>