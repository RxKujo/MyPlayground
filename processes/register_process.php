<?php

session_start();

include_once '../includes/config/variables.php';
include_once $includesConfig . 'functions.php';
include_once $includesConfig . 'config.php';

include_once $includesConfig . 'email_functions.php';


$prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$tel = filter_input(INPUT_POST, "tel", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$naissance = filter_input(INPUT_POST, "naissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$adresse = filter_input(INPUT_POST, "adresse", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$role = filter_input(INPUT_POST, "role", FILTER_VALIDATE_INT);
$position = filter_input(INPUT_POST, "position", FILTER_VALIDATE_INT);
$niveau = filter_input(INPUT_POST, "niveau", FILTER_VALIDATE_INT);

$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$captcha = filter_input(INPUT_POST, "reponse", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$captcha_expected = $_SESSION['captcha_expected'];

$_SESSION['form_data'] = [
    'prenom' => $prenom,
    'nom' => $nom,
    'email' => $email,
    'tel' => $tel,
    'naissance' => $naissance,
    'adresse' => $adresse,
    'pseudo' => $pseudo
];


unset($_SESSION['captcha_expected']);

$result = createUser(
    $pdo,

    $prenom,
    $nom,
    $email,
    $tel,
    $naissance,
    $adresse,
    $pseudo,
    $role,
    $position,
    $niveau,

    $password,
    $confirm_password,

    $captcha,
    $captcha_expected
);

$ok = $result['success'];
$message = $result['message'];
$verificationToken = $result['token'];

if ($ok) {
    $r = sendVerificationEmail($email, $prenom, $verificationToken);
    if ($r === true) {
        $_SESSION['register_success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    } else {
        $_SESSION['register_success'] = "Inscription réussie, mais impossible d’envoyer l’email de vérification. err=$r";
    }
    
    unset($_SESSION['form_data']);

    header("location: ../login.php");
    exit();
}

$_SESSION['register_error'] = $message;
header("location: ../register.php");
exit();
