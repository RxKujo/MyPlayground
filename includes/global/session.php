<?php

$inactive = 900;

session_start();

// Check if last activity was set
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive)) {
    // 1800 seconds = 30 minutes
    session_unset();
    session_destroy();
    header("Location: ../../login.php");
    exit();
}

// Update last activity time stamp
$_SESSION['last_activity'] = time();

$root = $_SERVER['DOCUMENT_ROOT'] . "/";

include_once $root . "includes/config/variables.php";
include_once $includesConfig . "functions.php";

?>