<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$sql = 'SELECT id_tournoi, nom, date_tournoi FROM tournoi';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h2>Gestion des tournois</h2>
        <button class="btn btn-success mb-3 open-new-modal" data-bs-toggle="modal" data-bs-target="#createMatch">Ajouter un tournoi</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Âge min</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tournamentsShowing">
            </tbody>
        </table>
    </div>
</div>

<div id="dynamic-modal-container"></div>

<script src="/assets/admin/js/dynamicTournamentModal.js"></script>

<?php include_once $includesGlobal . "footer.php";