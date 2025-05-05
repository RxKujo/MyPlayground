<?php
session_start();


$host = 'localhost';
$dbname = 'myplayground';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];
$phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
$firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$_SESSION['form_data'] = [
    'email' => $email,
    'phone' => $phone,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'address' => $address,
    'position' => $position,
];

if (!$username || !$email || !$password || !$confirmPassword || !$phone || !$firstname || !$lastname || !$address || !$position) {
    $_SESSION['error'] = 'Tous les champs sont obligatoires.';
    header("location: register.php");
    exit();
}


if ($password !== $confirmPassword) {
    $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
    header("location: register.php");
    exit();
}

$query = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE pseudo = :pseudo OR email = :email");
$query->execute(['pseudo' => $username, 'email' => $email]);
if ($query->fetchColumn() > 0) {
    $_SESSION['error'] = 'Le nom d\'utilisateur ou l\'adresse e-mail est déjà utilisé.';
    
    unset($_SESSION['form_data']['username']);
    header("location: register.php");
    exit();
}


$hashedPassword = password_hash($password, PASSWORD_BCRYPT);


$query = $pdo->prepare("
    INSERT INTO utilisateur (pseudo, email, mdp, tel, prenom, nom, localisation, poste, role, droits)
    VALUES (:pseudo, :email, :mdp, :tel, :prenom, :nom, :localisation, :poste, :role, :droits)
");

$query->execute([
    'pseudo' => $username,
    'email' => $email,
    'mdp' => $hashedPassword,
    'tel' => $phone,
    'prenom' => $firstname,
    'nom' => $lastname,
    'localisation' => $address,
    'poste' => $position,
    'role' => 0,
    'droits' => 0,
]);


unset($_SESSION['form_data']);

$_SESSION['success'] = 'Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.';
header("location: index.php");
exit();
?>
