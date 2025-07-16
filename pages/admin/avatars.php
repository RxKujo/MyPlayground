<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

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
        <h2>Gestion des Avatars</h2>
        <button class="btn btn-success mb-3 open-new-modal" data-bs-toggle="modal" data-bs-target="#newCaptcha">Ajouter un avatar</button>

        <?php
            function afficherImages($categorie) {
                $chemin = "../../assets/public/img/avatars/$categorie/";
                if (is_dir($chemin)) {
                    $fichiers = scandir($chemin);
                    foreach ($fichiers as $fichier) {
                        if ($fichier !== '.' && $fichier !== '..') {
                            echo "<img src='$chemin$fichier' alt='$categorie' class='img-fluid border rounded shadow-sm hover-shadow' />";
                        }
                    }
                }
            }
        ?>
        <div class="mb-5">
            <h3 class="mb-3">Corps</h3>
            <div class="">
                <?php afficherImages("base") ?>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-3">Yeux</h3>
            <div class="">
                <?php afficherImages("eyes") ?>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-3">Nez</h3>
            <div class="">
                <?php afficherImages("noses") ?>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mb-3">Bouche</h3>
            <div class="">
                <?php afficherImages("mouths") ?>
            </div>
        </div>
    </div>
</div>
<div id="dynamic-modal-container"></div>

<?php include_once $includesGlobal . "footer.php";