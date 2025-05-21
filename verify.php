<?php
require '../includes/config/config.php';

$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($token) {
    $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email_verification_token = :token AND is_verified = 0");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $update = $pdo->prepare("UPDATE utilisateur SET is_verified = 1, email_verification_token = NULL WHERE id = :id");
        $update->bindParam(':id', $user['id']);
        $update->execute();
        echo "Email vérifié avec succès. Vous pouvez maintenant vous connecter.";
    } else {
        echo "Lien de vérification invalide ou déjà utilisé.";
    }
} else {
    echo "Aucun token fourni.";
}
