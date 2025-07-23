<?php

include_once('../includes/global/session.php');

notLogguedSecurity("/");

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$poste = filter_input(INPUT_POST, 'poste', FILTER_VALIDATE_INT);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$ville_id = filter_input(INPUT_POST, 'ville_id', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$role = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_SPECIAL_CHARS);

$niveau = filter_input(INPUT_POST, 'niveau', FILTER_VALIDATE_INT);
$niveau = ($niveau === false || $niveau === null) ? null : $niveau;

$stmt = $pdo->prepare("SELECT id FROM villes_cp WHERE id = ?");
$stmt->execute([$ville_id]);
if ($stmt->rowCount() === 0) {
    $_SESSION['error'] = "Ville invalide.";
    header("location: ../pages/public/edit-profile.php");
    exit();
}



$sql = 'UPDATE utilisateur SET nom = :nom, prenom = :prenom, pseudo = :pseudo, poste = :poste, niveau = :niveau, tel = :tel, email = :email, ville_id = :ville_id, role = :_role, description = :description WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':pseudo', $pseudo);
$stmt->bindParam(':poste', $poste);
$stmt->bindValue(':niveau', $niveau, is_null($niveau) ? PDO::PARAM_NULL : PDO::PARAM_INT);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':_role', $role);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':ville_id', $ville_id, PDO::PARAM_INT);


$stmt->bindParam(':id', $id);

$stmt->execute();

$stmt = $pdo->prepare('
    SELECT u.*, v.ville AS ville_nom 
    FROM utilisateur u
    LEFT JOIN villes_cp v ON u.ville_id = v.id
    WHERE u.id = :id
');
$stmt->execute([':id' => $id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user_info'] = $user;

$_SESSION['modif_success'] = "Votre compte a été modifié avec succès !";
header("location: ../profile");

?>