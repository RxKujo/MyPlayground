<?php
include_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

include_once 'includes/global/session.php';
include_once 'includes/config/config.php';
include_once 'includes/config/email_functions.php';

$flash_message = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

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
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'];
            $mail->Password   = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $_ENV['MAIL_PORT'];
            $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
            $mail->addReplyTo($email, $name);

            $mail->isHTML(true);
            $mail->Subject = "Nouveau message de $name";
            $mail->Body    = "
                <p><strong>Nom :</strong> {$name}</p>
                <p><strong>Email :</strong> {$email}</p>
                <p><strong>Message :</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
            ";

            $mail->send();

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
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" />
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Votre email" required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
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
