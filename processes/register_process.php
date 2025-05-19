<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: register.php");
    exit();
}

include_once '../includes/config/functions.php';
include_once '../includes/config/config.php';

// Récupération et nettoyage des données
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
$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$expected_captcha = filter_input(INPUT_POST, "expected_captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Stockage des données pour réaffichage en cas d'erreur (sauf mdp)
$_SESSION['form_data'] = [
    'prenom' => $prenom,
    'nom' => $nom,
    'email' => $email,
    'tel' => $tel,
    'naissance' => $naissance,
    'adresse' => $adresse,
    'pseudo' => $pseudo
];

// Vérification des champs obligatoires
if (!$prenom || !$nom || !$email || !$tel || !$naissance || !$adresse || !$pseudo || !$password || !$confirm_password) {
    $_SESSION['register_error'] = "Tous les champs sont obligatoires. " . json_encode($_SESSION['form_data']) . $password . $confirm_password;
    header("location: ../register.php");
    exit();
}

// Vérification confirmation mot de passe
if ($password !== $confirm_password) {
    $_SESSION['register_error'] = "Les mots de passe ne correspondent pas.";
    header("location: ../register.php");
    exit();
}

// Vérification captcha
if (!$captcha || !$expected_captcha || strtolower($captcha) !== strtolower($expected_captcha)) {
    $_SESSION['captcha_error'] = "Veuillez valider correctement le captcha.";
    header("location: ../register.php");
    exit();
}

// Vérifier si l'utilisateur existe déjà
$sql = "SELECT id FROM utilisateur WHERE pseudo = :pseudo OR email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $username);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->fetch()) {
    $_SESSION['register_error'] = "Nom d'utilisateur ou email déjà utilisé.";
    header("location: ../register.php");
    exit();
}

// Hachage du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertion en base
$sql = "INSERT INTO utilisateur (pseudo, prenom, nom, date_naissance, email, mdp, tel, poste, role, localisation, niveau, description) 
VALUES (:pseudo, :prenom, :nom, :naissance, :email, :mdp, :tel, :poste, :role, :localisation, :niveau, :description)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $pseudo);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':naissance', $naissance);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':mdp', $hashedPassword);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':poste', $poste);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':localisation', $localisation);
$stmt->bindParam(':niveau', $niveau);
$stmt->bindParam(':description', $description);


if ($stmt->execute()) {
    unset($_SESSION['form_data']);
    $_SESSION['register_success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    header("location: ../login.php");
    exit();
} else {
    $_SESSION['register_error'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
    header("location: ../register.php");
    exit();
}

