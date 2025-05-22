<?php

include_once "../includes/config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($question && $reponse) {
        
        $stmt = $pdo->prepare("INSERT INTO captcha (captcha_question) VALUES (:question)");
        $stmt->bindParam(':question', $question);
        $stmt->execute();
        $id_captcha = $pdo->lastInsertId();

    
        $stmt = $pdo->prepare("INSERT INTO captcha_reponse (id_captcha, reponse) VALUES (:id_captcha, :reponse)");
        $stmt->bindParam(':id_captcha', $id_captcha);
        $stmt->bindParam(':reponse', $reponse);
        $stmt->execute();

        header("Location: ../pages/admin/captchas.php");
        exit();
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un captcha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Ajouter un captcha</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Réponse</label>
            <input type="text" name="reponse" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="../pages/admin/captchas.php" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>