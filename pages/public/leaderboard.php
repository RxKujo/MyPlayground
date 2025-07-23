<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("/");

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : '';
$poste = isset($_GET['poste']) ? $_GET['poste'] : '';

$sql = "SELECT u.id, u.prenom, u.nom, u.pseudo, u.niveau, u.poste, u.ville_id, u.pfp, v.ville AS ville_nom, v.code_postal AS cp FROM utilisateur AS u JOIN villes_cp AS v ON v.id = u.ville_id WHERE u.id != :id";
$params = [':id' => $user['id']];

if ($niveau !== '' && $niveau !== '3') {
    $sql .= " AND niveau = :niveau";
    $params[':niveau'] = $niveau;
}

if ($poste !== '' && $poste !== '5') {
    $sql .= " AND poste = :poste";
    $params[':poste'] = $poste;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

function safe($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

?>

<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'settings';
        }
        include_once "navbar/navbar.php";
    ?>    

    <div class="container-fluid px-0" id="content">
    </div>
</div>
<?php include_once $includesGlobal . "footer.php"; ?>
