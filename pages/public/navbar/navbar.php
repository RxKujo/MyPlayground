<?php

if (isset($_SESSION) and $_SESSION['user_id']) {
    $id = $_SESSION['user_id'];
} else {
    header('location: index.php');
    exit();
}

$sql = 'SELECT droits FROM utilisateur WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$userRights = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<nav class="bg-light text-black p-3" style="width: 280px; min-height: 100vh;">
    <ul id="sidebar-list" class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link text-black" href="home" data-page="home"><?= $houseFill ?> Accueil</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="partners" data-page="partners"><?= $shareFill ?> Trouver des coéquipiers</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="tournaments" data-page="tournaments"><?= $trophyFill ?> Tournois</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="profile" data-page="profile"><?= $personFill ?> Profil</a></li>
        <?php if ($userRights['droits'] == 1): ?>
            <li class="nav-item"><a class="nav-link text-black" href="admin/dashboard"><?= $personFillGear ?> Espace Administrateur</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-black" href="settings" data-page="settings"><?= $gearFill ?> Paramètres</a></li>
    </ul>
</nav>