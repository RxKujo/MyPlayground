<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once $includesConfig . "config.php";

$user = $_SESSION['user_info'];

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';


include_once "navbar/header.php";

?>

<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>
    <div class="container-fluid px-0" id="content">

    </div>
</div>