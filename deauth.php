<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $root . '/includes/config/functions.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: pages/errors/500.html");
    exit();
}

session_destroy();
deleteCookie('user');
header("location: index.php");

exit();
?>