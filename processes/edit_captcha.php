<?php

include_once "../includes/config/config.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


if (!$id && isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
}

if (!$id) {
    header("Location: ../pages/admin/captchas.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   
    $stmt = $pdo->prepare("UPDATE captcha SET captcha_question = :question WHERE id_captcha = :id");
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

   
    $stmt = $pdo->prepare("UPDATE captcha_reponse SET reponse = :reponse WHERE id_captcha = :id");
    $stmt->bindParam(':reponse', $reponse);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: ../pages/admin/captchas.php");
    exit();
}


$stmt = $pdo->prepare("SELECT c.captcha_question, r.reponse FROM captcha c JOIN captcha_reponse r ON c.id_captcha = r.id_captcha WHERE c.id_captcha = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$captcha = $stmt->fetch();

if (!$captcha) {
    echo "Captcha introuvable.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un captcha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Modifier le captcha</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question" class="form-control" value="<?= htmlspecialchars($captcha['captcha_question']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Réponse</label>
            <input type="text" name="reponse" class="form-control" value="<?= htmlspecialchars($captcha['reponse']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="../pages/admin/captchas.php" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>