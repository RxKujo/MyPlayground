<?php


include_once '../includes/config/config.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    echo "ID captcha manquant ou invalide.";
    exit();
}

try {
    $stmt = $pdo->prepare('DELETE FROM captcha WHERE id = :id');
    $stmt->execute([
        ':id' => $id
    ]);

} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    exit();
}

header("Location: ../admin/captchas");
exit();