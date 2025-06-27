<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_info'])) {
    header("Location: ../../index.php");
    exit();
}

require_once '../../includes/db_connect.php'; 
$user = $_SESSION['user_info'];
$id_createur = $user['id']; // 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: create_team.php");
    exit();
}

$nom_equipe     = trim($_POST['nom_equipe'] ?? '');
$description    = trim($_POST['description'] ?? '');
$categorie      = $_POST['categorie'] ?? '';
$categorie_age  = $_POST['categorie_age'] ?? '';
$ville          = trim($_POST['ville'] ?? '');
$niveau_min     = $_POST['niveau_min'] ?? '';
$privee         = isset($_POST['privee']) ? 1 : 0;
$code_equipe    = $privee ? trim($_POST['code_equipe'] ?? '') : null;
$commentaire    = trim($_POST['commentaire'] ?? '');


if (!$nom_equipe || !$categorie || !$categorie_age || !$ville || $niveau_min === '') {
    $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires.";
    header("Location: create_team.php");
    exit();
}


$logo_filename = null;
if (!empty($_FILES['logo']['name'])) {
    $upload_dir = '../../uploads/team_logos/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_tmp = $_FILES['logo']['tmp_name'];
    $file_name = basename($_FILES['logo']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed_ext)) {
        $_SESSION['error'] = "Le format du logo est invalide. Formats autorisés : JPG, JPEG, PNG, GIF.";
        header("Location: create_team.php");
        exit();
    }

    $logo_filename = uniqid('team_', true) . '.' . $file_ext;
    move_uploaded_file($file_tmp, $upload_dir . $logo_filename);
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO equipes (
            nom_equipe, description, categorie, categorie_age,
            ville, niveau_min, privee, code_equipe,
            commentaire, logo, id_createur, date_creation
        )
        VALUES (
            :nom_equipe, :description, :categorie, :categorie_age,
            :ville, :niveau_min, :privee, :code_equipe,
            :commentaire, :logo, :id_createur, NOW()
        )
    ");

    $stmt->execute([
        ':nom_equipe'    => $nom_equipe,
        ':description'   => $description,
        ':categorie'     => $categorie,
        ':categorie_age' => $categorie_age,
        ':ville'         => $ville,
        ':niveau_min'    => $niveau_min,
        ':privee'        => $privee,
        ':code_equipe'   => $code_equipe,
        ':commentaire'   => $commentaire,
        ':logo'          => $logo_filename,
        ':id_createur'   => $id_createur,
    ]);

    $_SESSION['success'] = "L'équipe a bien été créée.";
    header("Location: create_team.php");

} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la création de l’équipe : " . $e->getMessage();
    header("Location: create_team.php");
    exit();
}
