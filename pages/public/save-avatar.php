<?php
include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");


$user = $_SESSION['user_info'];

$position = getUserPosition($user);
$niveau = getUserLevel($user);

include_once $includesPublic . "header.php";

if (!isset($_SESSION['user_id']) || !isset($_POST['image'])) {
    http_response_code(400);
    echo "Utilisateur non connecté ou image manquante";
    exit;
}

$userId = $_SESSION['user_id'];
$imageData = $_POST['image'];

// Nettoyer le format data URL
if (preg_match('/^data:image\/png;base64,/', $imageData)) {
    $imageData = substr($imageData, strpos($imageData, ',') + 1);
    $imageData = base64_decode($imageData);

    if ($imageData === false) {
        http_response_code(400);
        echo "Erreur lors du décodage de l'image";
        exit;
    }

    // Mise à jour dans la base
    $stmt = $pdo->prepare("UPDATE utilisateur SET pfp = :img WHERE id = :id");
    $stmt->bindParam(':img', $imageData, PDO::PARAM_LOB);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Avatar enregistré avec succès.";
    } else {
        http_response_code(500);
        echo "Erreur lors de l'enregistrement.";
    }
} else {
    http_response_code(400);
    echo "Format de l'image incorrect.";
}
?>
