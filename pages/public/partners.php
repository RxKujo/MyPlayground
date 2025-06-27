<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : '';
$poste = isset($_GET['poste']) ? $_GET['poste'] : '';


$sql = "SELECT id, prenom, nom, pseudo, niveau, poste, localisation, pfp FROM utilisateur WHERE id != :id";
$params = [':id' => $user['id']];

if ($niveau !== '' && $niveau !== '3') {
    $sql .= " AND niveau = :niveau";
    $params[':niveau'] = $niveau;
}

if ($poste !== '' && $poste !== '5') {
    $sql .= " AND poste = :poste";
    $params[':poste'] = $poste;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <p class="fs-6 text-cetner text-white mb-0">Connectez-vous avec d'autres personnes et profitez d’un match fait pour vous !</p>
                </div>
            </section>
            
            <div class="container py-4">
                <h2 class="fs-2 fw-bold">Filtres</h2>
                <div class="accordion" id="accordion-filter1">
                    <form class="d-flex flex-row gap-4 align-items-start" method="GET" action="partners">
                        <div style="width: 180px;">
                            <h5>Niveau</h5>
                            <fieldset>
                                <div class="btn-group-vertical w-100" data-bs-toggle="buttons">
                                    <label class="btn btn-outline-primary<?= ($niveau === '0') ? ' active' : '' ?>">
                                        <input type="radio" name="niveau" id="lvl1" value="0" autocomplete="off" <?= ($niveau === '0') ? 'checked' : '' ?>> Débutant
                                    </label>
                                    <label class="btn btn-outline-primary<?= ($niveau === '1') ? ' active' : '' ?>">
                                        <input type="radio" name="niveau" id="lvl2" value="1" autocomplete="off" <?= ($niveau === '1') ? 'checked' : '' ?>> Intermédiaire
                                    </label>
                                    <label class="btn btn-outline-primary<?= ($niveau === '2') ? ' active' : '' ?>">
                                        <input type="radio" name="niveau" id="lvl3" value="2" autocomplete="off" <?= ($niveau === '2') ? 'checked' : '' ?>> Avancé
                                    </label>
                                    <label class="btn btn-outline-primary<?= ($niveau === '3' || $niveau === '') ? ' active' : '' ?>">
                                        <input type="radio" name="niveau" id="anylvl" value="3" autocomplete="off" <?= ($niveau === '3' || $niveau === '') ? 'checked' : '' ?>> Tous
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <div style="width: 180px;">
                            <h5>Poste</h5>
                            <fieldset>
                                <div class="btn-group-vertical w-100" data-bs-toggle="buttons">
                                    <label class="btn btn-outline-success<?= ($poste === '0') ? ' active' : '' ?>">
                                        <input type="radio" name="poste" id="pos1" value="0" autocomplete="off" <?= ($poste === '0') ? 'checked' : '' ?>> Meneur de jeu
                                    </label>
                                    <label class="btn btn-outline-success<?= ($poste === '1') ? ' active' : '' ?>">
                                        <input type="radio" name="poste" id="pos2" value="1" autocomplete="off" <?= ($poste === '1') ? 'checked' : '' ?>> Arrière
                                    </label>
                                    <label class="btn btn-outline-success<?= ($poste === '2') ? ' active' : '' ?>">
                                        <input type="radio" name="poste" id="pos3" value="2" autocomplete="off" <?= ($poste === '2') ? 'checked' : '' ?>> Ailier
                                    </label>
                                    <label class="btn btn-outline-success<?= ($poste === '3') ? ' active' : '' ?>">
                                        <input type="radio" name="poste" id="pos4" value="3" autocomplete="off" <?= ($poste === '3') ? 'checked' : '' ?>> Ailier fort
                                    </label>
                                    <label class="btn btn-outline-success<?= ($poste === '4') ? ' active' : '' ?>">
                                        <input type="radio" name="poste" id="pos5" value="4" autocomplete="off" <?= ($poste === '4') ? 'checked' : '' ?>> Pivot
                                    </label>
                                    <label class="btn btn-outline-success<?= ($poste === '5' || $poste === '') ? ' active' : '' ?>">
                                        <input type="radio" name="poste" id="posAll" value="5" autocomplete="off" <?= ($poste === '5' || $poste === '') ? 'checked' : '' ?>> Tous
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </div>

            <div class="container py-4">
                <h2 class="fw-bold">Coéquipiers</h2>
                <div class="container row g-4">
                    <?php
                        foreach($results as $mate) {
                            echo displayCardUser($mate);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>            
</div>

<?php include_once $includesGlobal . "footer.php"; ?>