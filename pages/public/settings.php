<?php

include_once '../../includes/global/session.php';

include_once $includesConfig . "config.php";

$user = $_SESSION['user_info'];

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
    
    <div id="content">
        <span>
            <form method='post' action='../../deauth.php' id='settings-form'>
                <input type='submit' name='disconnect' class='btn btn-primary mt-3' id='disconnect-button' value='Disconnect'/>
            </form>
        </span>
    
        <span>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProfile">
                Clôturer le compte
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="deleteProfile" tabindex="-1" aria-labelledby="deleteProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteProfileLabel">Clôturer le compte</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <form method="POST" action="../../processes/delete_user_process.php">
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer votre compte ?
                                <input class="form-control" name="userspace" type="hidden" value="user" />
                                <input class="form-control" name="id" type="hidden" value="<?= $_SESSION['user_id'] ?>" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger">Je suis sûr</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </span>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
