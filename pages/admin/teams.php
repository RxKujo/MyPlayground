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
                <?php foreach ($teams as $team): 
                    $id = $team['id_equipe'];
                    $nom = $team['nom'];
                    $privee = $team['privee'];
                    $code = $team['code'];
                ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= htmlspecialchars($nom) ?></td>
                    <td><?= $privee ? "Oui" : "Non" ?></td>
                    <td><?= htmlspecialchars($code) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm open-edit-modal"
                                data-id="<?= $id ?>"
                                data-nom="<?= htmlspecialchars($nom, ENT_QUOTES) ?>"
                                data-privee="<?= $privee ?>"
                                data-code="<?= htmlspecialchars($code, ENT_QUOTES) ?>"
                        >
                        Modifier
                        </button>
                        <button class="btn btn-danger btn-sm open-delete-modal"
                                data-id="<?= $id ?>">
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
            const privee = e.target.dataset.privee;
            const code = e.target.dataset.code;

            container.innerHTML = `
                <div class="modal fade" id="editTeamModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/edit_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_equipe" value="${id}">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="${nom}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Privée</label>
                                        <select class="form-select" name="privee">
                                            <option value="0" ${privee == 0 ? 'selected' : ''}>Non</option>
                                            <option value="1" ${privee == 1 ? 'selected' : ''}>Oui</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Code (si privée)</label>
                                        <input class="form-control" name="code" type="text" value="${code}">
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

            const modal = new bootstrap.Modal(document.getElementById('editTeamModal'));
            modal.show();
        }

   
        if (e.target.classList.contains('open-delete-modal')) {
            const id = e.target.dataset.id;

            container.innerHTML = `
                <div class="modal fade" id="deleteTeamModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/delete_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cette équipe ?
                                    <input type="hidden" name="id_equipe" value="${id}">
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

            const modal = new bootstrap.Modal(document.getElementById('deleteTeamModal'));
            modal.show();
        }

  
        if (e.target.classList.contains('open-new-modal')) {
            container.innerHTML = `
                <div class="modal fade" id="newTeamModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/add_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label>Privée</label>
                                        <select class="form-select" name="privee">
                                            <option value="0">Non</option>
                                            <option value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Code (si privée)</label>
                                        <input class="form-control" name="code" type="text" value="">
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

            const modal = new bootstrap.Modal(document.getElementById('newTeamModal'));
            modal.show();
        }
    });
});
</script>

<?php include_once $includesGlobal . "footer.php";