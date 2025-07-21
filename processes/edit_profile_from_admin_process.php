<?php

include_once('../includes/global/session.php');

notLogguedSecurity("/");

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$role = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT);
$localisation = filter_input(INPUT_POST, 'localisation', FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_SPECIAL_CHARS);

$niveau = filter_input(INPUT_POST, 'niveau', FILTER_VALIDATE_INT);
$niveau = ($niveau === false || $niveau === null) ? null : $niveau;

$poste = filter_input(INPUT_POST, 'poste', FILTER_VALIDATE_INT);
$poste = ($poste === false || $poste === null) ? null : $poste;

$ff = [
    $id, $nom, $prenom, $pseudo, $tel, $email, $role, $localisation, $description, $niveau, $poste
];


$sql = 'UPDATE utilisateur SET nom = :nom, prenom = :prenom, pseudo = :pseudo, poste = :poste, niveau = :niveau, tel = :tel, email = :email, role = :_role, localisation = :localisation, description = :description WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':pseudo', $pseudo);
$stmt->bindValue(':poste', $poste, is_null($poste) ? PDO::PARAM_NULL : PDO::PARAM_INT);
$stmt->bindValue(':niveau', $niveau, is_null($niveau) ? PDO::PARAM_NULL : PDO::PARAM_INT);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':_role', $role);
$stmt->bindParam(':localisation', $localisation);
$stmt->bindParam(':description', $description);

$stmt->bindParam(':id', $id);

$stmt->execute();

$_SESSION['modif_success'] = "Le compte a été modifié avec succès !";
header("location: ../admin/users");

?>