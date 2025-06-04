<?php

include_once '../../includes/global/session.php';

include_once $includesConfig . "config.php";

$sql = 'SELECT id, question, reponse FROM captcha';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$captchas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <a href="../../processes/add_captcha_process.php" class="btn btn-success mb-3">Ajouter un captcha</a>
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
                <?php foreach ($captchas as $captcha): 
                    $id = $captcha['id'];
                    $question = $captcha['question'];
                    $reponse = $captcha['reponse'];
                ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $question ?></td>
                    <td><?= $reponse ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm open-edit-modal"
                                data-id="<?= $id ?>"
                                data-question="<?= $question ?>"
                                data-reponse="<?= $reponse ?>"
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

    // Modifier
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('open-edit-modal')) {
            const id = e.target.dataset.id;
            const question = e.target.dataset.question;
            const reponse = e.target.dataset.reponse;

            container.innerHTML = `
                <div class="modal fade" id="editCaptchaModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/edit_captcha_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier un captcha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="${id}">
                                    <div class="mb-3">
                                        <label>Question</label>
                                        <input class="form-control" name="question${id}" type="text" value="${question}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Réponse</label>
                                        <input class="form-control" name="reponse${id}" type="text" value="${reponse}">
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

            const modal = new bootstrap.Modal(document.getElementById('editCaptchaModal'));
            modal.show();
        }

        // Supprimer
        if (e.target.classList.contains('open-delete-modal')) {
            const id = e.target.dataset.id;

            container.innerHTML = `
                <div class="modal fade" id="deleteCaptchaModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/delete_captcha_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer un captcha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer ce captcha ?
                                    <input type="hidden" name="id" value="${id}">
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

            const modal = new bootstrap.Modal(document.getElementById('deleteCaptchaModal'));
            modal.show();
        }
    });
});
</script>

<?php include_once $includesGlobal . "footer.php";


