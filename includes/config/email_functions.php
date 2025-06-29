<?php

include_once $root . 'vendor/autoload.php';

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
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);

       
        $verification_link = $_SERVER['HTTP_HOST'] . '/verify.php?token=' . $verification_token;

        $mail->Subject = 'Vérifiez votre adresse email';
        $mail->Body    = "Bonjour $prenom,<br><br>Merci de vous être inscrit. Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse email : <br><br><a href='$verification_link'>$verification_link</a><br><br>Merci !";

        try {
            $mail->send();
        } catch (Exception $e) {
            return $e;
        }

        return true;
    } catch (Exception $e) {
        return $e; 
    }
}

function sendMail(
    string $emailFrom, string $emailTo,
    string $objet, string $contenu
    ) {

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

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom($emailFrom);
        $mail->addAddress($emailTo);

        $mail->Subject = $objet;
        $mail->Body    = $contenu;

        $mail->send();
        return true;

        return true;
    } catch (Exception $e) {
        return false; 
    }
}