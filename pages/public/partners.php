<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("/");

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : '';
$poste = isset($_GET['poste']) ? $_GET['poste'] : '';

$results = computeDistances($pdo, $user['id']);

function safe($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

?>

<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'settings';
        }
        include_once "navbar/navbar.php";
    ?>    

    <div class="container-fluid px-0" id="content">                
        <div id="partners-page">
            <section class="text-white py-5" style="background-color: #3a3a3a;">
                <div class="text-center">
                    <h2 class="fs-1 fw-bold text-center text-white mb-4">Filtrez vos coéquipiers</h2>
                    <p class="fs-6 text-center text-white mb-0">Connectez-vous avec d'autres personnes et profitez d’un match fait pour vous !</p>
                </div>
            </section>

            <div class="container py-4">
                <h2 class="fs-2 fw-bold mb-4">Filtres</h2>

                <form class="row gy-4 gx-5 align-items-end" method="GET" action="partners">
                    <div class="col-md-4">
                        <h5 class="mb-3">Niveau</h5>
                        <div class="btn-group-vertical w-100" data-bs-toggle="buttons">
                            <label class="btn btn-outline-primary<?= ($niveau === '0') ? ' active' : '' ?>">
                                <input type="radio" name="niveau" value="0" autocomplete="off" <?= ($niveau === '0') ? 'checked' : '' ?>> Débutant
                            </label>
                            <label class="btn btn-outline-primary<?= ($niveau === '1') ? ' active' : '' ?>">
                                <input type="radio" name="niveau" value="1" autocomplete="off" <?= ($niveau === '1') ? 'checked' : '' ?>> Intermédiaire
                            </label>
                            <label class="btn btn-outline-primary<?= ($niveau === '2') ? ' active' : '' ?>">
                                <input type="radio" name="niveau" value="2" autocomplete="off" <?= ($niveau === '2') ? 'checked' : '' ?>> Avancé
                            </label>
                            <label class="btn btn-outline-primary<?= ($niveau === '3' || $niveau === '') ? ' active' : '' ?>">
                                <input type="radio" name="niveau" value="3" autocomplete="off" <?= ($niveau === '3' || $niveau === '') ? 'checked' : '' ?>> Tous
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h5 class="mb-3">Poste</h5>
                        <div class="btn-group-vertical w-100" data-bs-toggle="buttons">
                            <label class="btn btn-outline-success<?= ($poste === '0') ? ' active' : '' ?>">
                                <input type="radio" name="poste" value="0" autocomplete="off" <?= ($poste === '0') ? 'checked' : '' ?>> Meneur de jeu
                            </label>
                            <label class="btn btn-outline-success<?= ($poste === '1') ? ' active' : '' ?>">
                                <input type="radio" name="poste" value="1" autocomplete="off" <?= ($poste === '1') ? 'checked' : '' ?>> Arrière
                            </label>
                            <label class="btn btn-outline-success<?= ($poste === '2') ? ' active' : '' ?>">
                                <input type="radio" name="poste" value="2" autocomplete="off" <?= ($poste === '2') ? 'checked' : '' ?>> Ailier
                            </label>
                            <label class="btn btn-outline-success<?= ($poste === '3') ? ' active' : '' ?>">
                                <input type="radio" name="poste" value="3" autocomplete="off" <?= ($poste === '3') ? 'checked' : '' ?>> Ailier fort
                            </label>
                            <label class="btn btn-outline-success<?= ($poste === '4') ? ' active' : '' ?>">
                                <input type="radio" name="poste" value="4" autocomplete="off" <?= ($poste === '4') ? 'checked' : '' ?>> Pivot
                            </label>
                            <label class="btn btn-outline-success<?= ($poste === '5' || $poste === '') ? ' active' : '' ?>">
                                <input type="radio" name="poste" value="5" autocomplete="off" <?= ($poste === '5' || $poste === '') ? 'checked' : '' ?>> Tous
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Valider</button>
                    </div>
                </form>
            </div>

            <div class="container py-4">
                <h2 class="fw-bold">Coéquipiers</h2>
                <div class="row g-4">
                    <?php foreach($results as $mate): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($mate['prenom'] . ' ' . $mate['nom']) ?></h5>
                                    <p class="card-text mb-1">Pseudo : <?= htmlspecialchars($mate['pseudo']) ?></p>
                                    <p class="card-text mb-1">Niveau : <?= getUserLevel($mate) ?></p>
                                    <p class="card-text mb-1">Poste : <?= getUserPosition($mate) ?></p>
                                    <p class="card-text mb-3">Ville : <?= $mate['ville_nom'] ?> (<?= $mate['cp'] ?>) à <?= $mate['distance_km'] ?> km</p>
                                    <a href="profil_user?id=<?= urlencode($mate['id']) ?>" class="btn btn-primary mt-auto">Profil</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>            
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
