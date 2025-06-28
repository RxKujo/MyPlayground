<?php


include_once 'includes/global/session.php';
include_once 'includes/config/config.php';

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM newsletter WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetchColumn() == 0) {
                $stmt = $pdo->prepare("INSERT INTO newsletter (email) VALUES (?)");
                $stmt->execute([$email]);
                header("Location: confirmation.html");
                exit;
            } else {
                // Déjà inscrit : page stylée Bootstrap
                ?>
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <title>Déjà inscrit</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body class="bg-black text-white d-flex flex-column justify-content-center align-items-center vh-100">
                    <div class="text-center">
                        <h1 class="text-warning mb-3">🚫 Déjà inscrit</h1>
                        <p>Cette adresse e-mail est déjà inscrite à la newsletter de Myplayground.</p>
                        <a href="/home" class="btn btn-outline-light mt-3">Retour à l'accueil</a>
                    </div>
                </body>
                </html>
                <?php
                exit;
            }
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
                    <a href="/home" class="btn btn-outline-light mt-3">Retour à l'accueil</a>
                </div>
            </body>
            </html>
            <?php
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
    exit;
}