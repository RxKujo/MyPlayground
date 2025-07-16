<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once $includesAdmin . "header.php";
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>
    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <?php
            if (isset($_SESSION['modif_success'])) {    
                    alertMessage($_SESSION['modif_success'], 0);
                    $_SESSION['modif_success'] = null;
            }
        ?>
        <h2>Gestion des Captchas</h2>
        <button class="btn btn-success mb-3 open-new-modal" data-bs-toggle="modal" data-bs-target="#newCaptcha">Ajouter un captcha</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Réponse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="captchasShowing">
            </tbody>
        </table>
    </div>
</div>
<div id="dynamic-modal-container"></div>

<script src="/assets/admin/js/dynamicCaptchaModal.js"></script>

<?php include_once $includesGlobal . "footer.php";


