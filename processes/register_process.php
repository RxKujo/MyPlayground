<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit();
}

include_once 'includes/config/functions.php';
include_once 'includes/config/config.php';

// Récupération et nettoyage des données
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password_confirm = filter_input(INPUT_POST, "password_confirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$expected_captcha = filter_input(INPUT_POST, "expected_captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Stockage des données pour réaffichage en cas d'erreur (sauf mdp)
$_SESSION['form_data'] = ['username' => $username];

// Vérification des champs obligatoires
if (!$username || !$password || !$password_confirm) {
    $_SESSION['register_error'] = "Tous les champs sont obligatoires.";
    header("Location: register.php");
    exit();
}

// Vérification confirmation mot de passe
if ($password !== $password_confirm) {
    $_SESSION['register_error'] = "Les mots de passe ne correspondent pas.";
    header("Location: register.php");
    exit();
}

// Vérification captcha
if (!$captcha || !$expected_captcha || strtolower($captcha) !== strtolower($expected_captcha)) {
    $_SESSION['captcha_error'] = "Veuillez valider correctement le captcha.";
    header("Location: register.php");
    exit();
}

// Vérifier si l'utilisateur existe déjà
$sql = "SELECT id FROM utilisateur WHERE pseudo = :pseudo LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $username);
$stmt->execute();

if ($stmt->fetch()) {
    $_SESSION['register_error'] = "Ce nom d'utilisateur est déjà pris.";
    header("Location: register.php");
    exit();
}

// Hachage du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertion en base
$sql = "INSERT INTO utilisateur (pseudo, mdp) VALUES (:pseudo, :mdp)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $username);
$stmt->bindParam(':mdp', $hashedPassword);

if ($stmt->execute()) {
    unset($_SESSION['form_data']);
    $_SESSION['register-success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['register_error'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
    header("Location: register.php");
    exit();
}

