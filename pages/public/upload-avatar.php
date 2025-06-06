<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once $includesConfig . 'config.php';

$userId = $_SESSION['user_id'];

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../assets/uploads/avatars/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $fileName = 'avatar_' . $userId . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
        $relativePath = $filePath; // Pour simplifier

        // Enregistrer en base de données
        $stmt = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        $stmt->execute([
            'avatar' => $relativePath,
            'id' => $userId
        ]);
    }
}

header('Location: profile.php');
exit;
