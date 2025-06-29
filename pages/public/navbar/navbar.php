<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user_info'] ?? null;

$userRights = $user['droits'] ?? 0;
$userIsVerified = $user['is_verified'] ?? 0;

include_once '../../assets/shared/icons/icons.php';
?>

<nav class="bg-light text-black p-3" style="width: 280px; min-height: 100vh;">
    <?php if ($userIsVerified == 0): ?>
        <div class="alert alert-warning">
            <span>
                <?= $exclamationOctagonFill ?>
            </span>
            <div>
                <p class="mb-0">Vous n'êtes pas vérifié !</p>
                <p class="mb-0">Veuillez vérifier votre boite mail.</p>
            </div>
        </div>
    <?php endif; ?>
    <ul id="sidebar-list" class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link text-black" href="home" data-page="home"><?= $houseFill ?> Accueil</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="partners" data-page="partners"><?= $shareFill ?> Trouver des coéquipiers</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="matches" data-page="matches"><?= $dribbble ?> Matchs</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="tournaments" data-page="tournaments"><?= $trophyFill ?> Tournois</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="messages" data-page="messages"><?= $chatDotFill ?> Messages</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="profile" data-page="profile"><?= $personFill ?> Profil</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="teams" data-page="teams"><?= $personFill ?> Équipes</a></li>
        <?php if ($userRights == 1): ?>
            <li class="nav-item"><a class="nav-link text-black" href="admin/dashboard"><?= $personFillGear ?> Espace Administrateur</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-black" href="actu" data-page="actu"><?= $newspaperFill ?> Actu NBA</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="settings" data-page="settings"><?= $gearFill ?> Paramètres</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="disconnect" data-page="disconnect"><?= $openedDoorFill ?> Se déconnecter</a></li>
    </ul>
</nav>
