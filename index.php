<?php
session_start();




$root = $_SERVER['DOCUMENT_ROOT'];

$includesPublic = $root . "/MyPlayground/includes/public/";
$includesAdmin = $root . "/MyPlayground/includes/admin/";
$includesGlobal = $root . "/MyPlayground/includes/global/";
$includesConfig = $root . "/MyPlayground/includes/config/";

$assetsPublic = $root . "/MyPlayground/assets/public/";
$assetsAdmin = $root . "/MyPlayground/assets/admin/";
$assetsGlobal = $root . "/MyPlayground/assets/global/";

include_once $includesConfig . 'functions.php';
include_once $includesConfig . 'variables.php';

$isAuthenticated = isAuthenticated();

if (!$isAuthenticated) {
    include_once("login.php");
} else {
    include_once("main.php");
}

?>