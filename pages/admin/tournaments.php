<?php
// filepath: c:\xampp\htdocs\MyPlayground\pages\admin\tournaments.php

include_once '../../includes/global/session.php';
include_once '../../includes/config/config.php';
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
        <button class="btn btn-success mb-3 open-new-modal">Ajouter un tournoi</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tournamentsShowing">
                <?php foreach ($tournaments as $t): ?>
                <tr>
                    <td><?= $t['id_tournoi'] ?></td>
                    <td><?= htmlspecialchars($t['nom']) ?></td>
                    <td>
                        <?php
                        if (!empty($t['date_tournoi'])) {
                            $date = date('d/m/Y H:i', strtotime($t['date_tournoi']));
                            echo htmlspecialchars($date);
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm open-edit-modal"
                                data-id="<?= $t['id_tournoi'] ?>"
                                data-nom="<?= htmlspecialchars($t['nom'], ENT_QUOTES) ?>"
                                data-date_tournoi="<?= $t['date_tournoi'] ?>"
                        >
                        Modifier
                        </button>
                        <button class="btn btn-danger btn-sm open-delete-modal"
                                data-id="<?= $t['id_tournoi'] ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="dynamic-modal-container"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dynamic-modal-container');

    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('open-edit-modal')) {
            const id = e.target.dataset.id;
            const nom = e.target.dataset.nom;
            let date_tournoi = e.target.dataset.date_tournoi;

            let dateValue = '';
            if (date_tournoi && date_tournoi !== 'null') {
                dateValue = date_tournoi.replace(' ', 'T').slice(0, 16);
            }

            container.innerHTML = `
                <div class="modal fade" id="editTournamentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/edit_tournament_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier un tournoi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_tournoi" value="${id}">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="${nom}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Date</label>
                                        <input class="form-control" name="date_tournoi" type="datetime-local" value="${dateValue}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('editTournamentModal'));
            modal.show();
        }

        // Supprimer
        if (e.target.classList.contains('open-delete-modal')) {
            const id = e.target.dataset.id;

            container.innerHTML = `
                <div class="modal fade" id="deleteTournamentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/delete_tournament_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer un tournoi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer ce tournoi ?
                                    <input type="hidden" name="id_tournoi" value="${id}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('deleteTournamentModal'));
            modal.show();
        }

        if (e.target.classList.contains('open-new-modal')) {
            container.innerHTML = `
                <div class="modal fade" id="newTournamentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/add_tournament_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter un tournoi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label>Date</label>
                                        <input class="form-control" name="date_tournoi" type="datetime-local" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('newTournamentModal'));
            modal.show();
        }
    });
});
</script>

<?php include_once $includesGlobal . "footer.php";