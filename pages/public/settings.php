<?php

include_once '../../includes/config/variables.php';

include_once $includesConfig . "config.php";
include_once $includesPublic . "header.php";

?>

<?php
    include_once $assetsShared . 'icons/icons.php';
    include_once "navbar/header.php";
?>

<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'settings.php';
        }
        include_once "navbar/navbar.php";
    ?>    
    
    <div class="container-fluid px-0" id="content">
        <form method='post' action='../../deauth.php' id='settings-form'>
            <input type='submit' name='disconnect' class='btn btn-primary mt-3' id='disconnect-button' value='Disconnect'/>
        </form>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
