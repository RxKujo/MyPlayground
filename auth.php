<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

include_once 'includes/config/functions.php';
include_once 'includes/config/config.php';

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// $email = filter_input(INPUT_POST, "username", FILTER_SANITIZE_EMAIL);

$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$_SESSION['form_data'] = ['username' => $username];
$_SESSION['debug']['data'] = [$username, $password, $captcha];


if ((!$username && !$email) || !$password) {
    $_SESSION['errors']['login_error'] = 'Tous les champs sont obligatoires.';
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['captcha_expected']) || strtolower($captcha) !== strtolower($_SESSION['captcha_expected'])) {
    $_SESSION['errors']['captcha_error'] = "Veuillez valider correctement le captcha.";
    header("Location: login.php");
    exit();
}

unset($_SESSION['captcha_expected']);

if (true) {
    $sql = "SELECT id, mdp FROM utilisateur WHERE pseudo = :pseudo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $username);
}
// } else if (!$username) {
//     $sql = "SELECT id, mdp FROM utilisateur WHERE email = :email OR  LIMIT 1";
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindParam(':email', $email);
// }

$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['errors']['login_error'] = "Nom d'utilisateur, e-mail ou mot de passe incorrect.";
    header("Location: login.php");
    exit();
}

$isPasswordCorrect = password_verify($password, $user['mdp']);

$sql = "SELECT * FROM utilisateur WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user['id']);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);



if ($isPasswordCorrect) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_info'] = $user;
    $_SESSION['success'] = 'Connexion réussie !';
    unset($_SESSION['form_data']);
    header("location: home");
    exit();
} else {
    $_SESSION['errors']['login_error'] = "Nom d'utilisateur ou mot de passe incorrect.";
    header("Location: login.php");
    exit();
}