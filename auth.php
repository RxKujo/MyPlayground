<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: login.php");
    exit();
}

// --- Connexion à la base de données ---
$host = 'localhost';
$dbname = 'myplayground';
$user = 'root';
$pass = ''; // Ajoutez votre mot de passe si nécessaire

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// --- Récupération des données du formulaire ---
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = $_POST["password"];

// Stocker les données saisies pour les réafficher en cas d'erreur
$_SESSION['form_data'] = [
    'pseudo' => $username,
];

// --- Vérifications des champs ---
if (!$username || !$password) {
    $_SESSION['error'] = 'Tous les champs sont obligatoires.';
    header("location: login.php");
    exit();
}

// --- Vérification dans la base de données ---
$sql = "SELECT * FROM utilisateur WHERE pseudo = :pseudo LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['mdp'])) {
    // Connexion réussie
    $_SESSION['authenticated'] = true;
    $_SESSION['pseudo'] = $user['pseudo'];
    $userJson = json_encode($user);
    setcookie("user", $userJson, time() + 86400, "/"); // 86400 = 1 jour
    header("location: index.php");
    exit();
} else {
    // Erreur de connexion
    $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
    header("location: login.php");
    exit();
}
