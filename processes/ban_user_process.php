<?php

include_once '../includes/global/session.php';

notLogguedSecurity("/");

$user = $_SESSION['user_info'];

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$bandef = filter_input(INPUT_POST, 'bandef', FILTER_VALIDATE_INT);
$raison = filter_input(INPUT_POST, "raison", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$bandef) {
    $date_fin = filter_input(INPUT_POST, "date", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

createBan($pdo, $id, $raison, $date_fin);


header("Location: ../admin/users");
exit();

?>