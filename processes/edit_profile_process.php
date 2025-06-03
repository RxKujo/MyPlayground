<?php

include_once('../includes/global/session.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ../index.php");
    exit();
}

if ($_POST['id']) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
} else {
    if (isset($_SESSION) && $_SESSION['user_id']) {
        $id = $_SESSION['user_id'];
    } else {
        header("location: ../index.php");
        exit();
    }
}


include_once '../includes/config/config.php';



$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$niveau = filter_input(INPUT_POST, 'niveau', FILTER_VALIDATE_INT);
$poste = filter_input(INPUT_POST, 'poste', FILTER_VALIDATE_INT);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$role = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT);
$localisation = filter_input(INPUT_POST, 'localisation', FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = 'UPDATE utilisateur SET nom = :nom, prenom = :prenom, pseudo = :pseudo, poste = :poste, niveau = :niveau, tel = :tel, email = :email, role = :_role, localisation = :localisation, description = :description WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':pseudo', $pseudo);
$stmt->bindParam(':poste', $poste);
$stmt->bindParam(':niveau', $niveau);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':_role', $role);
$stmt->bindParam(':localisation', $localisation);
$stmt->bindParam(':description', $description);

$stmt->bindParam(':id', $id);

$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->query('SELECT * FROM utilisateur WHERE id = ' . $id);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user_info'] = $user;

$_SESSION['modif_success'] = "Votre compte a été modifié avec succès !";
header("location: ../profile");

?>