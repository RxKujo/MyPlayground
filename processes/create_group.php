<?php
include_once '../includes/global/session.php';
include_once '../includes/config.php';

if (!isset($_SESSION['user_info'])) {
    http_response_code(403);
    exit('Non autorisé');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomGroupe = $_POST['nom'] ?? null;
    $guestsRaw = $_POST['guests'] ?? [];

    $nomGroupe = trim($nomGroupe);
    $creatorId = $_SESSION['user_info']['id'];

    if (!$nomGroupe || empty($guestsRaw)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header("Location: ../messages");
        exit();
    }

    
    $stmt = $pdo->prepare("INSERT INTO groupe_discussion (nom, id_createur) VALUES (:nom, :utilisateur)");
    $stmt->execute(['nom' => $nomGroupe, 'utilisateur' => $creatorId]);
    $groupId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO participation_groupe (id_groupe, id_utilisateur) VALUES (:groupe, :utilisateur)");
    $stmt->execute(['groupe' => $groupId, 'utilisateur' => $creatorId]);

    foreach ($guestsRaw as $pseudo) {
        $pseudo = trim($pseudo);
        if ($pseudo === "") continue;

        $stmtUser = $pdo->prepare("SELECT id FROM utilisateur WHERE pseudo = :pseudo LIMIT 1");
        $stmtUser->execute(['pseudo' => $pseudo]);
        $user = $stmtUser->fetch();

        if ($user) {
            $stmt->execute(['groupe' => $groupId, 'utilisateur' => $user['id']]);
        }
    }

    header("Location: ../messages");
    exit();
}
