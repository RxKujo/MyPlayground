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
            <tbody>
                <?php 
                    foreach ($captchas as $captcha): 
                        $id = $captcha['id'];
                        $question = $captcha['question'];
                        $reponse = $captcha['reponse'];
                ?>

                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $question ?></td>
                        <td><?= $reponse ?></td>
                        <td>
                            <span>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCaptcha<?= $id ?>">
                                    Modifier
                                </button>
                                
                                <div class="modal fade" id="editCaptcha<?= $id ?>" tabindex="-1" aria-labelledby="editCaptchaLabel<?= $id ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editCaptchaLabel<?= $id ?>">Modifier un captcha</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="../../processes/edit_captcha_process.php">
                                                <div class="modal-body">
                                                        <input class="form-control" name="id" type="hidden" value="<?= $id ?>" />
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label" for="question<?= $id ?>">Question</label>
                                                            <input class="form-control" id="question<?= $id ?>" name="question<?= $id ?>" type="text" value="<?= $question ?>"/>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="reponse<?= $id ?>">Réponse</label>
                                                            <input class="form-control" id="reponse<?= $id ?>" name="reponse<?= $id ?>" type="text" value="<?= $reponse ?>"/>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Sauvegarder les changements</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <span>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delCaptcha<?= $id ?>">
                                    Supprimer
                                </button>
                                
                                <div class="modal fade" id="delCaptcha<?= $id ?>" tabindex="-1" aria-labelledby="delCaptchaLabel<?= $id ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="delCaptchaLabel<?= $id ?>">Supprimer un captcha</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="../../processes/delete_captcha_process.php">
                                                <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer ce captcha ?
                                                        <input class="form-control" name="id" type="hidden" value="<?= $id ?>" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-primary">Supprimer le captcha</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php";


