<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: erreur.php?err=1");
    exit();
}

$recaptchaSecret = '6Lfq0ygrAAAAAP3lPyMi1M67abXrJNIWXJRe-Zgm';
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Vérification du reCAPTCHA
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
$responseKeys = json_decode($response, true);

if (!$responseKeys['success']) {
    $_SESSION['error'] = 'Échec de la vérification du reCAPTCHA.';
    header("location: register.php");
    exit();
}

// Récupération des données du formulaire
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];
$phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Stocker les données saisies dans la session pour les réafficher en cas d'erreur
$_SESSION['form_data'] = [
    'email' => $email,
    'phone' => $phone,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'address' => $address,
    'username' => $username,
    'position' => $position,
];

// Vérifications des champs obligatoires
if (!$email || !$password || !$confirmPassword || !$phone || !$firstname || !$lastname || !$address || !$username || !$position) {
    $_SESSION['error'] = 'Tous les champs sont obligatoires.';
    header("location: register.php");
    exit();
}

// Vérification des mots de passe
if ($password !== $confirmPassword) {
    $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
    header("location: register.php");
    exit();
}

// Vérification de l'adresse e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Adresse e-mail invalide.';
    header("location: register.php");
    exit();
}

// Vérification du numéro de téléphone
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    $_SESSION['error'] = 'Numéro de téléphone invalide. Veuillez entrer un numéro à 10 chiffres.';
    header("location: register.php");
    exit();
}

// Vérification si le pseudo est déjà pris
$users = file("users.txt", FILE_IGNORE_NEW_LINES);
foreach ($users as $user) {
    list(, , , , , , $existingUsername) = explode("|", $user);
    if ($existingUsername === $username) {
        $_SESSION['error'] = 'Le pseudo est déjà pris. Veuillez en choisir un autre.';
        header("location: register.php");
        exit();
    }
}

// Hachage du mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Sauvegarder les informations utilisateur
$userData = "$email|$hashedPassword|$phone|$firstname|$lastname|$address|$username|$position\n";
file_put_contents("users.txt", $userData, FILE_APPEND);

// Supprimer les données de formulaire de la session après succès
unset($_SESSION['form_data']);

// Redirection vers la page index.php après inscription réussie
$_SESSION['authenticated'] = true;
$_SESSION['username'] = $username; // Stocke le pseudo dans la session
header("location: index.php");
exit();
?>