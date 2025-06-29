<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];
include_once $includesAdmin . "header.php";
include_once $assetsShared . 'icons/icons.php';

?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <?php
        if (isset($_SESSION['modif_success'])) {
            alertMessage($_SESSION['modif_success'], 0);
            $_SESSION['modif_success'] = null;
        }

        if (!empty($error)) {
            echo "<div class='alert alert-danger'>Erreur : " . htmlspecialchars($error) . "</div>";
        }
        ?>

        <h2>Gestion des matchs</h2>
        <a href="../create_match" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Nouveau match
        </a>

            <div id="nomatch" class="text-muted text-center"></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Terrain</th>
                            <th>Localisation</th>
                            <th>Statut</th>
                            <th>Message</th>
                            <th>Créateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="matchesShowing">
                    </tbody>
                </table>
            </div>
    </div>
</div>

<div id="dynamic-modal-container"></div>

<script src="/assets/admin/js/dynamicMatchModal.js"></script>

<?php include_once $includesGlobal . "footer.php"; ?>
