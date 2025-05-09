<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $root . '/includes/config/functions.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: erreur.php?err=1");
    exit();
}

session_destroy();
deleteCookie('user');
header("location: index.php");

exit();
?>