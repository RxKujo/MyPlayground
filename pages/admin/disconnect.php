<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once "../../includes/admin/header.php";

?>

<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Disconnect</h2>
        <p>Do you want to disconnect ?</p>
        <span>
            <form method='post' action='../../redirects/dc.php' id='settings-form'>
                <input type='submit' name='disconnect' class='btn btn-primary mt-3' id='disconnect-button' value='Disconnect'/>
            </form>
        </span>
    </div>
</div>

<?php include_once "../../includes/global/footer.php"; ?>