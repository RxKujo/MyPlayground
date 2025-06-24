<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];
$pfpSrc = showPfp($pdo, $user);

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";
?>

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
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                        <img src="<?= $pfpSrc ?>" class="rounded-circle" width="48" height="48" alt="">
                        <div class="d-flex flex-column">
                            <strong>Morad</strong>
                            <small class="text-muted">Dernier message...</small>
                        </div>
                    </a> 
                </div>
            </div>           
            <div class="col-lg-9 d-flex flex-column bg-light" style="height: 100vh;">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= $pfpSrc ?>" class="rounded-circle" width="48" height="48" alt="">
                        <div>
                            <strong>Morad</strong>
                            <div class="text-muted small">En ligne</div>
                        </div>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm">...</button>
                </div>           
                <div class="flex-grow-1 overflow-auto p-4" style="background-color: #f9f9f9;" id="message-container">
                    <div class="d-flex flex-column gap-3">
                        <div class="align-self-start bg-white px-3 py-2 rounded shadow-sm" style="max-width: 75%;">
                            Salut, comment ça va ?
                        </div>
                        <div class="align-self-end bg-primary text-white px-3 py-2 rounded shadow-sm" style="max-width: 75%;">
                            Tranquille et toi ?
                        </div>                       
                    </div>
                </div>               
                <div class="border-top p-3 bg-white">
                    <form method="POST" action="#">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Écrire un message..." required>
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newGroup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <form method="POST" action="../../processes/create_group.php">
                <div class="modal-header">
                    <h5 class="modal-title">Créer une conversation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nom du groupe</label>
                        <input class="form-control" name="nom" type="text">
                    </div>
                    <div class="mb-3">
                        <label>Avec :</label>
                        <div id="guests-container"></div>
                        <input class="form-control"type="" name="guests[]" id="hiddenGuests">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Fermer</button>
                    <button class="btn btn-primary" type="submit">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    console.log("JS chargé !");
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchUser");
        const resultsContainer = document.getElementById("searchResults");
        searchInput.addEventListener("input", () => {
            const query = searchInput.value.trim();
            if (query.length < 2) {
                resultsContainer.innerHTML = "";
                return;
            }
            fetch("../../processes/search_user.php?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    console.log("Résultats AJAX :", data); // 🧪

                .then(data => {
                    resultsContainer.innerHTML = "";
                    if (data.length === 0) {
                        resultsContainer.innerHTML = "<div class='list-group-item text-muted'>Aucun utilisateur trouvé</div>";
                    } else {
                        data.forEach(user => {
                            const item = document.createElement("a");
                            item.className = "list-group-item list-group-item-action";
                            item.addEventListener("click", () => {
                                const container = document.getElementById("guests-container");
                                const input = document.createElement("input");
                                input.type = "hidden";
                                input.name = "guests[]";
                                input.value = user.pseudo;

                                const label = document.createElement("div");
                                label.className = "badge bg-primary text-white me-2";
                                label.textContent = user.pseudo;

                                container.appendChild(label);
                                container.appendChild(input);
                                resultsContainer.innerHTML = "";
                                searchInput.value = "";
                            });
                            item.textContent = user.pseudo;
                            resultsContainer.appendChild(item);
                        });
                    }
                });
        });
        document.addEventListener("click", (e) => {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.innerHTML = "";
            }
        });
    });
</script>

<?php include_once $includesGlobal . 'footer.php'; ?>
