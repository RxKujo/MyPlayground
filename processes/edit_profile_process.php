<?php

include_once('../includes/global/session.php');

notLogguedSecurity("/");

$id = $_SESSION['user_id'];
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

$stmt = $pdo->prepare("SELECT id FROM ville WHERE id = ?");
$stmt->execute([$ville_id]);

if ($stmt->rowCount() === 0) {
    $_SESSION['error'] = "Ville invalide.";
    header("location: ../edit-profile");
    exit();
}



$sql = 'UPDATE utilisateur SET nom = :nom, prenom = :prenom, pseudo = :pseudo, poste = :poste, niveau = :niveau, tel = :tel, email = :email, ville_id = :ville_id, role = :_role, description = :description WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':pseudo', $pseudo);
$stmt->bindParam(':poste', $poste, PDO::PARAM_INT);
$stmt->bindValue(':niveau', $niveau, is_null($niveau) ? PDO::PARAM_NULL : PDO::PARAM_INT);
$stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':_role', $role, PDO::PARAM_INT);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':ville_id', $ville_id, PDO::PARAM_INT);

$stmt->bindParam(':id', $id);

$stmt->bindParam(':id', $id);

if (!$stmt->execute()) {
    echo "Erreur lors de l'exécution :";
    var_dump($stmt->errorInfo());
    exit;
}

if ($stmt->rowCount() === 0) {
    echo "Aucune ligne modifiée. Soit les données n'ont pas changé, soit l'ID est invalide.";
    exit;
}


$stmt = $pdo->prepare('
    SELECT u.*, v.nom AS ville_nom 
    FROM utilisateur u
    LEFT JOIN ville v ON u.ville_id = v.id
    WHERE u.id = :id
');
$stmt->execute([':id' => $id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user_info'] = $user;

$_SESSION['modif_success'] = "Votre compte a été modifié avec succès !";
header("location: ../profile");

?>