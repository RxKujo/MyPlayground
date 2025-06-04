<?php

include_once '../../includes/global/session.php';

if (!isset($_SESSION['user_info'])) {
    header("location: ../../index.php");
    exit();
}
include_once $includesConfig . "config.php";

$user = $_SESSION['user_info'];

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
                <img class="profile-img" src="../../assets/public/img/morad.png" alt="Photo de profil"/>
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

            <div id="search-filters" class="d-flex flex-column align-items-start mx-5">
                <div class="my-3 me-5">
                    <h4>Niveau</h4>
                    <span class="d-inline-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="beginner">Débutant</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="intermediate">Intermédiaire</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="advanced">Avancé</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="pro">Pro</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="tous">Tous</button>
                    </span>
                </div>
                <div class="my-3">
                    <h4>Poste</h4>
                    <div class="d-inline-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="PG">Meneur de jeu</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="SG">Arrière</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="SF">Ailier</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="PF">Ailier fort</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="C">Pivot</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="button" data-filter="NA">Tous</button>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly mt-5 mx-auto">
                    <button id="clear-button" class="btn btn-dark me-5 px-xl py-2">Clear</button>
                    <button id="search-button" class="btn btn-outline-dark ms-5 px-xl py-2">Search</button>
                </div>
            </div>
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
