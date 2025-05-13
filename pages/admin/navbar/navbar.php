<?php

include_once '../../assets/shared/icons/icons.php';



?>

<nav class="bg-dark text-white p-3" style="width: 280px; min-height: 100vh;">
    <h4>Admin Dashboard</h4>
    <ul id="sidebar-list" class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link text-white" href="dashboard" data-page="dashboard"><?= $houseFill ?> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="users" data-page="users"><?= $personFill ?> Users</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="captchas" data-page="captchas"><?= $checkCircle ?> Captchas</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="settings" data-page="settings"><?= $gearFill ?> Settings</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="disconnect" data-page="disconnect"><?= $openedDoorFill ?> Disconnect</a></li>
    </ul>
</nav>