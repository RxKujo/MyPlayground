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
    <?php
        include_once "navbar/navbar.php";
    ?>    

    <div class="container-fluid px-0" id="content">
        <div class="d-flex align-items-center welcome-section">
            <div class="ms-5 px-5">
                <img class="profile-img" src="<?= $pfpSrc ?>" alt="Photo de profil"/>
            </div>

            <div class="me-auto">
                <div>
                    <h3 class="text-white mb-0">Bienvenue, <?= $user["prenom"] ?>!</h3>
                    <span class="badge bg-dark-subtle my-2 text-black">
                        Jouez près de chez vous
                    </span>
                    <span class="badge bg-dark-subtle my-2 text-black">
                        NOUVEAUX tournois
                    </span>
                </div>
            </div>
            
            <div class="d-flex flex-column m-auto">
                <a href="partners" id="find-button" class="btn btn-outline-light m-2">Trouver des coéquipiers</a>
                <a href="tournaments" id="tournament-button" class="btn btn-dark m-2">Rejoindre un tournoi</a>
            </div>
        </div>


        <div class="d-flex mt-4 mx-auto">
            <div class="d-flex align-items-center mx-5 search-partners-section">
                <div class="d-flex align-items-center flex-column">
                    <h3 class="fs-2 fw-bold">Chercher des coéquipiers</h3>
                    <p>Sélectionnez le niveau et le poste de votre partenaire idéal</p>
                </div>
            </div>

            <form id="search-filters" class="d-flex flex-column align-items-start mx-5" method="GET" action="partners">
                <div class="my-3 me-5">
                    <h4>Niveau</h4>
                    <div class="d-inline-flex gap-2 flex-wrap">
                        <div>
                            <input id="niveau-debutant" name="niveau[]" type="checkbox" class="btn-check" value="0">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="niveau-debutant">Débutant</label>
                        </div>

                        <div>
                            <input id="niveau-intermediaire" name="niveau[]" type="checkbox" class="btn-check" value="1">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="niveau-intermediaire">Intermédiaire</label>
                        </div>

                        <div>
                            <input id="niveau-avance" name="niveau[]" type="checkbox" class="btn-check" value="2">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="niveau-avance">Avancé</label>
                        </div>

                        <div>
                            <input id="niveau-pro" name="niveau[]" type="checkbox" class="btn-check" value="3">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="niveau-pro">Pro</label>
                        </div>
                    </div>
                </div>

                <div class="my-3">
                    <h4>Poste</h4>
                    <div class="d-inline-flex gap-2 flex-wrap">
                        <div>
                            <input id="poste-mj" name="poste[]" type="checkbox" class="btn-check" value="0">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="poste-mj">Meneur de jeu</label>
                        </div>
                        <div>
                            <input id="poste-ar" name="poste[]" type="checkbox" class="btn-check" value="1">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="poste-ar">Arrière</label>
                        </div>
                        <div>
                            <input id="poste-ai" name="poste[]" type="checkbox" class="btn-check" value="2">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="poste-ai">Ailier</label>
                        </div>
                        <div>
                            <input id="poste-af" name="poste[]" type="checkbox" class="btn-check" value="3">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="poste-af">Ailier fort</label>
                        </div>
                        <div>
                            <input id="poste-p" name="poste[]" type="checkbox" class="btn-check" value="4">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="poste-p">Pivot</label>
                        </div>
                        <div>
                            <input id="poste-all" name="poste[]" type="checkbox" class="btn-check" value="5">
                            <label type="button" aria-pressed="false" class="btn btn-outline-secondary" for="poste-all">Tous</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-evenly mt-5 mx-auto">
                    <button type="reset" id="clear-button" class="btn btn-dark me-5 px-xl py-2">Clear</button>
                    <button type="submit" id="search-button" class="btn btn-outline-dark ms-5 px-xl py-2">Search</button>
                </div>
            </form>
        </div>

        <div class="mt-4">
            <div class="d-flex flex-column align-items-center mx-5">
                <h3 class="fs-2 fw-bold">Recommended Partners</h3>
                <div class="d-flex justify-content-evenly mx-auto">
                    <button class="btn btn-dark me-5 px-4 py-2">View Profile</button>
                    <button class="btn btn-outline-dark ms-5 px-5 py-2">Invite</button>
                </div>
            </div>
            <div class="d-flex gap-4 recommended-profiles">
                
            </div>
        </div>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
