<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';


include_once "navbar/header.php";

?>

<div class="d-flex">
    <?php
        include_once "navbar/reducted_navbar.php";
    ?>
    <div class="container-fluid px-0 bg-dark bg-gradient" id="content">
        <div class="ps-4 d-flex gap-2 py-5">
            <div class="col-lg-3 bg-danger">
                <!-- Users -->
                <div class="row justify-content-between">
                    <h6 class="col">Messages</h6>
                    <div class="col">
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newGroup">
                                <?= $plusSquareFill ?>
                            </button>
    
                            <div class="modal fade" id="newGroup" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="#">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Créer une conversation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Nom du groupe</label>
                                                    <input class="form-control" name="nom" type="text" value="">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Avec:</label>
                                                    <input class="form-control" name="guests[]" type="text" placeholder="Tapez pour chercher...">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Envoyer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div id="conversation1" class="container">
                        <div class="row">
                            <div class="px-4 py-3 col-sm-2">
                                <img class="profile-img-small" src="/assets/public/img/morad.png" alt="">
                            </div>
                            <div class="col">
                                Nom
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 bg-warning">
                <!-- Messages -->
                 Bonjour
            </div>
        </div>
    </div>
</div>

<?php
include_once $includesGlobal . 'footer.php';
?>