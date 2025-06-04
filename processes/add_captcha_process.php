<?php

include_once "../includes/config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($question && $reponse) {
        
        $stmt = $pdo->prepare("INSERT INTO captcha (question, reponse) VALUES (:question, :reponse)");
        $stmt->execute([
            ':question' => $question,
            ':reponse' => $reponse
        ]);

        header("Location: ../admin/captchas");
        exit();
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

header('location: ../admin/captchas');
exit();
?>