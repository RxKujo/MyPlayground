<?php

session_start();

include_once "includes/config/variables.php";

include_once $includesConfig . "functions.php";

$isAuthenticated = isAuthenticated($_SESSION);

if (!$isAuthenticated) {
    header("location: login.php");
    exit();
} else {
    header("location: home");
    exit();
}

?>