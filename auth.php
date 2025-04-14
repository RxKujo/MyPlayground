<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: erreur.php?err=1");
    exit();
}

$username = filter_input( INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input( INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

print $username;
print $password;

if (!$username or !$password) {
    header("location: erreur.php?err=2");
    exit();
}

if ($username == "morad" && $password == "devisch") {
    $_SESSION['authenticated'] = true;
    header("location: index.php");
    exit();
} else {
    header("location: erreur.php?err=3");
    exit();
}