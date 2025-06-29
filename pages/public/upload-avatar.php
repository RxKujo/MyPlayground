<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$userId = $_SESSION['user_id'] ?? null;

if (!$userId || !isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    header("Location: profile?error=upload_failed");
    exit;
}

$imageTmp = $_FILES['avatar']['tmp_name'];
$imageType = mime_content_type($imageTmp);

if (!in_array($imageType, ['image/jpeg', 'image/png', 'image/webp'])) {
    header("Location: profile?error=invalid_format");
    exit;
}

$imageData = file_get_contents($imageTmp);


$stmt = $pdo->prepare("UPDATE utilisateur SET pfp = :pfp WHERE id = :id");
$stmt->bindParam(':pfp', $imageData, PDO::PARAM_LOB);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: profile?success=avatar_uploaded");
} else {
    header("Location: profile?error=db_update_failed");
}
exit;
