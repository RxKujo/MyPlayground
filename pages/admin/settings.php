<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once $includesAdmin . "header.php";

?>

<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Paramètres</h2>
        <p>Gérez ici les paramètres de l'application.</p>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>