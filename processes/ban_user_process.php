<?php

include_once '../includes/global/session.php';

notLogguedSecurity("../index.php");

$user = $_SESSION['user_info'];

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$sql = 'UPDATE utilisateur SET is_banned = 1, banned_on = CURDATE(), ban_count = ban_count + 1 WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: ../admin/users");
exit();

?>