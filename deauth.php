<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: erreur.php?err=1");
    exit();
}

session_destroy();
header("location: login.php");
exit();
?>