<?php

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

$root = $_SERVER['DOCUMENT_ROOT'];

include_once $includesConfig . "config.php";

$user = $_SESSION['user_info'];

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";
?>
<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid px-0" id="content">
        <section class="text-white py-5" style="background-color: #3a3a3a;">
            <div class="text-center">
                <h2 class="fw-bold">Créer ou Rejoindre un Match</h2>
                <p class="mb-4">Connectez-vous avec d'autres personnes et profitez d’un match fait pour vous !</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-outline-light px-4">Rejoindre un Match</a>
                    <a href="create-match" class="btn btn-light text-dark px-4">Créer un Match</a>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Matchs Disponibles à Rejoindre</h3>
                <p>Parcourez les matchs auxquels vous pouvez participer.</p>
                <button class="btn btn-dark px-4 mt-2">Rejoindre maintenant</button>
            </div>

            <div class="d-flex justify-content-center">
                <div class="card w-75 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Tournoi de Basketball</h5>
                        <p class="card-text">Montrez vos talents sur le terrain.<br>
                            <strong>8 joueurs nécessaires</strong>. Lieu : Gymnase Communautaire. Heure : Dimanche, 11h.
                        </p>
                        <span class="badge bg-secondary me-1">Basketball</span>
                        <span class="badge bg-secondary">Tournoi</span>
                        <div class="mt-3 text-muted"><i class="bi bi-person-circle"></i> Jane Smith</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Your Matches Section -->
        <section class="bg-light py-5">
            <div class="container">
                <h4 class="fw-bold mb-4">Vos Matchs</h4>
                <p>Gérez vos matchs</p>
                <div class="d-flex align-items-center gap-4 mt-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/732/732219.png" alt="Basketball Icon" width="60" height="60">
                    <div>
                        <h5 class="mb-1">Tournoi de Basketball</h5>
                        <p class="mb-1 text-muted">Gymnase Communautaire. Heure : Dimanche, 11h</p>
                        <strong>8 joueurs nécessaires</strong>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
