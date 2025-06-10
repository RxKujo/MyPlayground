<?php

include_once '../includes/global/session.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: ../pages/errors/500.html");
    exit();
}

clearSession($pdo, $_SESSION['user_id'] ?? null);
header('location: ../index.php');
exit();
?>