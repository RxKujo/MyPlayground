<?php
session_start();

include_once '../includes/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $mdp = $_POST['password'];
    $mdp_confirm = $_POST['confirm_password'];
    $tel = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
    $prenom = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
    $nom = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
    $localisation = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $poste = filter_input(INPUT_POST, "position", FILTER_VALIDATE_INT);
    $naissance = filter_input(INPUT_POST, "naissance", FILTER_SANITIZE_SPECIAL_CHARS);
    $role = 0;
    $droits = 0;
} else {
    header("location: ../register.php");
    exit();
}

$parameters = [
    $pseudo,
    $email,
    $mdp,
    $mdp_confirm,
    $tel,
    $prenom,
    $nom,
    $localisation,
    $poste,
    $naissance,
];

$_SESSION['form_data'] = [
    'email' => $email,
    'phone' => $tel,
    'firstname' => $prenom,
    'lastname' => $nom,
    'address' => $localisation,
    'position' => $poste,
];

if (!$pseudo || !$email || !$mdp || !$mdp_confirm || !$tel || !$prenom || !$nom || !$localisation || ($poste === null) || !$naissance) {
    if (!$email) {
        $_SESSION['error'] = 'L\'adresse e-mail est invalide.';
    } else {
        $_SESSION['error'] = 'Tous les champs sont obligatoires.';
    }
    header("location: ../register.php");
    exit();
}


if ($mdp !== $mdp_confirm) {
    $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
    header("location: ../register.php");
    exit();
}

$query = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE pseudo = :pseudo OR email = :email");
$query->bindParam(':pseudo', $pseudo);
$query->bindParam(':email', $email);
$query->execute();
if ($query->fetchColumn() > 0) {
    $_SESSION['error'] = 'Le nom d\'utilisateur ou l\'adresse e-mail est déjà utilisé.';

    unset($_SESSION['form_data']['username']);
    header("location: ../register.php");
    exit();
}


$hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);


$query = $pdo->prepare("
    INSERT INTO utilisateur (pseudo, email, mdp, tel, prenom, nom, localisation, date_naissance, poste, role, droits)
    VALUES (:pseudo, :email, :mdp, :tel, :prenom, :nom, :localisation, :naissance, :poste, :role, :droits)
");

$query->bindParam(':pseudo', $pseudo);
$query->bindParam(':email', $email);
$query->bindParam(':mdp', $hashedPassword);
$query->bindParam(':tel', $tel);
$query->bindParam(':prenom', $prenom);
$query->bindParam(':nom', $nom);
$query->bindParam(':localisation', $localisation);
$query->bindParam(':naissance', $naissance);
$query->bindParam(':poste', $poste);
$query->bindParam(':role', $role);
$query->bindParam(':droits', $droits);

$query->execute();


unset($_SESSION['form_data']);

$_SESSION['register-success'] = 'Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.';
header("location: ../index.php");
exit();
?>