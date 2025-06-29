<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];
include_once $includesAdmin . "header.php";
include_once $assetsShared . 'icons/icons.php';

if (isset($_POST['actualiser'])) {
    try {
        $pdo->query("
            UPDATE `match` m
            JOIN reserver r ON r.id_match = m.id_match
            SET m.statut = 'termine'
            WHERE m.statut = 'en_attente'
              AND (
                r.date_reservation < CURDATE()
                OR (r.date_reservation = CURDATE() AND r.heure_fin < CURTIME())
            )
        ");
        $_SESSION['modif_success'] = "Statuts mis à jour.";
        header("Location: ../admin/matches");
        exit;
    } catch (PDOException $e) {
        $error = "Erreur lors de l'actualisation des statuts.";
    }
}
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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Gestion des matchs</h2>
            <form method="POST" class="d-inline">
                <button type="submit" name="actualiser" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-repeat"></i> Actualiser les statuts
                </button>
            </form>
        </div>

        <button class="btn btn-sm btn-primary me-1 open-new-modal" data-bs-toggle="modal" data-bs-target="#createMatch">
            <i class="bi bi-plus-circle"></i> Nouveau match
        </button>

        

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
