<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: login.php");
    exit();
}

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    header("location: index.php");
    exit();
}

include_once 'includes/config/functions.php';

print_error($_SESSION);

include_once 'includes/config/config.php';

    

// --- Récupération des données du formulaire ---
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Stocker les données saisies pour les réafficher en cas d'erreur
$_SESSION['form_data'] = [
    'username' => $username,
];

// --- Vérifications des champs ---
if (!$username || !$password) {
    $_SESSION['error'] = 'Tous les champs sont obligatoires.';
    header("location: index.php");
    exit();
}

// --- Vérification dans la base de données ---
$sql = "SELECT * FROM utilisateur WHERE pseudo = :pseudo LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pseudo', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$user || is_null($user)) {
    $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
    header("location: index.php");
    exit();
}

$isPasswordCorrect = password_verify($password, $user['mdp']);

if ($isPasswordCorrect) {
    // Connexion réussie
    $_SESSION['authenticated'] = true;
    setcookie("user", json_encode($user), time() + (86400 * 30), "/"); // 86400 = 1 jour
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['success'] = 'Connexion réussie !';
    header("location: index.php");
    exit();
} else {
    $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
    header("location: index.php");
    exit();
}