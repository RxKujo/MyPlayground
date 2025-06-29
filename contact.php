<?php

include_once 'includes/global/session.php';

include_once $root . 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable($root);
$dotenv->load();


$flash_message = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);

$user = $_SESSION['user_info'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($user['nom'] . " " . $user['prenom'] ?? '');
    $email   = trim($user['email'] ?? '');
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
        } catch (PDOException $e) {
            $_SESSION['flash_message'] = "Erreur enregistrement : " . $e->getMessage();
            header("Location: contact.php");
            exit();
        }

        $mail = new PHPMailer(true);
        try {
            sendMail($email, $_ENV["MAIL_USERNAME"], "Contact", $message);

            $_SESSION['flash_message'] = "Votre message a bien été envoyé.";
            header("Location: contact.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['flash_message'] = "Message enregistré mais erreur envoi mail : {$mail->ErrorInfo}";
            header("Location: contact.php");
            exit();
        }
    } else {
        $_SESSION['flash_message'] = "Veuillez remplir tous les champs correctement.";
        header("Location: contact.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Contact - MyPlayground</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-black text-white d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="container text-center">
        <h1 class="mb-4">Contactez-nous</h1>

        <?php if ($flash_message): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($flash_message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="mx-auto" style="max-width:400px;">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Votre nom" required
                    value="<?= htmlspecialchars($user['nom'] . " " . $user['prenom'] ?? '') ?>" />
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Votre email" required
                    value="<?= htmlspecialchars($user['email'] ?? '') ?>" />
            </div>
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="4" placeholder="Votre message" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

        <a href="/home" class="btn btn-outline-light mt-4">Retour à l'accueil</a>
    </div>
</body>
</html>
