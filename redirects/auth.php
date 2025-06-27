<?php

include_once '../includes/global/session.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . login);
    exit();
}

const home = '../home';
const login = '../login.php';

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$_SESSION['form_data'] = ['username' => $username];

if ((!$username && !$email) || !$password) {
    redirectError('login_error', 'Tous les champs sont obligatoires', login);
}

if (!isset($_SESSION['captcha_expected']) || strtolower($captcha) !== strtolower($_SESSION['captcha_expected'])) {
    redirectError('captcha_error', 'Êtes-vous un bot ? Veuillez valider correctement le captcha.', login);
}

unset($_SESSION['captcha_expected']);

if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT id, mdp FROM utilisateur WHERE email = :input LIMIT 1";
} else {
    $sql = "SELECT id, mdp FROM utilisateur WHERE pseudo = :input LIMIT 1";
}

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':input', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirectError('login_error', "Nom d'utilisateur, e-mail ou mot de passe incorrect.", login);
}

$isPasswordCorrect = password_verify($password, $user['mdp']);


$user = getUser($pdo, $user['id']);



if ($isPasswordCorrect) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_info'] = $user;
    $_SESSION['success'] = 'Connexion réussie !';

    if (!makeOnline($pdo, $user['id'])) {
        redirectError('login_error', "Vous êtes déjà connecté sur un autre appareil", login);
    }
    
    unset($_SESSION['form_data']);
    header("location: " . home);
    exit();
} else {
    redirectError('login_error', "Nom d'utilisateur, e-mail ou mot de passe incorrect.", login);
}