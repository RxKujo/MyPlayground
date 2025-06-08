<?php

$inactive = 900; 
ini_set('session.gc_maxlifetime', $inactive);

session_start();

$root = $_SERVER['DOCUMENT_ROOT'] . "/";

include_once $root . "includes/config/variables.php";
include_once $includesConfig . "functions.php";

?>