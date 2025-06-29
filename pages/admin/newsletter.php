<?php 

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once $assetsShared . 'icons/icons.php';
include_once $includesAdmin . 'header.php';

?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php'; ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Gestion de la newsletter</h2>
        <button class="btn btn-success mb-3 open-new-modal" data-bs-toggle="modal" data-bs-target="#newNewsModal">Ajouter une news</button>
        <div class="modal fade" id="newNewsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../../processes/create_news_process.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Créer une news</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Objet</label>
                                <input class="form-control" name="objet" type="text" required>
                            </div>
                            <div class="mb-3">
                                <label>Contenu</label>
                                <input class="form-control" name="contenu" required>
                            </div>
                            <div>
                                <input class="form-control" name="sender" value="<?= $_SESSION['user_info']['pseudo'] ?>" disabled>
                                <input type="hidden" name="id_sender" value="<?= $_SESSION['user_info']['id'] ?>" >
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

        <input
            id="searchNewsletterField"
            type="text"
            class="form-control my-3"
            placeholder="Rechercher un post..."
        />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Objet</th>
                    <th>Corps</th>
                    <th>Date de publication</th>
                </tr>
            </thead>
            <tbody id="newsletterGShowing">
                
            </tbody>
        </table>
    </div>
</div>

<div id="dynamic-modal-container"></div>

<script src="/assets/admin/js/dynamicNewsletter.js"></script>

<?php include_once $includesGlobal . "footer.php"; ?>