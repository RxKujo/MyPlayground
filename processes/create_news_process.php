<?php

include_once '../includes/global/session.php';

notLogguedSecurity("../../index.php");

$objet = filter_input(INPUT_POST, "objet", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$contenu = filter_input(INPUT_POST, "contenu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$envoyeur = filter_input(INPUT_POST, "sender", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$r = $pdo->query("SELECT email FROM newsletter");
$emails = $r->fetchAll(PDO::FETCH_ASSOC);


foreach($emails as $email) {
    sendMailMyPlayground($email['email'], $objet, $contenu);
}

header('../admin/newsletter');
exit();

?>