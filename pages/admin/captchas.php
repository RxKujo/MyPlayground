<?php
// filepath: c:\xampp\htdocs\MyPlayground\pages\admin\captchas.php
session_start();

include_once "../../includes/config/variables.php";
include_once $includesConfig . "config.php";
include_once $includesConfig . "functions.php";

$sql = 'SELECT c.id_captcha, c.captcha_question, r.reponse
        FROM captcha c
        JOIN captcha_reponse r ON c.id_captcha = r.id_captcha
        ORDER BY c.id_captcha DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$captchas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Captchas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>
    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Gestion des Captchas</h2>
        <a href="../../processes/add_captcha.php" class="btn btn-success mb-3">Ajouter un captcha</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Réponse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($captchas as $captcha): ?>
                    <tr>
                        <td><?= $captcha['id_captcha'] ?></td>
                        <td><?= htmlspecialchars($captcha['captcha_question']) ?></td>
                        <td><?= htmlspecialchars($captcha['reponse']) ?></td>
                        <td>
                            <a href="../../processes/edit_captcha.php?id=<?= $captcha['id_captcha'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="../../processes/delete_captcha.php?id=<?= $captcha['id_captcha'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce captcha ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

