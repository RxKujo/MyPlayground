<?php

include_once '../includes/global/session.php';

notLogguedSecurity("../../index.php");

$objet = filter_input(INPUT_POST, "objet", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$contenu = filter_input(INPUT_POST, "contenu", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id_envoyeur = filter_input(INPUT_POST, "id_sender", FILTER_VALIDATE_INT);
$envoyeur = filter_input(INPUT_POST, "sender", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$r = $pdo->query("SELECT email FROM newsletter");
$emails = $r->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("INSERT INTO newsletter_post (objet, contenu, id_envoyeur) VALUES (:objet, :contenu, :id_envoyeur)");
$stmt->execute([
    ':objet' => $objet,
    ':contenu' => $contenu,
    'id_envoyeur' => $id_envoyeur
]);

foreach($emails as $email) {
    sendMailMyPlayground($email['email'], $objet, $contenu);
}

header('location: ../admin/newsletter');
exit();

?>