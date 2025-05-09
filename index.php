<?php
session_start();

include_once "includes/config/variables.php";

include_once $includesConfig . "functions.php";

$isAuthenticated = isAuthenticated();

if (!$isAuthenticated) {
    header("location: login.php");
} else {
    header("location: pages/public/home.php");
}

?>