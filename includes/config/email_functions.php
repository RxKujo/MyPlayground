<?php
require_once '../vendor/autoload.php';
include_once 'variables.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

function sendVerificationEmail(string $email, string $prenom, string $verification_token) {
    global $root;

    $dotenv = Dotenv::createImmutable($root);
    $dotenv->load();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($email, $prenom);

        $mail->isHTML(true);

        // Create verification link
        $verification_link = $_SERVER['HTTP_HOST'] . '/verify.php?token=' . $verification_token;

        $mail->Subject = htmlspecialchars('Vérifiez') . 'votre adresse email';
        $mail->Body    = htmlspecialchars("Bonjour $prenom,<br><br>Merci de vous être inscrit. Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse email :") . "<br><br><a href='$verification_link'>$verification_link</a><br><br>Merci !";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;  // Return false if sending fails
    }
}
