<?php
session_start();

// --- Connexion à la base de données ---
include("includes/config/config.php");

$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];



$root = $_SERVER['DOCUMENT_ROOT'];

$includesPublic = $root . "/MyPlayground/includes/public/";
$includesAdmin = $root . "/MyPlayground/includes/admin/";
$includesGlobal = $root . "/MyPlayground/includes/global/";

$assetsPublic = $root . "/MyPlayground/assets/public/";
$assetsAdmin = $root . "/MyPlayground/assets/admin/";
$assetsGlobal = $root . "/MyPlayground/assets/global/";

if (!$isAuthenticated) {
    include("login.php");
} else {
    include("home.php");
}

?>