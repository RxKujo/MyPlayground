<?php

$userRights = $user['droits'];
$userIsVerified = $user['is_verified'];

?>

<nav class="bg-light text-black p-3" style="width: 64px; min-height: 100vh;">
    <?php if ($userIsVerified == 0): ?>
        <div class="alert alert-warning text-center">
            <?= $exclamationOctagonFill ?>
        </div>
    <?php endif; ?>
    <ul id="sidebar-list" class="nav nav-pills flex-column justify-content-center">
        <li class="nav-item"><a class="nav-link text-black" href="home" data-page="home"><?= $houseFill ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="partners" data-page="partners"><?= $shareFill ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="matches" data-page="matches"><?= $dribbble ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="tournaments" data-page="tournaments"><?= $trophyFill ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="messages" data-page="messages"><?= $chatDotFill ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="profile" data-page="profile"><?= $personFill ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="teams" data-page="teams"><?= $personFill ?></a></li>
        <?php if ($userRights == 1): ?>
            <li class="nav-item"><a class="nav-link text-black" href="admin/dashboard"><?= $personFillGear ?></a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-black" href="settings" data-page="settings"><?= $gearFill ?></a></li>
        <li class="nav-item"><a class="nav-link text-black" href="disconnect" data-page="disconnect"><?= $openedDoorFill ?></a></li>
    </ul>
</nav>