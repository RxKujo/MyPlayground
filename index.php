<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
include_once $root . '/includes/config/variables.php';

include_once $includesConfig . 'variables.php';
include_once $includesConfig . 'functions.php';

$isAuthenticated = isAuthenticated();

if (!$isAuthenticated) {
    include_once("login.php");
} else {
    include_once("main.php");
}

?>