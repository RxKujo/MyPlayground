<?php

$pageFrom = '../admin/captchas';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ' . $pageFrom);
    exit();
}

include_once "../includes/config/config.php";

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (is_null($id)) {
    header('location: ' . $pageFrom);
    exit();
}


$question = filter_input(INPUT_POST, 'question' . $id, FILTER_SANITIZE_SPECIAL_CHARS);
$reponse = filter_input(INPUT_POST, 'reponse' . $id, FILTER_SANITIZE_SPECIAL_CHARS);

$stmt = $pdo->prepare("SELECT question FROM captcha WHERE id = :id");
$stmt->execute([
    ':id' => $id
]);
$captcha = $stmt->fetch();

if (!$captcha) {
    $_SESSION['error'] = 'Erreur dans la modification de captcha: Captcha non trouvé';
    header('location: ' . $pageFrom);
    exit();
}

$stmt = $pdo->prepare("UPDATE captcha SET question = :question, reponse = :reponse WHERE id = :id");
$stmt->execute([
    ':id' => $id,
    ':question' => $question,
    ':reponse' => $reponse
]);

$_SESSION['modif_success'] = "Le captcha a été modifié avec succès !";
header('location: ' . $pageFrom);
exit();

?>

