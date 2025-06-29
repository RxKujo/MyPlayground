<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];
$pfpSrc = showPfp($pdo, $user);

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

$discussions = getAllDiscussionsNames($pdo, $user['id']);

?>

<script>const user_id = <?= $user['id'] ?>;</script>

<div class="d-flex">
    <?php include_once "navbar/reducted_navbar.php"; ?>

    <div class="container-fluid px-0" id="content">
        <div class="row gx-0" style="height: 100vh;">
            <div class="col-lg-3 border-end bg-white d-flex flex-column p-3" style="height: 100vh; overflow-y: auto;">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Messages</h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newGroup">
                            <?= $plusSquareFill ?>
                        </button>
                    </div>
                    <input id="searchUser" type="text" class="form-control mb-2" placeholder="Rechercher un utilisateur...">
                    <div id="searchResults" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
                </div>

                <div class="list-group">
                    <?php 
                        foreach ($discussions as $discussion):
                            $interlocutor = getFirstUserInDiscussion($pdo, $discussion['id_groupe'], $user['id']);
                            if (!$interlocutor) {
                                continue;
                            }
                    ?>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3 mb-3 discussion-link" data-id="<?= $discussion['id_groupe'] ?>">
                            <img src="<?= showPfpOffline($interlocutor) ?>" class="rounded-circle" width="48" height="48" alt="">
                            <div class="d-flex flex-column">
                                <strong><?= $discussion['nom'] ?></strong>
                                <small class="text-muted"><?= getMessage($pdo, $discussion['id_dernier_message'])['message'] ?? "Envoyez votre premier message !"?></small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-9 d-flex flex-column bg-light" style="height: 100vh;">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <img hidden="" id="interlocutor-pfp" src="" class="rounded-circle" width="48" height="48" alt="interlocutor-pfp">
                        <div>
                            <strong id="interlocutor-name"></strong>
                            <div id="interlocutor-status" class="text-muted small"></div>
                        </div>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm">...</button>
                </div>
                <div class="flex-grow-1 overflow-auto p-4" style="background-color: #f9f9f9;" id="message-container">
                    <div class="d-flex flex-column gap-3"></div>
                </div>
                <div class="border-top p-3 bg-white">
                    <div class="input-group">
                        <input id="input-message-field" type="text" name="message" class="form-control" placeholder="Écrire un message..." required>
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newGroup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title">Créer une conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nom du groupe</label>
                    <input id="groupName" class="form-control" name="nom" type="text">
                </div>
                <div class="mb-3">
                    <label>Avec :</label>
                    <div id="guests-container" class="mb-2 d-flex flex-wrap gap-2"></div>
                    <input type="text" id="guestInput" class="form-control" placeholder="Entrez un pseudo...">
                    <ul id="suggestions" class="list-group position-absolute z-3 w-100"></ul>
                    <input type="hidden" name="guests[]" id="hiddenGuests">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Fermer</button>
                <button id="submitGroup" class="btn btn-primary" type="submit">Créer</button>
            </div>
        </div>
    </div>
</div>

<script>
  
</script>

<style>
  #suggestions {
    top: calc(100% + 2px);
    max-height: 200px;
    overflow-y: auto;
  }
</style>




<?php include_once $includesGlobal . 'footer.php'; ?>