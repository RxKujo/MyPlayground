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
        <button class="btn btn-sm btn-primary me-1 open-edit-modal" data-bs-toggle="modal" data-bs-target="#createMatch">
            <i class="bi bi-plus-circle"></i> Nouveau match
        </button>

        <div class="modal fade" id="createMatch" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-dark">
                    <form method="POST" action="../../processes/create_match_process.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Créer un match</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="nom_match">Nom du match</label>
                                <input class="form-control" id="nom_match" name="nom_match" type="text" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="localisation">Localisation</label>
                                <input class="form-control" id="localisation" name="localisation" type="text" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="date">Date</label>
                                <input class="form-control" id="date" name="date" type="date" required />
                            </div>

                                <div class="mb-3">
                                <label class="form-label" for="debut">Heure de début</label>
                                <input class="form-control" id="debut" name="debut" type="time" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="fin">Heure de fin</label>
                                <input class="form-control" id="fin" name="fin" type="time" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="categorie">Catégorie</label>
                                <select class="form-select" id="categorie" name="categorie" aria-label="">
                                    <option value="0" selected>1v1</option>
                                    <option value="1">2v2</option>
                                    <option value="2">3v3</option>
                                    <option value="3">4v4</option>
                                    <option value="4">5v5</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="niveau_min">Niveau minimum requis</label>
                                <select class="form-select" id="niveau_min" name="niveau_min">
                                    <option value="0">Débutant</option>
                                    <option value="1">Intermédiaire</option>
                                    <option value="2">Avancé</option>
                                    <option value="3">Pro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="commentaire">Message ou commentaire</label>
                                <div class="form-floating">
                                    <textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"></textarea>
                                    <label for="commentaire">Indications supplémentaires</label>
                                </div>
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
