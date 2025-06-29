<?php


include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");


$sql = 'SELECT id_equipe, nom, privee, code FROM equipe';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h2>Gestion des équipes</h2>
        <button class="btn btn-success mb-3 open-new-modal">Ajouter une équipe</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Privée</th>
                    <th>Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="teamsShowing">
            </tbody>
        </table>
    </div>
</div>

<div id="dynamic-modal-container"></div>

<script src="/assets/admin/js/dynamicTeamModal.js"></script>

<?php include_once $includesGlobal . "footer.php";