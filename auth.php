<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

include_once 'includes/config/functions.php';
include_once 'includes/config/config.php';

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$_SESSION['form_data'] = ['username' => $username];


if (!$username || !$password) {
    $_SESSION['login_error'] = 'Tous les champs sont obligatoires.';
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['captcha_expected']) || strtolower($captcha) !== strtolower($_SESSION['captcha_expected'])) {
    $_SESSION['captcha_error'] = "Veuillez valider correctement le captcha.";
    header("Location: login.php");
    exit();
}

unset($_SESSION['captcha_expected']);

$sql = "SELECT * FROM utilisateur WHERE pseudo = :pseudo LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect.";
    header("Location: login.php");
    exit();
}

$isPasswordCorrect = password_verify($password, $user['mdp']);

if ($isPasswordCorrect) {
    $_SESSION['user_info'] = $user;
    $_SESSION['success'] = 'Connexion réussie !';
    unset($_SESSION['form_data']);
    header("Location: home");
    exit();
} else {
    $_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect.";
    header("Location: login.php");
    exit();
}