<?php


?>

<nav class="bg-light text-black p-3" style="width: 280px; min-height: 100vh;">
    <ul id="sidebar-list" class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link text-black" href="home" data-page="home"><?= $houseFill ?> Accueil</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="partners" data-page="partners"><?= $shareFill ?> Trouver des coéquipiers</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="tournaments" data-page="tournaments"><?= $trophyFill ?> Tournois</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="profile" data-page="profile"><?= $personFill ?> Profil</a></li>
        <li class="nav-item"><a class="nav-link text-black" href="settings" data-page="settings"><?= $gearFill ?> Paramètres</a></li>
    </ul>
</nav>