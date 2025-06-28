<?php

include_once 'includes/global/session.php';
include_once 'includes/config/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("DELETE FROM newsletter WHERE email = ?");
        $stmt->execute([$email]);
        $deleted = $stmt->rowCount();

        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Désabonnement Newsletter</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-black text-white d-flex flex-column justify-content-center align-items-center vh-100">
            <div class="text-center">
                <?php if ($deleted): ?>
                    <h1 class="text-success mb-3">✅ Désabonnement réussi</h1>
                    <p>Votre adresse e-mail a bien été supprimée de la newsletter.</p>
                <?php else: ?>
                    <h1 class="text-warning mb-3">ℹ️ Adresse non trouvée</h1>
                    <p>Cette adresse e-mail n'est pas inscrite à la newsletter.</p>
                <?php endif; ?>
                <a href="/home" class="btn btn-outline-light mt-4">Retour à l'accueil</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Email invalide</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-black text-white d-flex flex-column justify-content-center align-items-center vh-100">
            <div class="text-center">
                <h1 class="text-danger mb-3">❌ Erreur</h1>
                <p>Adresse e-mail invalide.</p>
                <a href="/home" class="btn btn-outline-light mt-4">Retour à l'accueil</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Désabonnement Newsletter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-black text-white d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="text-danger mb-3">💔 Se désabonner</h1>
        <p>Entrez votre adresse e-mail pour vous désabonner de la newsletter de Myplayground.</p>
        <form action="/newsletter_unsubscribe.php" method="POST" class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2 mt-3">
            <input type="email" name="email" class="form-control bg-black text-white border-danger" placeholder="Votre adresse email" required style="max-width:220px;">
            <button type="submit" class="btn btn-danger fw-bold">Me désabonner</button>
        </form>
        <a href="/home" class="btn btn-outline-light mt-4">Retour à l'accueil</a>
    </div>
</body>
</html>