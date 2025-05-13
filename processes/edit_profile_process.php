<?php


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ../index.php");
    exit();
}

if (isset($_SESSION) && $_SESSION['user_id']) {
    $id = $_SESSION['user_id'];
} else {
    header("location: ../index.php");
    exit();
}

include_once '../includes/config/config.php';

$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$poste = filter_input(INPUT_POST, 'poste', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$niveau = filter_input(INPUT_POST, 'niveau', FILTER_VALIDATE_INT);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$sql = 'UPDATE utilisateur SET nom = :nom, prenom = :prenom, pseudo = :pseudo, poste = :poste, niveau = :niveau, tel = :tel, email = :email, role = :role, adresse = :adresse, commentaire = :commentaire WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':pseudo', $pseudo);
$stmt->bindParam(':poste', $poste);
$stmt->bindParam(':niveau', $niveau);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':adresse', $adresse);
$stmt->bindParam(':commentaire', $commentaire);

$stmt->bindParam(':id', $id);

$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['success'] = 'Votre profil a été mis à jour avec succès.';
header("location: ../test.php");

?>